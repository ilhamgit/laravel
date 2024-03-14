using System;

namespace SonicAPI.Models.DbSets
{
    public class UserAttribute : TableBase
    {
        public long UserAttributeId { get; set; }
        public long UserId { get; set; }
        public int Levels { get; set; }
        public int Experiences { get; set; }
        public int ElitePoints { get; set; }
        public int Trophies { get; set; }
        public User User { get; set; }
    }
}
