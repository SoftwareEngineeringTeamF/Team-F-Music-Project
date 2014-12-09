<?php
include_once 'init.php';

//if the user has a session going, they shouldn't be seeing the login page.
//so redirect them to their calendar
if (isset ($_SESSION['user'])) {
	session_destroy();
    $body .= "Session destroyed.";
	header( "Location: ./index.php" );
} else {
    $body .= "Not logged in.";
	header( "Location: ./index.php" );
}
include_once "footer.php";
?>
