<?php
require 'init.php';
$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
// Evaluate the connection
if ($db_conx->connect_errno > 0) {
    $body .= 'Unable to connect to database [' . $db_conx->connect_error . ']';
    die();
}

if (isset($_POST['username'])) {
	if(isset($_POST['username'])) 	$u = $_POST['username'];
	if(isset($_POST['email']))	 	$e = $_POST['email'];
	if(isset($_POST['firstname']))	$fn = $_POST['firstname'];
	if(isset($_POST['lastname']))	$ln = $_POST['lastname'];
	if(isset($_POST['pass1']))		$p = $_POST['pass1'];
	if(isset($_POST['pass2']))		$p2 = $_POST['pass2'];
	$signup_key = sha1($u . time());
	
	// GET USER IP ADDRESS
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT userid FROM users WHERE username='$u' LIMIT 1";
	$result = $db_conx->query($sql);
	$u_check = $result->num_rows;
	// -------------------------------------------
	$sql = "SELECT userid FROM users WHERE email='$e' LIMIT 1";
	$query = $db_conx->query($sql);
	$e_check = $query->num_rows;
	// FORM DATA ERROR HANDLING
	if ($u == "" || $fn == "" || $ln == "" || $e == "" || $p == "") {
		$body .= "The form submission is missing values.";
	} else {
		if ($u_check > 0) {
			$body .= "The username you entered is already taken";
		} else {
			$body .= "username ok <br>";
			if ($e_check > 0) {
				$body .= "That email address is already in use in the system";
			} else if (!check_email($e)) {
				$body .= "The email address you have entered is not valid.";
			} else {
				$body .= "email ok <br>";
				if (strlen($u) < 3 || strlen($u) > 16) {
					$body .= "Username must be between 3 and 16 characters";
				} else {
					$body .= "username length ok <br>";
					if (is_numeric($u[0])) {
						$body .= 'Username cannot begin with a number';
					} else {
						$body .= "username first char ok <br>";
						if( $p != $p2 ) { 
							$body .= 'Passwords do not match';
						} else {
							$body .= "passwords match ok <br>";
							// END FORM DATA ERROR HANDLING
							// Begin Insertion of data into the database
							// Hash the password and apply your own mysterious unique salt

							$p_hash = password_hash($p, PASSWORD_DEFAULT,['cost' => 12]); //md5($p);
							// Add user info into the database table for the main site table
							$sql = "INSERT INTO users (username, password, email, activated, hash_act, firstname, lastname, ip, signup, lastlogin )       
								        VALUES('$u', '$p', '$e', 1, '$signup_key', '$fn', '$ln', '$ip', now(), now())";
							$query = $db_conx->query($sql);
							$signup_ok = $db_conx->affected_rows;
							if ( $signup_ok > 0 ) {
								$body .= "Signup successful";
								// Email the user their activation link
								/*if (send_activation_email($e, $signup_key)) {
									$body .= "Signup Successful.  Please check your email to activate your account";
								} else {
									$body .= "Oops, and error occurred.  Please wait a few minutes and try again.";
								}*/
							} else {
								$body .= "Oops, an error occurred.  Please try again. <br>";
								$body .= $db_conx->error;
							}
						}
					}
				}
			}
		}
	}
} else { 
    $body .= '<div id="pageMiddle"><h3>Sign Up Here</h3><form name="signupform" method="post" action="signup.php"><table><tr><td>Username:</td><td><input name="username" type="text" maxlength="16"></td></tr><tr><td>First Name:</td><td><input name="firstname" type="text" maxlength="30"></td></tr><tr><td>Last Name:</td><td><input name="lastname" type="text" maxlength="30"></td></tr><tr><td>Email Address:</td><td><input name="email" type="text" maxlength="88"></td></tr><tr><td>Create Password:</td><td><input name="pass1" type="password" maxlength="16"></td></tr><tr><td>Confirm Password:</td><td><input name="pass2" type="password" maxlength="16"></td></tr><tr><td><input type="submit" name="Submit" value="Create Account"></td></tr></table></form></div>'; 
} 
include_once "footer.php";
?>