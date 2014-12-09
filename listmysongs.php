<?php
include_once 'init.php';

$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
// Evaluate the connection
if ($db_conx->connect_errno > 0) {
   echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
   die();
}
$body .= '<div style="display: none"><audio></audio></div>';
if( isset($_SESSION['user']) ) {
$u = $_SESSION['user']->getUserId();

$sql = "SELECT * FROM songs WHERE ownerid='" . $u . "' ORDER BY songid";
$query= $db_conx->query($sql);
$userlist= "<table><tr><th>artist</th><th></th><th>title</th><th>Preview</th></tr>";
if( $query->num_rows > 0 ) {
	while ( $row=$query->fetch_assoc() ) {
		$u= $row["username"];
		$userlist .= "<tr><td>" . $row['artist'] . "</td><td> - </td><td>" . $row['title'] . "</td><td><audio src=\"./songs/" . $row['songid'] . ".mp3\" preload=\"none\"></audio></td></tr>";
	}
	$userlist .= "</table>";
	$body .= $userlist;
	$body .= "Number of rows: " . $query->num_rows . "<br>";
} else {
	$body .= "NO SONGS";
}
} else {
	$body .= "NOT LOGGED IN";
}

	include_once "footer.php";
?>
