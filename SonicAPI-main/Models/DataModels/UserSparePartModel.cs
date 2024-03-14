using System;

namespace SonicAPI.Models.DataModels
{
    public class UserSparePartModel
    {
        public int GameSparePartId { get; set; }
        public string Name { get; set; }
        public string Type { get; set; }
        public string Category { get; set; }
        public bool IsOccupied { get; set; }
    }
}