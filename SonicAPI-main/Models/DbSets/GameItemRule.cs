using System;

namespace SonicAPI.Models.DbSets
{
    public class GameItemRule : TableBase
    {
        public int GameItemRuleId { get; set; }
        public int GameModeId { get; set; }
        public int GameItemId { get; set; }
        public bool Active { get; set; }
        public GameMode GameMode { get; set; }
        public GameItem GameItem { get; set; }
    }
}
