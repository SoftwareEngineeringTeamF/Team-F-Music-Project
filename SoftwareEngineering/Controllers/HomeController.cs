using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using MvcApplication2.Models;
using MySql.Data.MySqlClient;

namespace MvcApplication2.Controllers
{
    public class HomeController : Controller
    {
        //
        // GET: /Home/

        public ActionResult Index(string username = "default", string password = "default")
        {
            string test = username;
            string test1 = password;
            bool passTest = false;


            //if(passTest == true)
            //{
            //    return profilePage();
            //}
            //else
            //{
            //    return badLogin();
            //}

            MySqlConnection conn = new MySqlConnection("server = fssh.jc-lan.com; UID = djscott; password = djscottf; database = teamf;");

            conn.Open();

            String query = "SELECT * from users where username = '" + username + "' AND password = '" + password + "' LIMIT 1";
            MySqlCommand command = new MySqlCommand(query, conn);
            MySqlDataReader reader = command.ExecuteReader();  

            //conn.Close();
            if (username.Equals("default")) {
                List<marketRow> tableLogin = new List<marketRow>();
                string login_success = "Y";
                marketRow row1 = new marketRow(login_success);
                tableLogin.Add(row1);

                IndexViewModel viewModel = new IndexViewModel()
                {
                    login_table = tableLogin
                };


                return View(viewModel);
            } else if (reader.HasRows) {
                List<marketRow> tableLogin = new List<marketRow>();
                string login_success = "Y";
                marketRow row1 = new marketRow(login_success);

                IndexViewModel viewModel = new IndexViewModel()
                {
                    login_table = tableLogin
                };
                tableLogin.Add(row1);

                return View("ProfilePage", viewModel);
            } else {

                List<marketRow> tableLogin = new List<marketRow>();
                string login_success = "N";
                marketRow row1 = new marketRow(login_success);

                IndexViewModel viewModel = new IndexViewModel()
                {
                    login_table = tableLogin
                };
                tableLogin.Add(row1);
                conn.Close();

                return View("Index", viewModel);
            }
        }
        public ActionResult Register()
        {

            return View("Register");
        }
        public ActionResult profilePage() //if pass login test then pull their profile page
        {

            return View("Profile");
        }
        public ActionResult badLogin()//if dont pass login test then show error on login
        {

            return View("Error");
        }

    }
}
