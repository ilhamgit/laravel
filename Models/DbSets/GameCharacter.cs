using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace SonicAPI.Models.DbSets
{
    public class GameCharacter : TableBase
    {
        public int GameCharacterId { get; set; }
        public string Name { get; set; }
        public string Type { get; set; }
        public string NftAddress { get; set; }
        public int MaximumSpareParts { get; set; }
    }
}
