<?php
$stime = microtime(true);
?>
<?php
session_start();

//connect to database. if that fails, die on the spot.
//require 'connect.php';

//all of our important database functions are in here.
require 'general.php';
require 'song.php';
//require 'password.php';

include_once "header.php";
?>
