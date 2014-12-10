<?php
include_once 'init.php';

$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
// Evaluate the connection
if ($db_conx->connect_errno > 0) {
   echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
   die();
}

$sql = "SELECT * FROM songs WHERE ownerid='" . $_SESSION['user']->getUserId() . "' AND songid='" . $_GET['v1'] . "'";
$query= $db_conx->query($sql);
    if( $query->num_rows == 1 ) {
        if( !isset($_GET['v2']) ) {
            $body .= 'ARE YOU SURE YOU WANT TO DELETE THIS SONG?<br><a href="./index.php?o=ds&v1=' . $_GET['v1'] . '&v2=confirm">CONFIRM</a>          <a href="./index.php?o=ms">CANCEL</a>';       
        } else if($_GET['v2']=="confirm") {
            $sql = "SELECT playlists.title, playlists.playlistid FROM members JOIN playlists on playlists.playlistid=members.playlistid WHERE songid='". $_GET['v1'] ."'";
            $query= $db_conx->query($sql);
            if($query->num_rows > 0) {
                $body .= "<h3>This song is still in use by these playlists:</h3><h5>Click title to edit playlist</h5>";
                while($row=$query->fetch_assoc()) {
                    $body .= '<a href="./index.php?o=ep&p='. $row['playlistid'] . '">' . $row['title'] . "</a><br>";
                }
            } else {
                $sql = "DELETE FROM songs WHERE songid='". $_GET['v1'] ."'";
                $query= $db_conx->query($sql);
                $body .= 'SONG DELETED';
                header( "Refresh:1; url=./index.php?o=ms" );        
            }
            
        }
        else { 
            $body .= "UNSUCCESSFUL Redirecting";
            header( "Refresh:1; url=./index.php?o=ms" );
        }
    } else {
    $body .= "NOT YOUR PLAYLIST Redirecting";
    header( "Refresh:1; url=./index.php?o=ms" );
}

include_once 'footer.php';
?>