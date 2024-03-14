using System;

namespace SonicAPI.Models.DbSets
{
    public class GameRewardAttribute : TableBase
    {
        public int GameRewardAttributeId { get; set; }
        public int GameRewardId { get; set; }
        public int GameCoinId { get; set; }
        public decimal Amount { get; set; }
        public GameReward GameReward { get; set; }
        public GameCoin GameCoin { get; set; }
    }
}
