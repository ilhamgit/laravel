using System;

namespace SonicAPI.Models.DbSets
{
    public class GameSparePartAttribute : TableBase
    {
        public int GameSparePartAttributeId { get; set; }
        public int GameSparePartId { get; set; }
        public decimal Acceleration { get; set; }
        public int MaximumSpeed { get; set; }
        public decimal TurboSpeed { get; set; }
        public int EnergyAddOnAmount { get; set; }
        public int SterlingAmount { get; set; }
        public GameSparePart GameSparePart { get; set; }
    }
}
