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
	}
}

$connect = new connect();
