using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameSparePartAttributeModel
    {
        public decimal Acceleration { get; set; }
        public int MaximumSpeed { get; set; }
        public decimal TurboSpeed { get; set; }
        public int EnergyAddOnAmount { get; set; }
        public int SterlingAmount { get; set; }
    }
}