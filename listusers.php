<?php
require 'init.php';

$sql = "SELECT username FROM users where AND activated='1' ORDER BY RAND() LIMIT 32";
$query= $db_conx->query($sql);
$userlist= "";
if( $query->num_rows > 0 ) {
	while ($row=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$u= $row["username"];
		$userlist .= '<a href="user.php?u=' .$u.'" title="'.$u.'"></a>';
	} 

?>

<body>
<div id="middle page" style="margin-left: 200px;">
<h3> Random People Chosen from the Database: </h3>
<br>
<?php 
	echo $userlist;
} else {
	echo "NO USERS";
}

	include_once "footer.php";
?>
