using System;

namespace SonicAPI.Models.DbSets
{
    public class UserCoin : TableBase
    {
        public long UserCoinId { get; set; }
        public long UserId { get; set; }
        public int GameCoinId { get; set; }
        public decimal Amount { get; set; }
        public User User { get; set; }
        public GameCoin GameCoin { get; set; }
    }
}
