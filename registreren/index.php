<?php
if (isset($_SESSION["access"]) && $_SESSION["access"] === true) {
	?>
	<script>
		window.location = "/";
	</script>
	<?php
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
if (isset($_POST["firstname"]) && strlen($_POST["firstname"]) >= 2 &&
	isset($_POST["username"]) && strlen($_POST["username"]) >= 6 && 
	isset($_POST["pass"]) && strlen($_POST["pass"]) >= 9) {
	$firstname = $_POST["firstname"];
	if (isset($_POST["lastname"])) {
		$lastname = $_POST["lastname"];
	}
	$username = $_POST["username"];
	$pass = $_POST["pass"];

	require("../include/sql/account.php");

	$users->register($firstname, $lastname, $username, $pass);
}
?>

<?php require("../include/htmlheader.php"); ?>

<!-- Login form -->
<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
			<h2 class="text-center">Registreren</h2>
			<form action="#" method="POST" id="register">
				<div class="form-group text-center">
					<label for="firstname">Voornaam<span>*</span></label>
					<input type="text" class="form-control text-center" name="firstname" id="firstname" placeholder="Voornaam" minlength="2" required>
					<label for="lastname">Achernaam</label>
					<input type="text" class="form-control text-center" name="lastname" id="lastname" placeholder="Achternaam (Niet verplicht)">
					<label for="username">Gebruikersnaam<span>*</span></label>
					<input type="text" class="form-control text-center" name="name" id="username" placeholder="Gebruikersnaam" minlength="2" maxlength="25" required>
					<label for="password">Wachtwoord<span>*</span></label>
					<input type="password" class="form-control text-center" name="pass" id="password" placeholder="Wachtwoord" minlength="9" required>

					<div class="password-bar">
	                    <span class="pwstrength_viewport_progress"></span> <span class="pwstrength_viewport_verdict"></span>
	                </div>

					<button type="submit" class="btn btn-login" form="register">Registreren</button>
				</div>
			</form>

		</div>
	</div
</div>


<?php require("../include/footer.php"); ?>
<?php require("../include/user/password_check.php"); ?>
</body>
</html>