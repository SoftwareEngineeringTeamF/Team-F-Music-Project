<?php
include_once 'init.php';

$p = new Playlist();
if(isset($_GET['v1'])) {
    $p->load($_GET['v1']);
    if( $p->getOwnerId() == $_SESSION['user']->getUserId() ) {
        if( $_GET['v2'] == 'u' && $_GET['v3'] > 0)
            $p->promoteSong($_GET['v3']);
        else if ( $_GET['v2'] == 'd' && $_GET['v3'] < ($p->getNumSongs() - 1))
            $p->demoteSong($_GET['v3']);
        else if ( $_GET['v2'] == 'r' && $_GET['v3'] >= 0 && $_GET['v3'] < $p->getNumSongs())
            $p->removeSong($_GET['v3']);
        else
            $body .= "ERROR";
        header( "Refresh:0; url=./index.php?o=ep&p=" . $_GET['v1'] );    
    } else {
    $body .= "NOT YOUR PLAYLIST";
    header( "Refresh:1; url=./index.php?o=ep&p=" . $_GET['v1'] );    
    }
} else if ( isset($_POST['pid']) && isset($_GET['v3']) && $_GET['v2'] == 'a' ) {
    $p->load($_POST['pid']);
    if( $p->getOwnerId() == $_SESSION['user']->getUserId() ) {
        $p->addSong($_GET['v3']); 
        $body .= "SONG ADDED";
        header( "Refresh:1; url=./index.php?o=ms&p=" . $_POST['pid'] );    
    } else {
        $body .= "NOT YOUR PLAYLIST";
        header( "Refresh:1; url=./index.php?o=ms" );    
    }
}

include_once 'footer.php';
?>