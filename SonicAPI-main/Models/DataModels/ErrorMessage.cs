using System;
using System.Collections.Generic;

namespace SonicAPI.Models.DataModels
{
    public class ErrorMessage
    {
        public ErrorMessage (List<string> messages)
        {
            this.Messages = messages;
        }

        public List<string> Messages { get; set; }
    }
}