using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class SingleGameItemRuleModel
    {
        public GameItemModel GameItem { get; set; }
        public GameModeTypeModel GameMode { get; set; }
        public bool Active { get; set; }
    }
}