using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Filters;
using SonicAPI.Models.DbSets;
using System;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;

namespace SonicAPI.Helpers
{
    [AttributeUsage(AttributeTargets.Class | AttributeTargets.Method)]
    public class JWTAuthorizeAttribute : Attribute, IAuthorizationFilter
    {
        public void OnAuthorization(AuthorizationFilterContext context)
        {
            var account = (User)context.HttpContext.Items["User"];
            if (account == null)
            {
                // not logged in
                var token = GetToken(context.HttpContext.Request.Headers["Authorization"].FirstOrDefault());
                context.Result = new JsonResult(new { message = $"You are not authorized to access due to invalid token. { token }" }) { StatusCode = StatusCodes.Status401Unauthorized };
            }
            else if (account.UserId == -999)
            {
                // not logged in
                context.Result = new JsonResult(new { message = "You are not authorized to access." }) { StatusCode = StatusCodes.Status401Unauthorized };
            }
            else if (account.UserId == -998)
            {
                // not logged in
                var token = GetToken(context.HttpContext.Request.Headers["Authorization"].FirstOrDefault());
                context.Result = new JsonResult(new { message = $"You are not authorized to access. { @account.Username } { token }" }) { StatusCode = StatusCodes.Status401Unauthorized };
            }
        }

        private string GetToken (string token)
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