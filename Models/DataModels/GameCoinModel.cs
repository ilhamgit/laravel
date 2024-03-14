using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameCoinModel
    {
        public string Name { get; set; }
        public string Type { get; set; }
        public bool Withdrawable { get; set; }
        public bool Purchasable { get; set; }
    }
}