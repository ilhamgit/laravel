using System;

namespace SonicAPI.Models.DbSets
{
    public class GameSparePart : TableBase
    {
        public int GameSparePartId { get; set; }
        public string Name { get; set; }
        public string Type { get; set; }
        public string NftAddress { get; set; }
        public string Category { get; set; }
        public GameSparePartAttribute Attributes { get; set; }
    }
}
