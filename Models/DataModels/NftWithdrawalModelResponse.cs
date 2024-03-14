using SonicAPI.Models.DbSets;
using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class NftWithdrawalModelResponse
    {
        public NftWithdrawalModelResponse()
        {
            this.Messages = new List<string>();
        }

        public string userNFTsAddress { get; set; }
        public string withdraw_update { get; set; }
        public decimal amount { get; set; }
        public List<string> Messages { get; set; }
    }
}