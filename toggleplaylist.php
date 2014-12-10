<?php
include_once 'init.php';

$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
// Evaluate the connection
if ($db_conx->connect_errno > 0) {
   echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
   die();
}

$sql = "SELECT * FROM playlists WHERE ownerid='" . $_SESSION['user']->getUserId() . "' AND playlistid='" . $_GET['v1'] . "'";
$query= $db_conx->query($sql);
    if( $query->num_rows == 1 ) {
        $sql = "UPDATE playlists SET public='". $_GET['v2'] ."' WHERE playlistid='" . $_GET['v1'] . "'";
        $query= $db_conx->query($sql);
        header( "Refresh:0; url=./index.php?o=ep" );
    } else {
    $body .= "NOT A VALID OPERATION Redirecting";
    header( "Refresh:1; url=./index.php?o=ep" );
}

include_once 'footer.php';
?>