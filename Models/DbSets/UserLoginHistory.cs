using System;

namespace SonicAPI.Models.DbSets
{
    public class UserLoginHistory : TableBase
    {
        public long UserLoginHistoryId { get; set; }
        public long UserId { get; set; }
        public Guid SessionId { get; set; }
        public User User { get; set; }
    }
}
