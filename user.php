<?php

require 'password.php';

class User {
	private $userid;
	private $username;
	private $password;
	private $email;
    private $firstname;
    private $lastname;
	private $db_conx;
	
	public function __construct() {
	}
	
	public function load( $userid ) {
		$this->userid = $userid;	
		$this->refresh();
	}
    
    public function checkLogin( $username, $password ) {
        $db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}

        $sql = "SELECT * from users WHERE username='" . $username ."' AND password='" . $password . "' LIMIT 1";
		$result = $db_conx->query($sql);
		if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->load($row['userid']);
            return true;
        } else { return false; }
        
    }
	
	public function create( $username, $password, $email, $firstname, $lastname ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
        
        $sql = "INSERT INTO users ( `username`, `password`, `email`, `activated`, `hash_act`, `firstname`, `lastname`, `ip`, `signup`, `lastlogin`) VALUES ( '" . $username . "', '" . $password . "', '" . $email . "', '1', '', '" . $firstname . "', '" . $lastname . "', '', CURRENT_TIME(), CURRENT_TIME())";
        $query = $db_conx->query($sql);
		if ( $db_conx->affected_rows > 0 ) {
	        //echo "Signup successful";
            $this->load( $db_conx->insert_id );
            return true;
		} else {
		    echo "Oops, an error occurred.  Please try again. <br>";
			echo $db_conx->error;
			exit();
            return false;
        }
        
	}
	
	
	public function refresh() {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$sql = "SELECT * from users WHERE userid='" . $this->userid ."'";
		$result = $db_conx->query($sql);
		if($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$this->username = $row['username'];
			$this->password = $row['password'];
			$this->email = $row['email'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
		} else {
			$this->userid = NULL;
			$this->email = NULL;
			$this->password = NULL;
			$this->username = NULL;
            $this->firstname = NULL;
            $this->lastname = NULL;
		}
	}
	
    public function setUsername( $username ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->username = $username;
		$sql = "UPDATE users SET username='" . $username . "' WHERE userid='" . $this->userid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			die();
		} 
		//$this->refresh();
	}
    
	public function setEmail( $email ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->email = $email;
		$sql = "UPDATE users SET email='" . $email . "' WHERE userid='" . $this->userid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			die();
		} 
		//$this->refresh();
	}
	
	public function setPassword( $password ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->password = $password;
		$sql = "UPDATE users SET password='" . $password . "' WHERE userid='" . $this->userid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			die();
		} 
		//$this->refresh();
	}
	
	public function setFirstname( $firstname ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->firstname = $firstname;
		$sql = "UPDATE users SET firstname='" . $firstname . "' WHERE userid='" . $this->userid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			die();
		} 
		//$this->refresh();
	}
    
    public function setLastname( $lastname ) {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$this->lastname = $lastname;
		$sql = "UPDATE users SET lastname='" . $lastname . "' WHERE userid='" . $this->userid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			die();
		} 
		//$this->refresh();
	}
    
	public function delete() {
		$db_conx = new mysqli("localhost", "root", "TeamFTeamF", "teamf");
		// Evaluate the connection
		if ($db_conx->connect_errno > 0) {
			echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
			die();
		}
		
		$sql = "DELETE FROM users WHERE userid='" . $this->userid ."'";
		$result = $db_conx->query($sql);
		if($db_conx->affected_rows == 0) {
			die();
		} else {
			$this->userid = NULL;
			$this->email = NULL;
			$this->password = NULL;
			$this->username = NULL;
            $this->firstname = NULL;
            $this->lastname = NULL;
		} 
	}
	
	public function getUsername()  { return $this->username; }
	
	public function getEmail() { return $this->email; }
	
	public function getUserId() { return $this->userid; }
    
    public function getFirstname() { return $this->firstname; }
    
    public function getLastname() { return $this->lastname; }
    
    public function getPassword() { return $this->password; }
}
?>

