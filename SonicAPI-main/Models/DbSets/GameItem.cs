using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DbSets
{
    public class GameItem : TableBase
    {
        public int GameItemId { get; set; }
        public string Name { get; set; }
        public string Type { get; set; }
        public List<GameItemRule> Rules { get; set; }
    }
}
