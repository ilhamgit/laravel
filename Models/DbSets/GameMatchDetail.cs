using System;

namespace SonicAPI.Models.DbSets
{
    public class GameMatchDetail : TableBase
    {
        public long GameMatchDetailId { get; set; }
        public long GameMatchId { get; set; }
        public long? UserId { get; set; }
        public string CustomPlayerName { get; set; }
        public int PlayerRanking { get; set; }
        public int LapTime { get; set; }
        public GameMatch GameMatch { get; set; }
        public User User { get; set; }
    }
}
