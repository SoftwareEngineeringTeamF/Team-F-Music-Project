<?php
require 'init.php';
require 'connect.php';

$sql = "SELECT * FROM songs ORDER BY songid";
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

	include_once "footer.php";
?>
