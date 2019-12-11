using System;
using System.Text;
using System.Security.Cryptography;


namespace PagoFacil.Token
{
	public class PagoFacilAES
	{
		public PagoFacilAES()
		{
		}


		/**
		 * Definicion de parametros del objeto Rijndael
		 */
		public RijndaelManaged GetRijndaelManaged(string secretKey)
		{
			var keyBytes = new byte[16];
			var secretKeyBytes = Encoding.UTF8.GetBytes(secretKey);
			Array.Copy(secretKeyBytes, keyBytes, Math.Min(keyBytes.Length, secretKeyBytes.Length));
			return new RijndaelManaged
			{
				Mode = CipherMode.CBC,
				Padding = PaddingMode.PKCS7,
				KeySize = 128,
				BlockSize = 128,
				Key = keyBytes,
				IV = keyBytes
			};
		}

		public byte[] Encrypt(byte[] plainBytes, RijndaelManaged rijndaelManaged)
		{
			return rijndaelManaged.CreateEncryptor()
				.TransformFinalBlock(plainBytes, 0, plainBytes.Length);
		}

		public byte[] Decrypt(byte[] encryptedData, RijndaelManaged rijndaelManaged)
		{
			return rijndaelManaged.CreateDecryptor()
				.TransformFinalBlock(encryptedData, 0, encryptedData.Length);
		}

		/**
		 * Metodo para Encriptar
		 * @param String plainText
		 * @param String key
		 */
		public string Encrypt(string plainText, string key)
		{
			var plainBytes = Encoding.UTF8.GetBytes(plainText);
			return Convert.ToBase64String(Encrypt(plainBytes, GetRijndaelManaged(key)));
		}


		/**
		 * Metodo para desencriptar 
		 * @param String encryptedText Cadena codificada en Base64
		 * @param String key Llave de encripracion
		 */
		public string Decrypt(string encryptedText, string key)
		{
			var encryptedBytes = Convert.FromBase64String(encryptedText);
			return Encoding.UTF8.GetString(Decrypt(encryptedBytes, GetRijndaelManaged(key)));
		}

	}
}
