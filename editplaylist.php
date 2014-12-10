<?php
include_once 'init.php';

$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
// Evaluate the connection
if ($db_conx->connect_errno > 0) {
   echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
   die();
}

$u = $_SESSION['user']->getUserId();
$playlistlist = "";
if(!isset($_GET['p'])){

    $sql = "SELECT * FROM playlists WHERE ownerid='" . $u . "' ORDER BY playlistid";
    $query= $db_conx->query($sql);
    $playlistlist .= "<h2>Playlist Management</h2><table><tr><th>title</th><th>description</th><th>public</th><th>delete</th></tr>";
    if( $query->num_rows > 0 ) {
        while ( $row=$query->fetch_assoc() ) {
			$playlistlist .=  "</td><td><a href=\"./index.php?o=ep&p=" . $row['playlistid'] . "\">" . $row['title'] . "</td><td>" . $row['description'] . "</td><td>";
            if($row['public']) $p = '<a href="./index.php?o=tp&v1=' . $row['playlistid'] . '&v2=0">TRUE</a>'; else $p = '<a href="./index.php?o=tp&v1=' . $row['playlistid'] . '&v2=1">FALSE</a>';
            $playlistlist .= $p . '</td><td><a href="./index.php?o=dp&v1=' . $row['playlistid'] . '">DELETE</a></td></tr>';
        }
        $playlistlist .= "</table>";
        $playlistlist .= "Number of rows: " . $query->num_rows . "<br>";

    } else {
        $playlistlist .= "NO PLAYLISTS";
    }
} else {
    $sql = "SELECT * FROM playlists WHERE playlistid= '" . $_GET['p'] . "' LIMIT 1";
    $query= $db_conx->query($sql);
    $playlistlist .= "";
    if( $query->num_rows > 0 ) {
        while ( $row=$query->fetch_assoc() ) {
            $playlistlist .= '<h2>Editing: '. $row['title'] .'</h2><h4>'. $row['description'] . '</h4><br><table>';
        }
        
        $sql = "SELECT songs.artist, songs.title, songs.songid, members.listindex FROM songs JOIN members on songs.songid = members.songid WHERE members.playlistid = '" . $_GET['p'] . "'  ORDER BY members.listindex";
        $query= $db_conx->query($sql);
        if( $query->num_rows > 0 ) {
            while ( $row=$query->fetch_assoc() ) {
                $playlistlist .= "<tr><td>". ($row['listindex'] + 1) . "</td><td>" . $row['artist'] . " - " . $row['title'] . "</td>";
                if( $row['listindex'] > 0 ) $playlistlist .= "<td><a href=\"./index.php?o=mv&v1=". $_GET['p'] ."&v2=u&v3=". $row['listindex'] ."\">UP</a></td>"; else $playlistlist .= "<td></td>";
                if( $row['listindex'] < $query->num_rows - 1 ) $playlistlist .= "<td><a href=\"./index.php?o=mv&v1=". $_GET['p'] ."&v2=d&v3=". $row['listindex'] ."\">DOWN</a></td>"; else $playlistlist .="<td></td>";
                $playlistlist .= "<td><a href=\"./index.php?o=mv&v1=". $_GET['p'] ."&v2=r&v3=". $row['listindex'] ."\">Delete from Playlist</a></td>";
                $playlistlist .= "</tr>";
            }
            $playlistlist .= "</table>";
            // keyboard controls
            // .= '<div id="shortcuts"><div><h1>Keyboard shortcuts:</h1><p><em>&rarr;</em> Next track</p><p><em>&larr;</em> Previous track</p><p><em>Space</em> Play/pause</p></div></div>';


        } else {
            $playlistlist .= "</ol></div>NO SONGS IN PLAYLIST";
        }

    }
}
    $body .= $playlistlist;
	include_once "footer.php";
?>