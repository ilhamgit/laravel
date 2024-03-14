using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameItemRuleModel
    {
        public GameItemModel GameItem { get; set; }
        public bool Active { get; set; }
    }
}