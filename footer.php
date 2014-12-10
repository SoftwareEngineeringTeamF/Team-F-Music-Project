<?php echo $body; ?>
<center>
<?php

if (isset($stime)) {
echo 'Page generated in '.number_format((microtime(true) - 
$stime)*1000000, 
0).' 
 &micro;s.';
}
?>
<br/ >
<a href="info.php">phpInfo</a> ~ <a href="listusers.php">LIST USERS</a> ~ <a href="listsongs.php">LIST SONGS</a> ~ <a href="listplaylists.php">LIST PLAYLISTS</a> ~ <a href="reset.php">RESET DB</a></center>
</div>
</div>
</td></tr></table></center>
</body>
</html>
