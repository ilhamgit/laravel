using SonicAPI.Models.DbSets;
using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class LoginUserModelResponse : UserModel
    {
        public string TokenString { get; set; }
        public string SessionId { get; set; }
    }
}