using SonicAPI.Models.DbSets;
using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class NftWithdrawalModelRequest
    {
        public string userNFTsAddress { get; set; }
        public string type { get; set; }
        public decimal amount { get; set; }
    }
}