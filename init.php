<?php
$stime = microtime(true);
?>
<?php


//connect to database. if that fails, die on the spot.
//require 'connect.php';

//all of our important database functions are in here.
require 'general.php';
require 'playlist.php';
require 'user.php';
//require 'password.php';

session_start();

include_once "header.php";
?>
