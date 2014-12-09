<?php
require 'init.php';

//if the user has a session going, they shouldn't be seeing the login page.
//so redirect them to their calendar
if (isset ($_SESSION['user'])) {
	echo "Already logged in.";
} else {
?>
<form name="form1" method="post" action="checklogin.php<?php if(isset($_GET['r'])) echo "?r=" . $_GET['r'];?>">
		<?php if(isset($_GET['r'])) echo "<tr><td><strong>Please Login to Continue</strong></td></tr>";?>
<strong>Member Login</strong><br>
<table><tr><td>Username:</td><td><input name="myusername" type="text" id="myusername"></td></tr>
<tr><td>Password:</td><td><input name="mypassword" type="password" id="mypassword"></td></tr>
<tr><td><input type="submit" name="Submit" value="Login"></td></tr>
</table></form>

<p align="center"> <a href="signup.php">Register new account?</a>   </p>

<?php
}
include_once "footer.php";
?>
