<?php
require 'init.php';
require 'connect.php';

$sql = "SELECT * FROM songs ORDER BY songid";
$query= $db_conx->query($sql);
$userlist= "<table><tr><th>songid</th><th>ownerid</th><th>artist</th><th>title</th></tr>";
if( $query->num_rows > 0 ) {
	while ( $row=$query->fetch_assoc() ) {
		$u= $row["username"];
		$userlist .= "<tr><td>" . $row['songid'] . "</td><td>" . $row['ownerid'] . "</td><td>" . $row['artist'] . "</td><td>" . $row['title'] . "</td></tr>";
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
	echo "NO SONGS";
}

	include_once "footer.php";
?>
