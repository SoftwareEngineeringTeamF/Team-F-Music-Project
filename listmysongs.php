<?php
include_once 'init.php';

$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
// Evaluate the connection
if ($db_conx->connect_errno > 0) {
   echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
   die();
}
if( isset($_SESSION['user']) ) {
$u = $_SESSION['user']->getUserId();

$sql = "SELECT * FROM songs WHERE ownerid='" . $u . "' ORDER BY songid";
$query= $db_conx->query($sql);
$userlist= "<table><tr><th>songid</th><th>ownerid</th><th>artist</th><th>title</th></tr>";
if( $query->num_rows > 0 ) {
	while ( $row=$query->fetch_assoc() ) {
		$u= $row["username"];
		$userlist .= "<tr><td>" . $row['songid'] . "</td><td>" . $row['ownerid'] . "</td><td>" . $row['artist'] . "</td><td>" . $row['title'] . "</td></tr>";
	}
	$userlist .= "</table>";
	$body .= "Number of rows: " . $query->num_rows . "<br>";
	$body .= $userlist;
} else {
	$body .= "NO SONGS";
}
} else {
	$body .= "NOT LOGGED IN";
}

	include_once "footer.php";
?>
