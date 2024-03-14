using System;

namespace SonicAPI.Models.DbSets
{
    public class UserSparePart : TableBase
    {
        public long UserSparePartId { get; set; }
        public long UserId { get; set; }
        public int GameSparePartId { get; set; }
        public bool IsOccupied { get; set; }
        public User User { get; set; }
        public GameSparePart GameSparePart { get; set; }
    }
}
