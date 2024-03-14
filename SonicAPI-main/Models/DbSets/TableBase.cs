using System;
using System.ComponentModel.DataAnnotations.Schema;
using System.Text.Json.Serialization;

namespace SonicAPI.Models
{
    public class TableBase
    {
        public DateTime DateCreated { get; set; }
        public DateTime DateModified { get; set; }
    }
}
