using System;

namespace SonicAPI.Models.DataModels
{
    public class UserAttributeModelRequest
    {
        public int Levels { get; set; }
        public int Experiences { get; set; }
        public decimal SOR { get; set; }
        public decimal ESOR { get; set; }
    }
}