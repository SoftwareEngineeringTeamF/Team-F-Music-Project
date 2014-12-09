<?php

// Connect to server and select databse.
require "init.php";

// username and password sent from form 
if (!isset ($_POST['myusername']) || !isset ($_POST['mypassword'])) {
	header("url=index.php");
} else {
	$myusername = $_POST['myusername'];
	$mypassword = $_POST['mypassword'];

	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);

    $_SESSION['user'] = new User();
    if ( $_SESSION['user']->checkLogin( $myusername, $mypassword ) ) {
        $body .= "Login Success";
		header( "Refresh:5; url=./index.php" );
	} else {
        $body .= "<p><strong>Wrong Username or Password</strong></p><p>Redirect to Login page in 5s</p></center>";
		header( "Refresh:5; url=./index.php" );
		session_destroy();
	}
}

include_once "footer.php"; 
?>