using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class SingleGameMatchDetailModelRequest
    {
        public int PlayerRanking { get; set; }
        public long? UserId { get; set; }
        public int LapTime { get; set; }
    }
}