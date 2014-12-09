<?php
require 'init.php';

if(!isset($_SESSION['user'])) {
    include_once 'login.php';
} else {
	$body .= '<table><tr><th><a href="./logout.php">Logout</a></th><th> ~ </th><th><a href="./index.php?o=public">Public Playlists</a></th><th> ~ </th><th><a href="./index.php?o=private">My Playlists</a></th><th> ~ </th><th><a href="./index.php?o=songs">My Songs</a></th><th> ~ </th><th><a>Create a Playlist</a></th><th> ~ </th><th><a>Upload Songs</a></th></tr></table>';
	if( isset($_GET['o']) && $_GET['o']=='public' ) {
		include_once 'listplaylists.php';
	} else if ( isset($_GET['o']) && $_GET['o']=='private' ) {
		include_once 'listmyplaylists.php';
	} else if ( isset($_GET['o']) && $_GET['o']=='songs' ) {
		include_once 'listmysongs.php';
	} 
}

include_once 'footer.php';
?>