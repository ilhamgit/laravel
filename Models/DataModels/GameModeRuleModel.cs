using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameModeRuleModel
    {
        public int SpendESOR { get; set; }
        public bool RequireNftCharacter { get; set; }
        public int RequireNftSpareParts { get; set; }
        public int? TopXElitePointRanking { get; set; }
    }
}