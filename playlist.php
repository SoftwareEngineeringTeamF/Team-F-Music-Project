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
	
	public function refresh() {
        $db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		$sql = "SELECT * from playlists WHERE playlistid='" . $this->playlistid . "' LIMIT 1";
		$result = $db_conx->query($sql);
		while( $row = $result->fetch_assoc() ) {
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->ownerid = $row['ownerid'];
            $this->public = $row['public'];
        }
		
		// get array of song id's in order
		$sql = "SELECT * from members WHERE playlistid='" . $this->playlistid . "' ORDER BY listindex";
		$result = $db_conx->query($sql);
		$this->num_songs = $result->num_rows;
        $n = 0;
		while($n < $this->num_songs) {
            $row = $result->fetch_assoc();
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
        $s = new Song();
        $s->load($this->songs[$listindex]);
        return $s;
	}
	
	public function promoteSong( $listindex ) {
		if( $listindex <= 0 || $listindex >= $this->num_songs) {
			return false;
		} else {
            $db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
            // Evaluate the connection
            if ($db_conx->connect_errno > 0) {
                echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
                die();
            }
            
			$sql = "SELECT memberid, songid FROM members WHERE playlistid='" . $this->playlistid . "' AND listindex='" . $listindex . "'";
			$result = $db_conx->query($sql);
            if( $result->num_rows == 0) { return false; }
            $row = $result->fetch_assoc();
			$i0 = $row['memberid'];
			$s0 = $row['songid'];
			$sql = "SELECT memberid, songid FROM members WHERE playlistid='" . $this->playlistid . "' AND listindex='" . ($listindex-1) . "'";
			$result = $db_conx->query($sql);
			if( $result->num_rows == 0 ) { return false; }
            $row = $result->fetch_assoc();
			$i1 = $row['memberid'];
			$s1 = $row['songid'];
			
			$sql = "UPDATE members SET listindex='" . ($listindex-1) . "' WHERE memberid='" . $i0 ."'";
			$result = $db_conx->query($sql);
            if( $db_conx->affected_rows == 0) { return false; }
			$sql = "UPDATE members SET listindex='" . $listindex . "' WHERE memberid='" . $i1 ."'";
			$result = $db_conx->query($sql);
            if( $db_conx->affected_rows == 0) { return false; }
			
            $this->refresh();
			
            return true;
		}
	}
	
	public function demoteSong( $index ) {
		return $this->promoteSong( $index+1 );
	}
    
    public function getNumSongs() { return $this->num_songs; }
	
	public function getDescription() { return $this->description; }
	
	public function getTitle() { return $this->title; }
	
	public function getOwnerId() { return $this->ownerid; }
	
	public function getPlaylistId() { return $this->playlistid;	}
	
	public function getPublic() { return $this->public; }
    
    public function getSongs() { return $this->songs; }
}
?>
