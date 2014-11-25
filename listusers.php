<?php
require 'init.php';

$sql = "SELECT username FROM users where activated='1' ORDER BY username";
$query= $db_conx->query($sql);
$userlist= "";
if( $query->num_rows > 0 ) {
	$rows=0;
	while ( $rows < $query->num_rows ) {
		$row=$query->fetch_array(MYSQLI_ASSOC);
		$u= $row["username"];
		$userlist .= $rows+1 . " " . $u . "<br>";
		$rows++;
	}

?>

<body>
<div id="middle page" style="margin-left: 200px;">
<h3> Random People Chosen from the Database: </h3>
<br>
<?php 
	echo "Number of rows: " . $query->num_rows . "<br>";
	echo $userlist;
} else {
	echo "NO USERS";
}

	include_once "footer.php";
?>
