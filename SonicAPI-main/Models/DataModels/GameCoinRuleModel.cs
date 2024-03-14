using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameCoinRuleModel
    {
        public GameCoinTypeModel GameCoin { get; set; }
        public decimal MinimumValue { get; set; }
        public decimal MaximumValue { get; set; }
        public int MinimumCount { get; set; }
        public int MaximumCount { get; set; }
        public decimal Occurences { get; set; }
    }
}