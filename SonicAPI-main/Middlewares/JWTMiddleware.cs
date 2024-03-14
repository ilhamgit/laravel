using Microsoft.AspNetCore.Http;
using Microsoft.Extensions.Configuration;
using Microsoft.IdentityModel.Tokens;
using SonicAPI.Interfaces;
using SonicAPI.Models.DbSets;
using System;
using System.IdentityModel.Tokens.Jwt;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SonicAPI.Middlewares
{
    public class JWTMiddleware
    {
        private readonly RequestDelegate next;
        private readonly IConfiguration configuration;
        private readonly IBaseService baseService;

        public JWTMiddleware(RequestDelegate next, IConfiguration configuration, IBaseService baseService)
        {
            this.next = next;
            this.configuration = configuration;
            this.baseService = baseService;
        }

        public async Task Invoke(HttpContext context)
        {
            var token = GetToken(context.Request.Headers["Authorization"].FirstOrDefault()?.Split(" ").Last());

            if (token != null)
                await attachAccountToContext(context, token).ConfigureAwait(false);

            await this.next(context);
        }

        private async Task attachAccountToContext(HttpContext context, string token)
        {
            try
            {
                var tokenHandler = new JwtSecurityTokenHandler();

                if (tokenHandler.CanReadToken(token))
                {
                    var key = Encoding.ASCII.GetBytes(this.configuration["JWT:General:Key"]);
                    tokenHandler.ValidateToken(token, new TokenValidationParameters
                    {
                        ValidateIssuerSigningKey = true,
                        IssuerSigningKey = new SymmetricSecurityKey(key),
                        ValidateLifetime = true,
                        ValidateIssuer = true,
                        ValidateAudience = true,
                        ValidIssuer = this.configuration["JWT:General:Issuer"],
                        ValidAudience = this.configuration["JWT:General:Audience"],
                        // set clockskew to zero so tokens expire exactly at token expiration time (instead of 5 minutes later)
                        ClockSkew = TimeSpan.Zero
                    }, out SecurityToken validatedToken);

                    var jwtToken = (JwtSecurityToken)validatedToken;
                    var userIdStr = jwtToken.Claims?.Where(x => x.Type == "id").FirstOrDefault()?.Value;
                    var sessionIdStr = jwtToken.Claims?.Where(x => x.Type == "sessionid").FirstOrDefault()?.Value;
                    var adminUsernameStr = jwtToken.Claims?.Where(x => x.Type == "adminusername").FirstOrDefault()?.Value;
                    var adminPasswordStr = jwtToken.Claims?.Where(x => x.Type == "adminpassword").FirstOrDefault()?.Value;

                    if (!string.IsNullOrEmpty(adminUsernameStr) &&
                        !string.IsNullOrEmpty(adminPasswordStr))
                    {
                        if (Helpers.Extensions.IsBase64String(adminUsernameStr) &&
                            Helpers.Extensions.IsBase64String(adminPasswordStr))
                        {
                            var adminUsername = Helpers.Extensions.AESDecryption(adminUsernameStr);
                            var adminPassword = Helpers.Extensions.AESDecryption(adminPasswordStr);

                            // attach account to context on successful jwt validation
                            context.Items["User"] = await this.baseService.GetAdminUserByCredentials(adminUsername, adminPassword).ConfigureAwait(false);

                            var account = (User)context.Items["User"];
                            if (account == null)
                            {
                                context.Items["User"] = new User
                                {
                                    UserId = -999
                                };
                            }
                        }
                    }
                    else
                    {
                        long.TryParse(userIdStr, out long userId);
                        Guid.TryParse(sessionIdStr, out Guid sessionId);

                        // attach account to context on successful jwt validation
                        context.Items["User"] = await this.baseService.GetLatestUserLoginHistory(userId, sessionId).ConfigureAwait(false);

                        var account = (User)context.Items["User"];
                        if (account == null)
                        {
                            context.Items["User"] = new User
                            {
                                UserId = -999
                            };
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                // do nothing if jwt validation fails
                // account is not attached to context so request won't have access to secure routes
                context.Items["User"] = new User
                {
                    UserId = -998,
                    Username = @ex.Message
                };
            }
        }

        private string GetToken(string token)
        {
            if (!string.IsNullOrEmpty(token))
            {
                var lastUncessaryChar = token.LastIndexOf(@"\");

                if (lastUncessaryChar > -1)
                {
                    token = token.Substring(0, (token.LastIndexOf(@"\")));
                }
            }
            else
            {
                token = string.Empty;
            }

            return token;
        }
    }
}