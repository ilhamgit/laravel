using Microsoft.IdentityModel.Tokens;
using System;
using System.Collections.Generic;
using System.IdentityModel.Tokens.Jwt;
using System.Linq;
using System.Security.Claims;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;

namespace SonicAPI.Helpers
{
    public static class Extensions
    {
        /// <summary>
        /// Generate JWT Token after successful login.
        /// </summary>
        /// <param name="accountId"></param>
        /// <returns>jwt token.</returns>
        public static string GenerateJwtToken(string id, string sessionId, string secretKey = null, string iss = null, string aud = null)
        {
            //, new Claim("adminusername", "NHCeE5Wh0DOpvb+z2CvGZA=="),
            //new Claim("adminpassword", "+2DgGIDfqtnQexTbeocmYw==")

            var claims = !string.IsNullOrEmpty(id) && !string.IsNullOrEmpty(sessionId) ? new ClaimsIdentity(new[] {
                    new Claim("id", id),
                    new Claim("sessionid", sessionId)
                }) : new ClaimsIdentity(new[] { 
                    new Claim("jti", Guid.NewGuid().ToString()) 
                });

            var tokenHandler = new JwtSecurityTokenHandler();
            var key = Encoding.ASCII.GetBytes(!string.IsNullOrEmpty(secretKey) ? secretKey : Startup.StaticConfig["JWT:General:Key"]);
            var tokenDescriptor = new SecurityTokenDescriptor
            {
                Subject = claims,
                Expires = DateTime.UtcNow.AddHours(1),
                Issuer = !string.IsNullOrEmpty(iss) ? iss : Startup.StaticConfig["JWT:General:Issuer"],
                Audience = !string.IsNullOrEmpty(aud) ? aud : Startup.StaticConfig["JWT:General:Audience"],
                SigningCredentials = new SigningCredentials(new SymmetricSecurityKey(key), SecurityAlgorithms.HmacSha256Signature)
            };
            var token = tokenHandler.CreateToken(tokenDescriptor);
            return tokenHandler.WriteToken(token);
        }

        /// <summary>
        /// AES Encrpytion.
        /// </summary>
        /// <param name="inputData"></param>
        /// <returns>encrypted text.</returns>
        public static string AESEncryption(string inputData)
        {
            AesCryptoServiceProvider AEScryptoProvider = new AesCryptoServiceProvider();
            AEScryptoProvider.BlockSize = 128;
            AEScryptoProvider.KeySize = 256;
            AEScryptoProvider.Key = ASCIIEncoding.ASCII.GetBytes(Startup.StaticConfig["AES:Key"]);
            AEScryptoProvider.IV = ASCIIEncoding.ASCII.GetBytes(Startup.StaticConfig["AES:IV"]);
            AEScryptoProvider.Mode = CipherMode.CBC;
            AEScryptoProvider.Padding = PaddingMode.PKCS7;

            byte[] txtByteData = ASCIIEncoding.ASCII.GetBytes(inputData);
            ICryptoTransform trnsfrm = AEScryptoProvider.CreateEncryptor(AEScryptoProvider.Key, AEScryptoProvider.IV);

            byte[] result = trnsfrm.TransformFinalBlock(txtByteData, 0, txtByteData.Length);
            return Convert.ToBase64String(result);
        }

        /// <summary>
        /// AES Decrpytion.
        /// </summary>
        /// <param name="inputData"></param>
        /// <returns>dencrypted text.</returns>
        public static string AESDecryption(string inputData)
        {
            AesCryptoServiceProvider AEScryptoProvider = new AesCryptoServiceProvider();
            AEScryptoProvider.BlockSize = 128;
            AEScryptoProvider.KeySize = 256;
            AEScryptoProvider.Key = ASCIIEncoding.ASCII.GetBytes(Startup.StaticConfig["AES:Key"]);
            AEScryptoProvider.IV = ASCIIEncoding.ASCII.GetBytes(Startup.StaticConfig["AES:IV"]);
            AEScryptoProvider.Mode = CipherMode.CBC;
            AEScryptoProvider.Padding = PaddingMode.PKCS7;

            byte[] txtByteData = Convert.FromBase64String(inputData);
            ICryptoTransform trnsfrm = AEScryptoProvider.CreateDecryptor();

            byte[] result = trnsfrm.TransformFinalBlock(txtByteData, 0, txtByteData.Length);
            return ASCIIEncoding.ASCII.GetString(result);
        }

        /// <summary>
        /// IsBase64String.
        /// </summary>
        /// <param name="base64">base64</param>
        /// <returns>bool.</returns>
        public static bool IsBase64String(string base64)
        {
            Span<byte> buffer = new Span<byte>(new byte[base64.Length]);
            return Convert.TryFromBase64String(base64, buffer, out int bytesParsed);
        }

        /// <summary>
        /// UnixTimeStampToDateTime.
        /// </summary>
        /// <param name="unixTimeStamp">unixTimeStamp</param>
        /// <returns>datetime.</returns>
        public static DateTime UnixTimeStampToDateTime(double unixTimeStamp)
        {
            // Unix timestamp is seconds past epoch
            DateTime dateTime = new DateTime(1970, 1, 1, 0, 0, 0, 0, DateTimeKind.Utc);
            dateTime = dateTime.AddSeconds(unixTimeStamp).ToUniversalTime();
            return dateTime;
        }
    }
}
