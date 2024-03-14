using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DbSets
{
    public class GameCoin : TableBase
    {
        public int GameCoinId { get; set; }
        public string Name { get; set; }
        public string Type { get; set; }
        public bool Withdrawable { get; set; }
        public bool Purchasable { get; set; }
        public List<GameCoinRule> Rules { get; set; }
    }
}
