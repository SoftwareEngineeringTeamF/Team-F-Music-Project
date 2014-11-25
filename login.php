<?php
include "init.php";

//if the user has a session going, they shouldn't be seeing the login page.
//so redirect them to their calendar
if (isset ($_SESSION['userid'])) {
	header("location:index.php");
}
?>
<form name="form1" method="post" action="checklogin.php<?php 
if(isset($_GET['r'])) echo "?r=" . $_GET['r'];?>">
		<?php if(isset($_GET['r'])) echo "<tr><td><strong>Please 
Login to Continue</strong></td></tr>";?>
<strong>Member Login</strong><br>
Username:<input name="myusername" type="text" id="myusername"><br>
Password:<input name="mypassword" type="password" id="mypassword"><br>
<input type="submit" name="Submit" value="Login">
</form>

<p align="center"> <a href="signup.php">Register new account?</a>   </p>

<?php
include_once "footer.php";
?>
