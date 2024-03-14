using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DbSets
{
    public class GameReward : TableBase
    {
        public int GameRewardId { get; set; }
        public int GameModeId { get; set; }
        public int PlayerRanking { get; set; }
        public int Experiences { get; set; }
        public int ElitePoints { get; set; }
        public int Trophies { get; set; }
        public GameMode GameMode { get; set; }
        public List<GameRewardAttribute> Attributes { get; set; }
    }
}
