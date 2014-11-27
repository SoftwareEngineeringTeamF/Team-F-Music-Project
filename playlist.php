<?php
require "song.php";

class Playlist {
	private $playlistid;
	private $ownerid;
	private $public;
	private $title;
	private $description;
	private $num_songs;
	private $songs;
	
	public function __construct() {
        $this->songs = array();
	}
	
	public function load( $playlistid ) {
		$this->playlistid = $playlistid;
        echo "[PLAYLIST] Loading ID: " . $playlistid . "<BR>";
		$this->refresh();
	}
	
	public function create( $ownerid, $public, $title, $description ) {
        $db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
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
        $db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		echo "[PLAYLIST] Refreshing with ID: " . $this->playlistid . "<BR>";
		$sql = "SELECT * from playlists WHERE playlistid='" . $this->playlistid . "' LIMIT 1";
		$result = $db_conx->query($sql);
        echo "[PLAYLIST] Playlists found with ID " . $this->playlistid . ": " . $result->num_rows . "<BR>";
		while( $row = $result->fetch_assoc() ) {
            $this->title = $row['title'];
            echo "[PLAYLIST] Read Title: " . $this->title . "<br>";
            $this->description = $row['description'];
            echo "[PLAYLIST] Read Description: " . $this->description . "<br>";
            $this->ownerid = $row['ownerid'];
            echo "[PLAYLIST] Read OwnerID: " . $this->ownerid . "<br>";
            $this->public = $row['public'];
            echo "[PLAYLIST] Read Public: " . $this->public . "<br>";
        }
		
		// get array of song id's in order
		$sql = "SELECT * from members WHERE playlistid='" . $this->playlistid . "' ORDER BY listindex";
		$result = $db_conx->query($sql);
        echo "[PLAYLIST] Loading " . $result->num_rows . " songs.<br>";
		$this->num_songs = $result->num_rows;
        $n = 0;
		while($n < $this->num_songs) {
            $row = $result->fetch_assoc();
            echo "[PLAYLIST] Added songs[".$n."] ID:" . $row['songid'] . "<BR>";
			//$songs[$row['listindex']] = new Song();
            //$songs[$row['listindex']]->load($row['songid']);
            $this->songs[$n] = $row['songid'];
            $n++;
		}
		
	}
		
	public function setTitle( $title ) {
        $db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->title = $title;
		$sql = "UPDATE playlists SET title='" . $title . "' WHERE playlistid='" . $this->playlistid ."'";
		$result = $db_conx->query($sql);
		$this->refresh();
	}
	
	public function setDescription( $artist ) {
        $db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->description = $description;
		$sql = "UPDATE playlists SET artist='" . $artist . "' WHERE playlistid='" . $this->playlistid ."'";
		$result = $db_conx->query($sql);
		$this->refresh();
	}
	
	public function setPublic( $public ) {
        $db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->public = $public;
		$sql = "UPDATE playlists SET public='" . $artist . "' WHERE playlistid='" . $this->playlistid ."'";
		$result = $db_conx->query($sql);
		$this->refresh();
	}
	public function getSong( $listindex ) {
        echo "[PLAYLIST] Getting Song ID: " . $listindex . "<br>";
        //if(isset($song[$listindex]))
        //    return $this->song[$listindex];
        //else
        //    return false;
        $s = new Song();
        $s->load($this->songs[$listindex]);
        return $s;
	}
	
	public function promoteSong( $listindex ) {
		if( $listindex <= 0 || $listindex >= $this->num_songs) {
			return false;
		} else if(isset($song[$listindex])) {
			$sql = "SELECT membersid, songid FROM members WHERE playlistid='" . $this->playlistid . "' AND listindex='" . $index . "'";
			$result = $db_conx->query($sql);
			$row = $result->fetch_assoc();
			$i0 = $row['membersid'];
			$s0 = $row['songid'];
			$sql = "SELECT membersid, songid FROM members WHERE playlistid='" . $this->playlistid . "' AND listindex='" . $index-1 . "'";
			$result = $db_conx->query($sql);
			$result = $db_conx->query($sql);
			$row = $result->fetch_assoc();
			$i1 = $row['membersid'];
			$s1 = $row['songid'];
			
			$sql = "UPDATE members SET listindex='" . $listindex-1 . "' WHERE membersid='" . $i0 ."'";
			$result = $db_conx->query($sql);
			$sql = "UPDATE members SET listindex='" . $listindex . "' WHERE membersid='" . $i1 ."'";
			$result = $db_conx->query($sql);
			
			$st = $songs[$listindex-1];
			$songs[$listindex-1] = $songs[$listindex];
			$songs[$listindex] = $st;
			
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
    
    public function getNumSongs() {
        return $this->num_songs;
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
    
    public function getSongs() {
        return $this->songs;
    }
}
?>
