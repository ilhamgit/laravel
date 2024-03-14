using System;

namespace SonicAPI.Models.DbSets
{
    public class GameModeRule : TableBase
    {
        public int GameModeRuleId { get; set; }
        public int GameModeId { get; set; }
        public int SpendESOR { get; set; }
        public bool RequireNftCharacter { get; set; }
        public int RequireNftSpareParts { get; set; }
        public int? TopXElitePointRanking { get; set; }
        public GameMode GameMode { get; set; }
    }
}
