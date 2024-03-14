using Newtonsoft.Json;
using SonicAPI.Interfaces;
using SonicAPI.Models;
using System;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;

namespace SonicAPI.Services
{
    public class BaseClient : IBaseClient
    {
        private readonly IHttpClientFactory clientFactory;

        public BaseClient(IHttpClientFactory clientFactory)
        {
            this.clientFactory = clientFactory;
        }

        public async Task<HttpResponseMessage> PostAsync<T>(T rawRequest, string endpoint, string key)
        {
            var token = Helpers.Extensions.GenerateJwtToken(null, null, key);

            try
            {
                var request = new HttpRequestMessage(HttpMethod.Post, endpoint);
                var content = new StringContent(JsonConvert.SerializeObject(rawRequest), Encoding.UTF8, "application/json");
                content.Headers.ContentType = new MediaTypeHeaderValue("application/json");
                request.Content = content;

                var client = this.clientFactory.CreateClient();
                client.BaseAddress = new Uri(endpoint);
                client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Token", token);

                var jsonResponse = await client.SendAsync(request).ConfigureAwait(false);
                return jsonResponse;
            }
            catch (Exception ex)
            {
                return null;
            }
        }

        public async Task<HttpResponseMessage> PutAsync<T>(T rawRequest, string endpoint, string key)
        {
            var token = Helpers.Extensions.GenerateJwtToken(null, null, key);

            try
            {
                var request = new HttpRequestMessage(HttpMethod.Put, endpoint);
                var content = new StringContent(JsonConvert.SerializeObject(rawRequest), Encoding.UTF8, "application/json");
                content.Headers.ContentType = new MediaTypeHeaderValue("application/json");
                request.Content = content;

                var client = this.clientFactory.CreateClient();
                client.BaseAddress = new Uri(endpoint);
                client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Token", token);

                var jsonResponse = await client.SendAsync(request).ConfigureAwait(false);
                return jsonResponse;
            }
            catch (Exception ex)
            {
                return null;
            }
        }
    }
}
