using System;

namespace SonicAPI.Models.DbSets
{
    public class GameCoinRule : TableBase
    {
        public int GameCoinRuleId { get; set; }
        public int GameModeId { get; set; }
        public int GameCoinId { get; set; }
        public decimal MinimumValue { get; set; }
        public decimal MaximumValue { get; set; }
        public int MinimumCount { get; set; }
        public int MaximumCount { get; set; }
        public decimal Occurences { get; set; }
        public GameMode GameMode { get; set; }
        public GameCoin GameCoin { get; set; }
    }
}
