<?php
include_once "init.php";
include_once "connect.php";

$sql = "SELECT username FROM users where AND activated='1' ORDER BY RAND() LIMIT 32";
$query= mysqli_query($db_conx, $sql);
$userlist= "";
if( mysqli_num_rows( $query ) > 0 ) {
	while ($row =mysqli_fetch_array($query, MYSQLI_ASSOC)) {
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
