using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace MvcApplication2.Models
{
    public class marketRow
    {
        public string login_success { get; set; }

        public marketRow(string _success)
        {
            login_success = _success;
        }
    }
}