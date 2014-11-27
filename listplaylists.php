<?php
require 'init.php';
require 'connect.php';

if(!isset($_GET[p])){

    $sql = "SELECT * FROM playlists ORDER BY playlistid";
    $query= $db_conx->query($sql);
    $playlistlist= "<table><tr><th>playlistid</th><th>ownerid</th><th>public</th><th>title</th><th>description</tr>";
    if( $query->num_rows > 0 ) {
        while ( $row=$query->fetch_assoc() ) {
            $playlistlist .= "<tr><td>" . $row['playlistid'] . "</td><td>" . $row['ownerid'] . "</td><td>" . $row['public'] . "</td><td><a href=\"./listplaylists.php?p=" . $row['playlistid'] . "\">" . $row['title'] . "</td><td>" . $row['description'] . "</td></tr>";
        }
        $playlistlist .= "</table>";

?>

<body>
<div id="middle page" style="margin-left: 200px;">
<br>
<?php 
        echo "Number of rows: " . $query->num_rows . "<br>";
        echo $playlistlist;
    } else {
        echo "NO PLAYLISTS";
    }
} else {
    $sql = "SELECT songs.artist, songs.title, members.index FROM songs JOIN members on songs.songid = members.songid WHERE members.playlistid = '" . $_GET['p'] . "'  ORDER BY members.index";
    $query= $db_conx->query($sql);
    $playlistlist= "<table><tr><th>index</th><th>artist</th><th>title</th></tr>";
    if( $query->num_rows > 0 ) {
        while ( $row=$query->fetch_assoc() ) {
            $playlistlist .= "<tr><td>" . ($row['index']+1) . "</td><td>" . $row['artist'] . "</td><td>" . $row['title'] . "</td></tr>";
        }
        $playlistlist .= "</table>";

    
    ?>

<body>
<div id="middle page" style="margin-left: 200px;">
<br>
<?php 
        echo "Number of rows: " . $query->num_rows . "<br>";
        echo $playlistlist;
    } else {
        echo "NO SONGS IN PLAYLIST";
    }

}

	include_once "footer.php";
?>
