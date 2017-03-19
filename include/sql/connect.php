<?php
class connect {
	public $conn;
	public $test;

	function __construct() {
		$server = "localhost";
		$user = "root";
		$password = "";
		$db = "ptm";

		$this->conn = new mysqli($server, $user, $password, $db);
		$this->test = "hey <br>";
	}
}

$connect = new connect();
// echo $connect->test;