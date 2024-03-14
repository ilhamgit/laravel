﻿using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameRewardModel
    {
        public int PlayerRanking { get; set; }
        public int Experiences { get; set; }
        public int ElitePoints { get; set; }
        public int Trophies { get; set; }
        public List<GameRewardAttributeModel> Attributes { get; set; }
    }
}