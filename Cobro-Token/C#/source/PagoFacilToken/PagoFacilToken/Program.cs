using System;
using System.Collections.Generic;
using PagoFacil.Token;

//Implementacion
namespace PagoFacil.Token
{
	class MainClass
	{
		//Dev
		private static string key = "XXXXX";
		private static string idUsuario = "XXXXX";
		private static string idSucursal = "XXXXX";


		public static void Main(string[] args)
		{
			//Activar modo produccion
			//PagoFacilToken.ambienteProduccionActivo(true);

			//Inicializar Obj PagoFacilToken
			var objToken = new PagofacilToken(idUsuario, key);
			//Inicializar obj AES para desencriptar la respuesta obtenida
			var objAes = new PagoFacilAES();

			////////////////////////
			//     Alta token     //
			////////////////////////
			//Creando array asociativo, con parametros para AltaToken
			var data = new Dictionary<string, string>
			{
				{"idSucursal", idSucursal},
				{"idUsuario", idUsuario},
				{"nombre", "Juan"},
				{"apellidos", "Alvarado"},
				{"numeroTarjeta", "XXXXX"},
				{"cvt", "XXX"},
				{"mesExpiracion", "XX"},
				{"anyoExpiracion", "XX"},
				{"email", "user@serv.com"},
				{"telefono", "XXXXX"},
				{"celular", "XXXXX"},
				{"calleyNumero", "anatole france 311"},
				{"colonia", "polanco"},
				{"municipio", "miguel hidalgo"},
				{"estado", "CDMX"},
				{"cp", "11000"}
			};

			//string respAlta = objToken.altaToken(data);
			//Console.WriteLine("RespAlta: {0}" + respAlta);
			//Console.WriteLine("RespAlta-Decode: {0}" + objAes.Decrypt(respAlta, key));

			////////////////////////
			//     Cobro token    //
			////////////////////////
			//Creando array asociativo, con parametros para AltaToken
			var dataCobro = new Dictionary<string, string>
			{
				{"idSucursal", idSucursal},
				{"idUsuario", idUsuario},
				{"token", "XXXXX"},
				{"monto", "59.99"},
				{"idPedido", "TestPf890a1"},
				{"param1", "----------"}
			};
			//string respCobro = objToken.cobroToken(dataCobro);
			//Console.WriteLine("RespCobro: {0}\n" + respCobro);
			//Console.WriteLine("RespCobro-Decode: {0}\n" + objAes.Decrypt(respCobro, key));

			////////////////////////
			//   Baja de Token    //
			////////////////////////
			var dataBaja = new Dictionary<string, string>
			{
				{"idSucursal", idSucursal},
				{"idUsuario", idUsuario},
				{"token", "XXXXX"},
				{"autorizacion", "XXXXXX"}
			};

			string respBaja = objToken.bajaToken(dataBaja);
			Console.WriteLine("RespBaja: " + respBaja);
			Console.WriteLine("RespBaja-Decode: " + objAes.Decrypt(respBaja, key));
		}//End Main
	}//End Class
}
