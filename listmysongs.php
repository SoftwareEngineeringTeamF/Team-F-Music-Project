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

// build add song dropdown
$d2 = "";
$sql = "SELECT * FROM playlists WHERE ownerid='" . $u . "' ORDER BY playlistid";
$query= $db_conx->query($sql);
if( $query->num_rows > 0 ) {
    while ( $row = $query->fetch_assoc() ) {
        $d2 .= '<option value="'. $row['playlistid'] .'">'. $row['title'] .'</option>';
    }
} else {
    $d2 = '<option>NO PLAYLISTS</option>';
}
$d2 .= '</select><input type=submit value="Add Song"></form>';

$sql = "SELECT * FROM songs WHERE ownerid='" . $u . "' ORDER BY songid";
$query= $db_conx->query($sql);
$userlist= "<table><tr><th>artist</th><th></th><th>title</th><th>Add to A Playlist</th><th>delete song</th><th>preview</th></tr>";
if( $query->num_rows > 0 ) {
	while ( $row=$query->fetch_assoc() ) {
        $d1 = "<form name=\"add\" method=post action=\"./index.php?o=mv&v2=a&v3=". $row['songid'] ."\"><select name=pid>";
		$userlist .= "<tr><td>" . $row['artist'] . "</td><td> - </td><td>" . $row['title'] . "</td><td>" . $d1 . $d2 . "</td><td><a href=\"./index.php?o=ds&v1=". $row['songid'] ."\">DELETE</a></td><td><audio src=\"./songs/" . $row['songid'] . ".mp3\" preload=\"none\"></audio></td><td></tr>";
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
