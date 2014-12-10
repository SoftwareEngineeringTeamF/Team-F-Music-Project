<?php

$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
// Evaluate the connection
if ($db_conx->connect_errno > 0) {
    echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
    die();
}

header( "Refresh:10; url=./index.php" );

$sql = "TRUNCATE members";
var_dump($sql); echo "<BR>";
$query= $db_conx->query($sql);

$sql = "TRUNCATE songs";
var_dump($sql); echo "<BR>";
$query= $db_conx->query($sql);

$sql = "TRUNCATE users";
var_dump($sql); echo "<BR>";
$query= $db_conx->query($sql);

$sql = "TRUNCATE playlists";
var_dump($sql); echo "<BR>";
$query= $db_conx->query($sql);

if( $sql = file_get_contents( "teamf.sql" ) ){
    echo "IMPORTING TABLES<BR>";
    $query= $db_conx->multi_query($sql);
} else
    echo "COULD NOT LOAD BACKUP DB.";


echo "DB RESET COMPLETE, REDIRECTING in 10 SECONDS";
?>