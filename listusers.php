<?php
require 'init.php';

$sql = "SELECT * FROM users where activated='1' ORDER BY username";
$query= $db_conx->query($sql);
$userlist= "<table><tr><th>userid</th><th>username</th><th>email</th><th>activated</th><th>hash_act</th><th>firstname</th><th>lastname</th><th>ip</th><th>signup</th><th>lastlogin</th></tr>";
if( $query->num_rows > 0 ) {
	$rows=0;
	while ( $rows < $query->num_rows ) {
		$row=$query->fetch_array(MYSQLI_ASSOC);
		$u= $row["username"];
		$userlist .= "<tr><td>" . $row['userid'] . "</td><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $row["activated"] . "</td><td>" . $row["hash_act"] . "</td><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td><td>" . $row["ip"] . "</td><td>" . $row["signup"] . "</td><td>" . $row["lastlogin"] . "</td></tr>";
		$rows++;
	}
	$userlist .= "</table>";

?>

<body>
<div id="middle page" style="margin-left: 200px;">
<br>
<?php 
	echo "Number of rows: " . $query->num_rows . "<br>";
	echo $userlist;
} else {
	echo "NO USERS";
}

	include_once "footer.php";
?>
