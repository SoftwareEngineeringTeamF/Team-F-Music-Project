<?php
include_once 'init.php';

if( isset($_FILES) && isset($_POST['title']) && isset($_POST['artist']) ) {
    $uploaddir = './songs/';
    $s = new Song();
    $s->create( $_SESSION['user']->getUserId(), $_POST['title'], $_POST['artist'] );
    $uploadfile = $uploaddir . $s->getSongId() . ".mp3";
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $body .= "File is valid, and was successfully uploaded.\n";
        header( "Refresh:0; url=./index.php?o=ms" );
    } else {
        $body .= "Possible file upload attack!\n";
        header( "Refresh:5; url=./index.php?o=ms" );
    }

    
} else {
    $body .= '<h2>Upload a song:</h2><form enctype="multipart/form-data" action="" method="post"><input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><table>';
    $body .= '<tr><td>Artist:</td><td><input name="artist" /></td></tr>';
    $body .= '<tr><td>Title:</td><td><input name="title" /></td></tr>';
    $body .= '<tr><td>File: </td><td><input name="userfile" type="file" /></td></tr>';
    $body .= '<tr><td><input type="submit" value="Upload Song" /></td><td></td></tr>';
    $body .= '</table></form>';
}

include_once 'footer.php';
?>