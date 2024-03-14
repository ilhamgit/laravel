using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class SingleGameCoinRuleModel
    {
        public GameCoinModel GameCoin { get; set; }
        public GameModeTypeModel GameMode { get; set; }
        public decimal MinimumValue { get; set; }
        public decimal MaximumValue { get; set; }
        public int MinimumCount { get; set; }
        public int MaximumCount { get; set; }
        public decimal Occurences { get; set; }
    }
}