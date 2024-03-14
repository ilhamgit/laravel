using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameLeaderboardModel
    {
        public SingleUserModel User { get; set; }
        public int Experiences { get; set; }
        public int ElitePoints { get; set; }
        public int Trophies { get; set; }
    }
}