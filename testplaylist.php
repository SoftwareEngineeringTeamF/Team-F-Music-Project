<?php

require "init.php";

function echoplaylist(Playlist $p) {
    echo "<table><tr><th>playlistid</th><th>ownerid</th><th>public</th><th>title</th><th>description</th></tr>";
    echo "<tr><td>" . $p->getPlaylistId() . "</td><td>" . $p->getOwnerId() . "</td><td>" . $p->getPublic() . "</td><td>" . $p->getTitle() . "</td><td>" . $p->getDescription() . "</td></tr></table>";
    
    
    if( $p->getNumSongs() > 0 ) {
        echo "Number of songs in playlist: " . $p->getNumSongs() . "<BR>";
        echo "<table><tr><th>index</th><th>artist</th><th>title</th></tr>";
        $s = new Song();
        $n = 1;
        foreach( $p->getSongs() as $i ) {
            
            $s->load($i);
            echo "<tr><td>" . ($n) . "</td><td>" . $s->getArtist() . "</td><td>" . $s->getTitle() . "</td></tr>";
            $n++;
        }
        echo "</table>";
    } else {
        echo "EMPTY PLAYLIST";
    }
    echo "<BR>";
}

//test load
$p0 = new Playlist();
echo "<strong>Create Playlist Object and load 1 from db</strong><br>";
$p0->load(1);
echoplaylist($p0);
if($p0->getPlaylistId() == 1) echo "PASS ID<BR>"; else echo "FAIL ID<BR>";
if($p0->getOwnerId() == 1) echo "PASS OwnerID<BR>"; else echo "FAIL OwnerID<BR>";
if($p0->getTitle() == "Title") echo "PASS Title<BR>"; else echo "FAIL Title<BR>";
if($p0->getDescription() == "Description") echo "PASS Description<BR>"; else echo "FAIL Description<BR>"; echo "<HR>";

//test promote
echo "<strong>Promoting Playlist Object 1</strong><br>";
$s1 = $p0->getSong(1);
$s0 = $p0->getSong(0);
if( !$p0->promoteSong(1) ) { echo "PROMOTE OPERATION FAILED"; die(); }
//echoplaylist($p0);
if($p0->getSong(1) != $s0 || $p0->getSong(0) != $s1) echo "FAIL"; else echo "PASS"; echo "<HR>";

//test demote
echo "<strong>Demoting Playlist Object 0</strong><br>";
if( !$p0->demoteSong(0) ) { echo "DEMOTE OPERATION FAILED"; die(); }
//echoplaylist($p0);
if($p0->getSong(1) != $s1 || $p0->getSong(0) != $s0) echo "FAIL"; else echo "PASS"; echo "<HR>";

//test create

//test loaded create

//test set owner

//test set title

//test set description

//delete

include_once 'footer.php';
?>