using System;

namespace SonicAPI.Models.DbSets
{
    public class UserStamina : TableBase
    {
        public long UserStaminaId { get; set; }
        public long UserId { get; set; }
        public int Amount { get; set; }
        public User User { get; set; }
    }
}
