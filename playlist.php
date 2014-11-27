<?php
require "song.php";

class Playlist {
	protected $playlistid;
	protected $ownerid;
	protected $public;
	protected $title;
	protected $description;
	protected $num_songs;
	protected $songs = array();
	
	private function __construct() {
	}
	
	public function load( $playlistid ) {
		$this->$playlistid = $playlistid;
		$this->refresh();
	}
	
	public function create( $ownerid, $public, $title, $description ) {
		$this->ownerid = $ownerid;
		$this->public = $public;
		$this->title = $title;
		$this->description = $description;
		$this->num_songs = 0;
		
		$sql = "INSERT INTO playlists( playlistid, ownerid, public, title, description ) VALUES ( NULL, '".$ownerid."', '".$public."', '".$title."', '".$artist."')";
		$result = $db_conx($sql);
		$this->playlistid = $db_conx->insert_id;
	}
	
	protected function refresh() {
		$sql = "SELECT * from playlists WHERE playlistid='" . $this->playlistid . "'";
		$result = $db_conx->query($sql);
		$row = $query->fetch_assoc();
		$title = $row['title'];
		$description = $row['description'];
		$ownerid = $row['ownerid'];
		$public = $row['public'];
		
		// get array of song id's in order
		$sql = "SELECT * from members WHERE playlistid='" . $this->playlistid . "' ORDER BY index";
		$result = $db_conx->query($sql);
		$this->num_songs = $result->num_rows;
		while($row = $query->fetch_assoc()) {
			$songs[$row['index']] = new Song($row['songid']);
		}
		
	}
		
	public function setTitle( $title ) {
		$this->title = $title;
		$sql = "UPDATE playlists SET title='" . $title . "' WHERE playlistid='" . $this->playlistid ."'";
		$result = $db_conx->query($sql);
		$this->refresh();
	}
	
	public function setDescription( $artist ) {
		$this->description = $description;
		$sql = "UPDATE playlists SET artist='" . $artist . "' WHERE playlistid='" . $this->playlistid ."'";
		$result = $db_conx->query($sql);
		$this->refresh();
	}
	
	public function setPublic( $public ) {
		$this->public = $public;
		$sql = "UPDATE playlists SET public='" . $artist . "' WHERE playlistid='" . $this->playlistid ."'";
		$result = $db_conx->query($sql);
		$this->refresh();
	}
	public function getSong( $index ) {
		if(isset($song[$index]))
			return $this->song[$index];
		else
			return false;
	}
	
	public function promoteSong( $index ) {
		if( $index <= 0 || $index >= $this->num_songs) {
			return false;
		} else if(isset($song[$index])) {
			$sql = "SELECT membersid, songid FROM members WHERE playlistid='" . $this->playlistid . "' AND index='" . $index . "'";
			$result = $db_conx->query($sql);
			$row = $result->fetch_assoc();
			$i0 = $row['membersid'];
			$s0 = $row['songid'];
			$sql = "SELECT membersid, songid FROM members WHERE playlistid='" . $this->playlistid . "' AND index='" . $index-1 . "'";
			$result = $db_conx->query($sql);
			$result = $db_conx->query($sql);
			$row = $result->fetch_assoc();
			$i1 = $row['membersid'];
			$s1 = $row['songid'];
			
			$sql = "UPDATE members SET index='" . $index-1 . "' WHERE membersid='" . $i0 ."'";
			$result = $db_conx->query($sql);
			$sql = "UPDATE members SET index='" . $index . "' WHERE membersid='" . $i1 ."'";
			$result = $db_conx->query($sql);
			
			$st = $songs[$index-1];
			$songs[$index-1] = $songs[$index];
			$songs[$index] = $st;
			
			//or just completely recreate objects in array
			//unset($song[$index]);
			//unset($song[$index-1]);
			//$song[$index-1] = new Song(); $songs[index-1]->load($s0);
			//$song[$index] = new Song(); $songs[index]->load($s1);
		} else {
			return false;
		}
	}
	
	public function demoteSong( $index ) {
		if( $index >= $this->num_songs-1 || $index < 0 ) {
			return false;
		} else if(isset($song[$index+1])) {
			$sql = "SELECT membersid, songid FROM members WHERE playlistid='" . $this->playlistid . "' AND index='" . $index+1 . "'";
			$result = $db_conx->query($sql);
			$row = $result->fetch_assoc();
			$i0 = $row['membersid'];
			$s0 = $row['songid'];
			$sql = "SELECT membersid WHERE FROM members playlistid='" . $this->playlistid . "' AND index='" . $index . "'";
			$result = $db_conx->query($sql);
			$row = $result->fetch_assoc();
			$i1 = $row['membersid'];
			$s1 = $row['songid'];
					
			$sql = "UPDATE members SET index='" . $index . "' WHERE membersid='" . $i0 ."'";
			$result = $db_conx->query($sql);
			$sql = "UPDATE members SET index='" . $index+1 . "' WHERE membersid='" . $i1 ."'";
			$result = $db_conx->query($sql);
			
			$st = $songs[$index+1];
			$songs[$index+1] = $songs[$index];
			$songs[$index] = $st;
			
			//or just completely recreate objects in array
			//unset($song[$index]);
			//unset($song[$index-1]);
			//$songs[$index] = new Song(); $songs[$index]->load($s0);
			//$songs[$index+1] = new Song(); $songs[$index+1]->load($s1);
		} else {
			return false;
		}
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getOwnerId() {
		return $this->ownerid;
	}
	
	public function getPlaylistId() {
		return $this->playlistid;
	}
	
	public function getPublic() {
		return $this->public;
	}
}
?>
