using System;

namespace SonicAPI.Models.DbSets
{
    public class UserCharacter : TableBase
    {
        public long UserCharacterId { get; set; }
        public long UserId { get; set; }
        public int GameCharacterId { get; set; }
        public bool IsOccupied { get; set; }
        public User User { get; set; }
        public GameCharacter GameCharacter { get; set; }
    }
}
