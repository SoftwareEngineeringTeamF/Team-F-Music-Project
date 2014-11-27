<?php
require "connect.php";

class Song {
	private $songid;
	private $title;
	private $artist;
	private $ownerid;
	
	public function __construct( $songid ) {
		$this->$songid = $songid;
		$this->refresh();
	}
	
	protected function refresh() {
		$sql = "SELECT * from songs WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		$row = $query->fetch_array(MYSQLI_ASSOC);
		$title = $row['title'];
		$artist = $row['artist'];
		$ownerid = $row['ownerid'];
	}
	
	public function setArtist( $artist ) {
		$this->artist = $artist;
		$sql = "UPDATE users SET artist='" . $artist . "' WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		$this->refresh();
	}
	
	public function setTitle( $title ) {
		$this->title = $title;
		$sql = "UPDATE songs SET title='" . $title . "' WHERE songid='" . $this->songid ."'";
		$result = $db_conx->query($sql);
		$this->refresh();
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
