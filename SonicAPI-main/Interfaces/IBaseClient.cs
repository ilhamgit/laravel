using System;
using System.Net.Http;
using System.Threading.Tasks;

namespace SonicAPI.Interfaces
{
    public interface IBaseClient
    {
        Task<HttpResponseMessage> PostAsync<T>(T request, string endpoint, string key);
        Task<HttpResponseMessage> PutAsync<T>(T request, string endpoint, string key);
    }
}