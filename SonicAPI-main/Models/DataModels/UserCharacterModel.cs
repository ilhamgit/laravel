using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class UserCharacterModel
    {
        public int GameCharacterId { get; set; }
        public string Name { get; set; }
        public string Type { get; set; }
        public int MaximumSpareParts { get; set; }
        public bool IsOccupied { get; set; }
    }
}