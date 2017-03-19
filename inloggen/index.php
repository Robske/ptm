<?php
if (isset($_SESSION["access"]) && $_SESSION["access"] === true) {
	header("Location: /");
}
?>
<!DOCTYPE html>
<html>
<head>

<title>PTM | Inloggen</title>
<?php require("../include/header.php"); ?>

</head>
<body>
<?php require("../include/navigation.php"); ?>
<?php require("../include/sql/connect.php"); ?>
<?php
if (isset($_POST["name"]) && isset($_POST["pass"])) {
	$name = $_POST["name"];
	$pass = $_POST["pass"];

	require("../include/sql/account.php");

	$users->logon($name, $pass);
}
?>

<?php require("../include/htmlheader.php"); ?>

<!-- Login form -->
<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
			<h2 class="text-center">Inloggen</h2>
			<form action="" method="POST" id="logon">
				<div class="form-group text-center">
					<label for="username">Gebruikersnaam</label>
					<input type="text" class="form-control text-center" name="name" id="username" minlength="2" maxlength="25" required>
					<label for="password">Wachtwoord</label>
					<input type="password" class="form-control text-center" name="pass" id="password" required>
					<button type="submit" class="btn btn-login" form="logon">Inloggen</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php require("../include/footer.php"); ?>
</body>
</html>