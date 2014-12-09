<?php

// Connect to server and select databse.
require "init.php";

// username and password sent from form 
if (!isset ($_POST['myusername']) || !isset ($_POST['mypassword'])) {
	if (isset ($_GET['r']))
		;//header("url=index.php?r=" . $_GET['r']);
	else
		;//header("url=index.php");
} else {
	$myusername = $_POST['myusername'];
	$mypassword = $_POST['mypassword'];

	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);

    $_SESSION['user'] = new User();
    if ( $_SESSION['user']->checkLogin( $myusername, $mypassword ) ) {
        $body .= "Login Success";
	} else {
        $body .= "<p><strong>Wrong Username or Password</strong></p><p>Redirect to Login page in 5s</p></center>";
	}
}

include_once "footer.php"; 
?>