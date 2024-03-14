using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DbSets
{
    public class GameMatch : TableBase
    {
        public long GameMatchId { get; set; }
        public int GameModeId { get; set; }
        public string GameUniqueId { get; set; }
        public GameMode GameMode { get; set; }
        public List<GameMatchDetail> Details { get; set; }
    }
}
