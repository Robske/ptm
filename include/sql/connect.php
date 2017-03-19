<?php
class connect {
	public $conn;
	public $test;

	function __construct() {
		$server = "localhost";
		$user = "root";
		$password = "";
		$db = "ptm";
		/* Live
		$server = "rdbms.strato.de";
		$user = "U2770680";
		$password = "thisdbhasaverycoolpassword5";
		$db = "DB2770680";
		*/
		$this->conn = new mysqli($server, $user, $password, $db);
		$this->test = "hey <br>";
	}
}

$connect = new connect();
// echo $connect->test;