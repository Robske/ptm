<?php
session_start();
if (isset($_SESSION["access"]) && isset($_SESSION["username"])) {
	unset($_SESSION["access"]);
	unset($_SESSION["username"]);
	header("Location: /");
} else {
	header("Location: /");
}