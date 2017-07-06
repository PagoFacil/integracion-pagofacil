using System;
using System.Collections;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Net;
using System.Text;
using Newtonsoft.Json;
using PagoFacil.Token;

namespace PagoFacil.Token
{
	public class PagofacilToken
	{
		private string idUsuario { get; set; }
		private string llaveEncriptacion { get; set; }
		public static bool modoProduccion;
		//Endpoint´s
		private static string WS_ALTA;
		private static string WS_COBRO;
		private static string WS_BAJA;


		public PagofacilToken(string strIdUsuario, string strLlave)
		{
			try
			{
				if ("".Equals(strIdUsuario) || "".Equals(strLlave))
				{
					throw new Exception("Faltan Datos idUsuario o ApiSecret");
				}

				if (!modoProduccion)
				{//Desarrollo
					WS_ALTA = "https://stapi.pagofacil.net/CobroToken/Altatoken";
					WS_BAJA = "https://stapi.pagofacil.net/CobroToken/Bajatoken";
					WS_COBRO = "https://stapi.pagofacil.net/CobroToken/Transacciontoken";
				}
				else {//Produccion
					WS_ALTA = "https://www.pagofacil.net/ws/public/CobroToken/Altatoken";
					WS_BAJA = "https://www.pagofacil.net/ws/public/CobroToken/Bajatoken";
					WS_COBRO = "https://www.pagofacil.net/ws/public/CobroToken/Transacciontoken";
				}
				idUsuario = strIdUsuario;
				llaveEncriptacion = strLlave;
			}
			catch (Exception exc)
			{
				exc.Message.ToString();
			}
		}


		public static void ambienteProduccionActivo(bool param)
		{
			modoProduccion = param;
		}


		/**
		 * Metodo para tokenizar una TC
		 * @param data
		 * @return Respuesta del WS
		 * @throws MalformedURLException
		 * @throws IOException
		 * @throws ProtocolException
		 * @throws NoSuchAlgorithmException
		 * @throws IllegalBlockSizeException
		 * @throws InvalidKeyException
		 * @throws BadPaddingException
		 * @throws InvalidAlgorithmParameterException
		 * @throws NoSuchPaddingException 
		 */
		public string altaToken(Dictionary<string, string> data)
		{
			return this.peticionWS(data, WS_ALTA);
		}

		public string cobroToken(Dictionary<string, string> data)
		{
			return this.peticionWS(data, WS_COBRO);
		}

		public string bajaToken(Dictionary<string, string> data)
		{
			return this.peticionWS(data, WS_BAJA);
		}

		/**
		 * Recibe un obj Json con los parametros a enviar
		 * @param paramsEncrypted
		 * @return String Respuesta del WS
		 * @throws ProtocolException
		 * @throws MalformedURLException
		 * @throws IOException
		 */
		private string peticionWS(Dictionary<string, string> data, string endPoint)
		{
			var jsonStr = JsonConvert.SerializeObject(data, Formatting.None);
			Console.WriteLine("jsonStr: {0}\n" + jsonStr);

			//Encriptacion AES 
			var objAES = new PagoFacilAES();
			string strEncriptada = objAES.Encrypt(jsonStr, llaveEncriptacion);
			Console.WriteLine("strEncriptada: {0}\n" + strEncriptada);

			//Peticiones al WS
			var wb = new WebClient();
			var dataSend = new NameValueCollection();
			dataSend["idUsuario"] = idUsuario;
			dataSend["data"] = strEncriptada;

			//URL url = new URL(endPoint);
			var response = wb.UploadValues(endPoint, "POST", dataSend);
			var responseString = Encoding.Default.GetString(response);
			Console.WriteLine("Response String: {0}\n", responseString);
			var decodeJson = (string)JsonConvert.DeserializeObject(responseString);
			Console.WriteLine("Response JsonDecode: {0}\n", decodeJson);
			return decodeJson;
		}

	}

}
