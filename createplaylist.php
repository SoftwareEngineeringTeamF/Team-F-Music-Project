<?php
include_once 'init.php';

if( isset($_POST['title']) && isset($_POST['description']) ) {
    $playlist = new Playlist();
    $u = $_SESSION['user']->getUserId();
    $p = "1";

    if ($playlist->create( $u, $p , $_POST['title'], $_POST['description']) )
        header( "Refresh:0; url=./index.php?o=mp" );
    else {
        $body .= "UNABLE TO CREATE";
        header( "Refresh:1; url=./index.php?o=cp" );
    }
} else {
    $body .= '<h3>Create A Playlist</h3><form name="playlistform" method="post" action="./index.php?o=cp"><table><tr><td>Title:</td><td><input name="title" type="text" maxlength="16"></td></tr><tr><td>Description</td><td><input name="description" type="text" maxlength="200"></td></tr><tr><td><input type="submit" name="Submit" value="Create Playlist"></td></tr></table></form></div>'; 
}
include_once 'footer.php';
?>