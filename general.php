<?php
function sanitize($data) {
	return mysql_real_escape_string($data);
}

function user_exists($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username'");
	return (mysql_result($query,0)) ? true : false;
}

function email_exists($email) {
	$email = sanitize($email);
	$query = mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `email` = '$email'");
	return (mysql_result($query,0)) ? true : false;
}

function id_from_username($username) {
	$username = sanitize($username);
	$result = mysql_result(mysql_query("SELECT `id` FROM `users` WHERE `username` = '$username'"),0,'id');
	return ($result);
}

function id_from_email($email) {
	$email = sanitize($email);
	$result = mysql_query("SELECT `id` FROM `users` WHERE `email` = '$email'");
	$result = mysql_result($result,0);
	return ($result);
}

function login($username, $password) {
	$id = id_from_username($username);
	$username = sanitize($username);
	$password = md5($password);
	$result = mysql_result(mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'"), 0);
	if ($result) {
		return $id;
	} else {
		return false;
	}
}

function check_email($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_current_pass($pass,$id) {
	$pass = sanitize($pass);
	$pass = md5($pass);
	$id = sanitize($id);
	$query = mysql_query("SELECT `id` FROM `users` WHERE `password` = '$pass' AND `id` = '$id'");
	$result = mysql_result($query,0);
	return ($result);
}

function change_pass($id,$pass) {
	$pass = password_hash($pass);
	mysql_query("UPDATE `users` SET `password` = '$pass' WHERE `id` = '$id'");
}

function random_string($length) {
	if( $length <= 0 ) $length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function reset_password($email) {
	$plainpass = random_string();
	$pass = password_hash($plainpass);
	mysql_query("UPDATE `users` SET `password` = '$pass' WHERE `email` = '$email'");
	$message = "Your calendar account password has been reset.\n\nYour new password is " . $plainpass . "\n\nYou can change your password again when you log in at http://teamf.jc-lan.com/login.php\n\nIf you feel that you have recieved this email in error, please contact admin@calendar.com";
	mail($email,'PASSWORD RESET: TEAMF',$message);
}
?>
