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
        if( !isset($_GET['v2']) ) {
            $body .= 'ARE YOU SURE YOU WANT TO DELETE THIS PLAYLIST?<br><a href="./index.php?o=dp&v1=' . $_GET['v1'] . '&v2=confirm">CONFIRM</a>          <a href="./index.php?o=mp">CANCEL</a>';       
        } else if($_GET['v2']=="confirm") {
            $sql = "DELETE FROM members WHERE playlistid='". $_GET['v1'] ."'";
            $query= $db_conx->query($sql);
            $sql = "DELETE FROM playlists WHERE playlistid='". $_GET['v1'] ."'";
            $query= $db_conx->query($sql);
            $body .= 'PLAYLIST DELETED';
            header( "Refresh:1; url=./index.php?o=mp" );        
        }
        else { 
            $body .= "UNSUCCESSFUL Redirecting";
            header( "Refresh:1; url=./index.php?o=mp" );
        }
    } else {
    $body .= "NOT YOUR PLAYLIST Redirecting";
    header( "Refresh:1; url=./index.php?o=mp" );
}

include_once 'footer.php';
?>