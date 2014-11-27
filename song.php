<?php
//require 'connect.php';

class Song {
	private $songid;
	private $title;
	private $artist;
	private $ownerid;
	
	public function __construct() {
	}
	
	public function load( $songid ) {
		$this->songid = $songid;	
		$this->refresh();
	}
	
	public function create( $ownerid, $title, $artist ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->ownerid = $ownerid;
		$this->title = $title;
		$this->artist = $artist;
		
		$sql = "INSERT INTO songs( songid, ownerid, title, artist ) VALUES ( NULL, '" . $ownerid . "', '" . $title . "', '" . $artist . "')";
		$result = $db_conx->query($sql);
		$this->songid = $db_conx->insert_id;
		echo "[SONG] CREATE ID: " . $this->songid . "<br>";
		return $this->songid;
	}
	
	
	public function refresh() {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		echo "[SONG] REFRESHING ID: " . $this->songid . "<br>";
		$sql = "SELECT * from songs WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		echo "[SONG] MATCHING IDS FOUND: " . $result->num_rows . "<br>";
		$row = $result->fetch_assoc();
		$this->title = $row['title']; echo "[SONG] REFRESH TITLE: " . $this->title . "<BR>";
		$this->artist = $row['artist']; echo "[SONG] REFRESH ARTIST: " . $this->artist . "<BR>";
		$this->ownerid = $row['ownerid']; echo "[SONG] REFRESH OWNERID: " . $this->ownerid . "<BR>";
	}
	
	public function setOwnerId( $ownerid ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->ownerid = $ownerid;
		$sql = "UPDATE songs SET ownerid='" . $ownerid . "' WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			echo "[SONG] FAILED: setOwnerId";
			die();
		} 
		//$this->refresh();
	}
	
	public function setArtist( $artist ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->artist = $artist;
		$sql = "UPDATE songs SET artist='" . $artist . "' WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			echo "[SONG] FAILED: setArtist";
			die();
		} 
		//$this->refresh();
	}
	
	public function setTitle( $title ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->title = $title;
		$sql = "UPDATE songs SET title='" . $title . "' WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			echo "[SONG] FAILED: setTitle";
			die();
		} 
		//$this->refresh();
	}
	
	public function getArtist() {
		return $this->artist;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getOwnerId() {
		return $this->ownerid;
	}
	
	public function getSongId() {
		return $this->songid;
	}
}
?>
