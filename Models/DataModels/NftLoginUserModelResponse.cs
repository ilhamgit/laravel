using SonicAPI.Models.DbSets;
using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class NftLoginUserModelResponse
    {
        public NftLoginUserModelResponse()
        {
            this.Characters = new List<NftLoginUserItemModel>();
            this.SpareParts = new List<NftLoginUserItemModel>();
            this.Messages = new List<string>();
        }

        public string UserId { get; set; }
        public string Username { get; set; }
        public string Wallet { get; set; }
        public string Email { get; set; }
        public List<NftLoginUserItemModel> Characters { get; set; }
        public List<NftLoginUserItemModel> SpareParts { get; set; }
        public List<string> Messages { get; set; }
    }
}