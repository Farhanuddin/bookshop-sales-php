<?php

require('configs/constants.php');

/**
Class for Database operations
*/

class Db {

	private $server   = SERVER;
	private $username = USER_NAME;
	private $password = PASSWORD;
	private $database = DATABASE;
	protected $conn;

	function __construct(){
		$this->conn = $this->connect();
	}	

	//Make PDO Connection for more secure queries and connection request..
	protected function connect(){
		
	 try{

	   $conn = new PDO("mysql:host=".$this->server.";dbname=".$this->database, $this->username, $this->password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	   return $conn;

	 }catch(PDOException $e){
	   echo "Connection failed: " . $e->getMessage();
	 }		
	}

	//Return db PDO connection
	public function getConnection(){
		return $this->conn;
	}
}
