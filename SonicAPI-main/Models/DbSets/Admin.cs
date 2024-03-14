using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace SonicAPI.Models.DbSets
{
    public class Admin : TableBase
    {
        public long AdminId { get; set; }

        public string Name { get; set; }

        public string Username { get; set; }

        public string Password { get; set; }
    }
}
