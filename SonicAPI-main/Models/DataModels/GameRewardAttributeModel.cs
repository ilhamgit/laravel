using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameRewardAttributeModel
    {
        public GameCoinTypeModel GameCoin { get; set; }
        public decimal Amount { get; set; }
    }
}