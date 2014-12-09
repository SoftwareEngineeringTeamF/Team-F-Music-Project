<?php
require 'init.php';
require 'connect.php';
$playlistlist = "";
if(!isset($_GET[p])){

    $sql = "SELECT * FROM playlists ORDER BY playlistid";
    $query= $db_conx->query($sql);
    $playlistlist .= "<table><tr><th>playlistid</th><th>ownerid</th><th>public</th><th>title</th><th>description</tr>";
    if( $query->num_rows > 0 ) {
        while ( $row=$query->fetch_assoc() ) {
            $playlistlist .= "<tr><td>" . $row['playlistid'] . "</td><td>" . $row['ownerid'] . "</td><td>" . $row['public'] . "</td><td><a href=\"./listplaylists.php?p=" . $row['playlistid'] . "\">" . $row['title'] . "</td><td>" . $row['description'] . "</td></tr>";
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
            $playlistlist .= '<div id="wrapper"><h1>' . $row['title'].  '</h1><audio preload></audio><ol>';
        }
        
        $sql = "SELECT songs.artist, songs.title, songs.songid, members.listindex FROM songs JOIN members on songs.songid = members.songid WHERE members.playlistid = '" . $_GET['p'] . "'  ORDER BY members.listindex";
        $query= $db_conx->query($sql);
        if( $query->num_rows > 0 ) {
            while ( $row=$query->fetch_assoc() ) {
                $playlistlist .= "<li>" . "<a href=\"#\" data-src=\"./songs/". $row['songid'] . ".mp3\">" . $row['artist'] . " - " . $row['title'] . "</a></li>";
            }
            $playlistlist .= "</ol></div>";
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