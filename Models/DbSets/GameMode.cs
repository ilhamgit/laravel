using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DbSets
{
    public class GameMode : TableBase
    {
        public int GameModeId { get; set; }
        public string Name { get; set; }
        public string Type { get; set; }
        public bool Active { get; set; }
        public GameModeRule Rules { get; set; }
        public List<GameCoinRule> CoinRules { get; set; }
        public List<GameItemRule> ItemRules { get; set; }
        public List<GameReward> Rewards { get; set; }
    }
}
