using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class GameModelResponse
    {
        public List<GameModeModel> Modes { get; set; }
        public List<GameSparePartModel> SpareParts { get; set; }
    }
}