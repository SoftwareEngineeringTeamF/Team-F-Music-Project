<?php
require 'init.php';

function echouser( User $s0 ){
	echo "ID: " . $s0->getUserId() . "<br>UN: " . $s0->getUsername() . "<br>EM: " . $s0->getEmail() . "<br>FN: " . $s0->getFirstname() . "<br>LN: " . $s0->getLastname() . "<br>";
}

//test load
$s0 = new User($db_conx);
echo "<strong>Create User Object and load 1 from db</strong><br>";
$s0->load(1);
echouser($s0);
if($s0->getUserId() == 1) echo "PASS ID<BR>"; else echo "FAIL ID<BR>";
if($s0->getUsername() == "User") echo "PASS Username<BR>"; else echo "FAIL Username<BR>";
if($s0->getEmail() == "Email@Mail.com") echo "PASS Email<BR>"; else echo "FAIL Email<BR>";
if($s0->getFirstname() == "Test") echo "PASS Firstname<BR>"; else echo "FAIL Firstname<BR>";
if($s0->getLastname() == "User") echo "PASS Lastname<BR>"; else echo "FAIL Lastname<BR>"; echo "<HR>";


//test create
$username = random_string(5);
$firstname = random_string(5);
$lastname = random_string(5);
$password = random_string(10);
$email = "testemail@domain.com";
$s1 = new User();
echo "<strong>Create new User Object ownerid: 1, username: ". $username . " password: " . $password . " email: " . $email ." firstname: " . $firstname . " lastname: " . $lastname ."</strong><br>";
if( $s1->create( $username, $password, $email, $firstname, $lastname ) ) {
    echouser($s1);
    if($s1->getUsername() == $username) echo "PASS Username<BR>"; else echo "FAIL Username<BR>";
    if($s1->getPassword() == $password) echo "PASS Password<BR>"; else echo "FAIL Password<BR>";
    if($s1->getEmail() == $email) echo "PASS Email<BR>"; else echo "FAIL Email<BR>";
    if($s1->getFirstname() == $firstname) echo "PASS Firstname<BR>"; else echo "FAIL Firstname<BR>";
    if($s1->getLastname() == $lastname) echo "PASS Lastname<BR>"; else echo "FAIL Lastname<BR>"; echo "<HR>";
    $id = $s1->getUserId();
}
unset($s1);

//test load last
echo "<strong>New Object, load last created</strong><br>";
$s2 = new User();
$s2->load($id);
echouser($s2);
if($s2->getUsername() == $username) echo "PASS Username<BR>"; else echo "FAIL Username<BR>";
if($s2->getPassword() == $password) echo "PASS Password<BR>"; else echo "FAIL Password<BR>";
if($s2->getEmail() == $email) echo "PASS Email<BR>"; else echo "FAIL Email<BR>";
if($s2->getFirstname() == $firstname) echo "PASS Firstname<BR>"; else echo "FAIL Firstname<BR>";
if($s2->getLastname() == $lastname) echo "PASS Lastname<BR>"; else echo "FAIL Lastname<BR>"; echo "<HR>";

//test modify username
$new_username = random_string(5);
echo "<strong>Modify Username on Created Object to: " . $new_usernamne . "</strong><br>";
$s2->refresh();
$s2->setUsername($new_username);
$s2->refresh();
echouser($s2);
if($s2->getUsername() == $new_username) echo "PASS"; else echo "FAIL"; echo "<BR><HR>";

//test modify email
$new_email = "Test2email@domain.com";
echo "<strong>Modify Email on Created Object to: " . $new_email . "</strong><br>";
$s2->refresh();
$s2->setEmail($new_email);
$s2->refresh();
echouser($s2);
if($s2->getEmail() == $new_email) echo "PASS"; else echo "FAIL"; echo "<BR><HR>";

//test modify password
$new_password = random_string(5);
echo "<strong>Modify password on Created Object to: " . $new_password . "</strong><br>";
$s2->refresh();
$s2->setPassword($new_password);
$s2->refresh();
echouser($s2);
if($s2->getPassword() == $new_password) echo "PASS"; else echo "FAIL"; echo "<BR><HR>";

//test modify firstname
$new_fn = random_string(5);
echo "<strong>Modify firstname on Created Object to: " . $new_fn . "</strong><br>";
$s2->refresh();
$s2->setFirstname($new_fn);
$s2->refresh();
echouser($s2);
if($s2->getFirstname() == $new_fn) echo "PASS"; else echo "FAIL"; echo "<BR><HR>";

//test modify lastname
$new_ln = random_string(5);
echo "<strong>Modify lastname on Created Object to: " . $new_ln . "</strong><br>";
$s2->refresh();
$s2->setLastname($new_ln);
$s2->refresh();
echouser($s2);
if($s2->getLastname() == $new_ln) echo "PASS"; else echo "FAIL"; echo "<BR><HR>";

//test delete
echo "<strong>Delete created from db</strong><br>";
$s2->delete();
echouser($s2);
unset ($s2);

include_once "footer.php";
?>
