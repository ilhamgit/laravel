using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameModeModel
    {
        public string Name { get; set; }
        public string Type { get; set; }
        public bool Active { get; set; }
        public GameModeRuleModel Rules { get; set; }
        public List<GameCoinRuleModel> CoinRules { get; set; }
        public List<GameItemRuleModel> ItemRules { get; set; }
        public List<GameRewardModel> Rewards { get; set; }
    }
}