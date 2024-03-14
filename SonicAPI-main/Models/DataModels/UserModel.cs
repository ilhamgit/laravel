using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class UserModel
    {
        public long UserId { get; set; }
        public string Username { get; set; }
        public string Email { get; set; }
        public UserAttributeModel Attributes { get; set; }
        public UserStaminaModel Stamina { get; set; }
        public List<UserCoinModel> Coins { get; set; }
        public List<UserCharacterModel> Characters { get; set; }
        public List<UserSparePartModel> SpareParts { get; set; }
    }
}