<?php

// Connect to server and select databse.
include_once "init.php";
include_once "password.php";

// username and password sent from form 
if (!isset ($_POST['myusername']) || !isset ($_POST['mypassword'])) {
	if (isset ($_GET['r']))
		header("url=index.php?r=" . $_GET['r']);
	else
		header("url=index.php");
} else {
	$myusername = $_POST['myusername'];
	$mypassword = $_POST['mypassword'];

	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);

	$sql = "SELECT * FROM users WHERE username='$myusername'";
	$user_query = mysqli_query($db_conx, $sql);
	// Mysql_num_row is counting table row
	$numrows = mysqli_num_rows($user_query);
	$row = mysqli_fetch_array($user_query);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if ( $numrows && password_verify($mypassword, $row['password'])) {
		if (true) { // no activation for now
		// if ($row['activated']) {
			// CREATE THEIR SESSIONS AND COOKIES
			session_start();
			$_SESSION['userid'] = $row["userid"];
			$_SESSION['username'] = $row["username"];
			$_SESSION['firstname'] = $row["firstname"];
			$_SESSION['lastname'] = $row["lastname"];
			$_SESSION['password'] = $row["password"];
			$_SESSION['email'] = $row["email"];

			setcookie("user", $myusername, strtotime('+30 days'), "/", "", "", TRUE);

			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$myusername' and password='$mypassword'";
			$query = mysqli_query($db_conx, $sql);
			echo $myusername;

			$redir = "";
			if (isset ($_GET['r']))
				$redir = $_GET['r'];
			else
				$redir = "user.php?u=" . $_SESSION['userid'];

			//header("location:" . $redir); //append
			echo "login success";
		} else {
?>
<strong>Your Email Address has not been verified.<br />Please check for an activation email in your inbox.</strong></p>
<p><a href="resendactivation.php?u=<?=$row['userid'] ?>">Resend activation email.</a></p>
</center>
<?php

		}
	} else {
?>
<p><strong>Wrong Username or Password</strong></p>
<p>Redirect to Login page in 5s</p>
</center>
<?php
		$redir = "index.php";
		if (isset ($_GET['r']))
			$redir .= "?r=" . $_GET['r'];
		header("refresh:5; url=" . $redir);
	}
}
?>
<?php include_once "footer.php"; ?>
