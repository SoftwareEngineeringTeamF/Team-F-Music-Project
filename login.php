<?php
include "init.php";

//if the user has a session going, they shouldn't be seeing the login 
page.
//so redirect them to their calendar
if (isset ($_SESSION['userId'])) {
	header("location:index.php");
}

<form name="form1" method="post" action="checklogin.php<?php 
if(isset($_GET['r'])) echo "?r=" . $_GET['r'];?>">
	<table width="300" border="0" align="center" cellpadding="0" 
cellspacing="1" bgcolor="#CCCCCC">
		<?php if(isset($_GET['r'])) echo "<tr><td><strong>Please 
Login to Continue</strong></td></tr>";?>
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" 
cellspacing="1" bgcolor="#FFFFFF">
			<tr>
				<td colspan="3"><strong>Member Login 
</strong></td>
			</tr>
			<tr>
				<td width="78">Username</td>
				<td width="6">:</td>
				<td width="294"><input name="myusername" 
type="text" id="myusername"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td>:</td>
				<td><input name="mypassword" 
type="password" id="mypassword"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input type="submit" name="Submit" 
value="Login"></td>
			</tr>
		</table>
		</td>
		</tr>
	</table>
		</form>

<p align="center"> <a href="signup.php">Register new account?</a>   </p>

include_once "footer.php";
?>
