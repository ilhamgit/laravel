using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DbSets
{
    public class User : TableBase
    {
        public long UserId { get; set; }
        public string Username { get; set; }
        public string Email { get; set; }
        public string NftAddress { get; set; }
        public string NftUserId { get; set; }
        public List<UserLoginHistory> LoginHistory { get; set; }
        public UserAttribute Attributes { get; set; }
        public List<UserStamina> Stamina { get; set; }
        public List<UserCoin> Coins { get; set; }
        public List<UserCharacter> Characters { get; set; }
        public List<UserSparePart> SpareParts { get; set; }
    }
}