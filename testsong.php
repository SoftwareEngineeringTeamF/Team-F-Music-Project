<?php
require 'song.php';

function random_string($length) {
	if( $length <0 ) $length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function echosong( Song $s0 ){
	echo "ID: " . $s0->getSongId() . "<br>OI: " . $s0->getOwnerId() . "<br>AR: " . $s0->getArtist() . "<br>TI: " . $s0->getTitle() . "<br>";
}

//test load
$s0 = new Song();
echo "<strong>Create Song Object and load 1 from db</strong><br>";
$s0->load(1);
echosong($s0);
if($s0->getSongId() == 1) echo "PASS ID<BR>"; else echo "FAIL ID<BR>";
if($s0->getOwnerId() == 1) echo "PASS OwnerID<BR>"; else echo "FAIL OwnerID<BR>";
if($s0->getArtist() == "Artist") echo "PASS Artist<BR>"; else echo "FAIL Artist<BR>";
if($s0->getTitle() == "Title") echo "PASS Title<BR>"; else echo "FAIL Title<BR>"; echo "<HR>";

//test create
$artist = random_string(5);
$title = random_string(10);
$s1 = new Song();
echo "<strong>Create new Song Object ownerid: 1, artist: ". $artist . " title: " . $title ."</strong><br>";
$id = $s1->create(1,$title, $artist);
echosong($s1);
if($s1->getSongId() == $id) echo "PASS ID<BR>"; else echo "FAIL ID<BR>";
if($s1->getOwnerId() == 1) echo "PASS OwnerID<BR>"; else echo "FAIL OwnerID<BR>";
if($s1->getArtist() == $artist) echo "PASS Artist<BR>"; else echo "FAIL Artist<BR>";
if($s1->getTitle() == $title) echo "PASS Title<BR>"; else echo "FAIL Title<BR>"; echo "<HR>";
unset($s1);

//test load last
echo "<strong>New Object, load last created</strong><br>";
$s2 = new Song();
$s2->load($id);
echosong($s2);
if($s2->getSongId() == $id) echo "PASS ID<BR>"; else echo "FAIL ID<BR>";
if($s2->getOwnerId() == 1) echo "PASS OwnerID<BR>"; else echo "FAIL OwnerID<BR>";
if($s2->getArtist() == $artist) echo "PASS Artist<BR>"; else echo "FAIL Artist<BR>";
if($s2->getTitle() == $title) echo "PASS Title<BR>"; else echo "FAIL Title<BR>"; echo "<HR>";

//test modify artist
$new_artist = random_string(5);
echo "<strong>Modify Artist on Created Object to: " . $new_artist . "</strong><br>";
$s2->refresh();
$s2->setArtist($new_artist);
$s2->refresh();
echosong($s2);
if($s2->getArtist() == $new_artist) echo "PASS"; else echo "FAIL"; echo "<BR><HR>";

//test modify title
$new_title = random_string(10);
echo "<strong>Modify Title on Created Object to: " . $new_title . "</strong><br>";
$s2->refresh();
$s2->setTitle($new_title);
$s2->refresh();
echosong($s2);
if($s2->getTitle() == $new_title) echo "PASS"; else echo "FAIL"; echo "<BR><HR>";

//test modify ownerid
echo "<strong>Modify ownerid on Created Object to: " . 2 . "</strong><br>";
$s2->refresh();
$s2->setOwnerId(2);
$s2->refresh();
echosong($s2);
if($s2->getOwnerId() == 2) echo "PASS"; else echo "FAIL"; echo "<BR><hr>";

//test delete
echo "<strong>Delete created from db</strong><br>";
$s2->delete();
echosong($s2);
unset ($s2);
?>
