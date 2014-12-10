<?php
require 'init.php';

if(!isset($_SESSION['user'])) {
    include_once 'login.php';
} else {
	$body .= '<center><table><tr><th><a href="./logout.php">Logout</a></th><th> ~ </th><th><a href="./index.php?o=pp">Public Playlists</a></th><th> ~ </th><th><a href="./index.php?o=mp">My Playlists</a></th><th> ~ </th><th><a href="./index.php?o=ep">Playlist Management</a></th><th> ~ </th><th><a href="./index.php?o=ms">Song Management</a></th><th> ~ </th><th><a href="./index.php?o=cp">Create a Playlist</a></th><th> ~ </th><th><a href="./index.php?o=us">Upload Songs</a></th></tr></table></center>';
	if( isset($_GET['o']) && $_GET['o']=='pp' ) {
		include_once 'listplaylists.php';
	} else if ( isset($_GET['o']) && $_GET['o']=='mp' ) {
		include_once 'listmyplaylists.php';
	} else if ( isset($_GET['o']) && $_GET['o']=='cp' ) {
		include_once 'createplaylist.php';
    } else if ( isset($_GET['o']) && $_GET['o']=='ep' ) {
		include_once 'editplaylist.php';
	} else if ( isset($_GET['o']) && $_GET['o']=='ms' ) {
		include_once 'listmysongs.php';
    } else if ( isset($_GET['o']) && $_GET['o']=='mv' ) {
		include_once 'movesong.php';
    } else if ( isset($_GET['o']) && $_GET['o']=='us' ) {
		include_once 'upload.php';
	} else if ( isset($_GET['o']) && $_GET['o']=='tp') {
        if ( isset( $_GET['v1']) && isset( $_GET['v2']) ) {
            include_once 'toggleplaylist.php';
        } else {
            header( "Refresh:0; url=./index.php" );
        }
    } else if ( isset($_GET['o']) && $_GET['o']=='dp' && isset($_GET['v1']) ) {
        include_once 'deleteplaylist.php';
    } else if ( isset($_GET['o']) && $_GET['o']=='ds' && isset($_GET['v1']) ) {
        include_once 'deletesong.php';
    } else
        include_once 'listmyplaylists.php';
}

include_once 'footer.php';
?>