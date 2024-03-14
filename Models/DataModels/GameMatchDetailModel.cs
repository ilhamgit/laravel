using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameMatchDetailModel
    {
        public int PlayerRanking { get; set; }
        public SingleUserModel User { get; set; }
        public string CustomPlayerName { get; set; }
        public int LapTime { get; set; }
    }
}