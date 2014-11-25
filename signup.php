<?php

// universal check for session
if (isset ($_SESSION['userid']))
	header("Location: user.php?u=" . $SESSION["username"]);
?>
<?php
require 'init.php';
require 'password.php';

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
	$query = mysqli_query($db_conx, $sql);
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT userid FROM users WHERE email='$e' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if ($u == "" || $fn == "" || $ln == "" || $e == "" || $p == "") {
		echo "The form submission is missing values.";
		exit ();
	} else {
		if ($u_check > 0) {
			echo "The username you entered is already taken";
			exit ();
		} else {
			echo "username ok <br>";
			if ($e_check > 0) {
				echo "That email address is already in use in the system";
				exit ();
			} else if (!check_email($e)) {
				echo "The email address you have entered is not valid.";
				exit ();
			} else {
				echo "email ok <br>";
				if (strlen($u) < 3 || strlen($u) > 16) {
					echo "Username must be between 3 and 16 characters";
					exit ();
				} else {
					echo "username length ok <br>";
					if (is_numeric($u[0])) {
						echo 'Username cannot begin with a number';
						exit ();
					} else {
						echo "username first char ok <br>";
						if( $p != $p2 ) { 
							echo 'Passwords do not match';
							exit();
						} else {
						// END FORM DATA ERROR HANDLING
						// Begin Insertion of data into the database
						// Hash the password and apply your own mysterious unique salt

						$p_hash = password_hash($p, PASSWORD_DEFAULT,['cost' => 12]); //md5($p);
						// Add user info into the database table for the main site table
						$sql = "INSERT INTO users (username, password, email, activated, hash_act, firstname, lastname, ip, signup, lastlogin, )       
								        VALUES('$u', '$p_hash', '$e', true, '$signup_key', '$fn', '$ln', '$ip', now(), now()";
						$query = mysqli_query($db_conx, $sql);

						echo "Signup successful";
						exit();
						// Email the user their activation link
						/*if (send_activation_email($e, $signup_key)) {
							echo "Signup Successful.  Please check your email to activate your account";
						} else {
							echo "Oops, and error occurred.  Please wait a few minutes and try again.";
						}*/
						}
					}
				}
			}
		}
		echo "Oops, an error occurred.  Please try again.";
		exit();
	}
} else {
?>
<div id="pageMiddle">
  <h3>Sign Up Here</h3>
  <form name="signupform" method="post" action="signup.php">
    <div>Username: </div>
    <input name="username" type="text" maxlength="16">

    <div>First Name: </div>
    <input name="firstname" type="text" maxlength="30">
	<div>Last Name: </div>
    <input name="lastname" type="text" maxlength="30">

    <div>Email Address:</div>
    <input name="email" type="text" maxlength="88">
    <div>Create Password:</div>
    <input name="pass1" type="password" maxlength="16">
    <div>Confirm Password:</div>
    <input name="pass2" type="password" maxlength="16">
    
    <br /><br />
    <input type="submit" name="Submit" value="Create Account">
  </form>
</div>
<?php } 
include_once "footer.php";
 ?>