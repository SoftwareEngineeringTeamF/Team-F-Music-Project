<?php
class Song {
	private $songid;
	private $title;
	private $artist;
	private $ownerid;
	private $db_conx;
	
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
		return $this->songid;
	}
	
	
	public function refresh() {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			die();
		}
		
		$sql = "SELECT * from songs WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		if($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$this->title = $row['title'];
			$this->artist = $row['artist'];
			$this->ownerid = $row['ownerid'];
		} else {
			$this->songid = NULL;
			$this->ownerid = NULL;
			$this->artist = NULL;
			$this->title = NULL;
		}
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
			return false;
		} else { return true; }
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
			return false;
		} else { return true; }
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
			return false;
		} else { return true; }
	}
    
	public function delete() {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$sql = "DELETE FROM songs WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			return false;
		} else {
			$this->songid = NULL;
			$this->ownerid = NULL;
			$this->artist = NULL;
			$this->title = NULL;
            return true;
		} 
	}
		
	public function getArtist() { return $this->artist;	}
	
	public function getTitle() { return $this->title; }
	
	public function getOwnerId() { return $this->ownerid; }
	
	public function getSongId() { return $this->songid;	}
}
?>

