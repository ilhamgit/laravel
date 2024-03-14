using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameSparePartModel
    {
        public int GameSparePartId { get; set; }
        public string Name { get; set; }
        public string Type { get; set; }
        public string Category { get; set; }
        public GameSparePartAttributeModel Attributes { get; set; }
    }
}