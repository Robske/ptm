<?php
session_start();
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
// Call register function if values are set
if (isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["pass"])) {
	$name = $_POST["name"];
	$username = $_POST["username"];
	$pass = $_POST["pass"];

	require("../include/sql/account.php");
	$users->register($name, $username, $pass);
	if ($register === true) {
		?>
		<script>
			setTimeout(function() {
				window.location = "/inloggen";
			}, 5000);
		</script>
		<?php
	}
} elseif (isset($_POST["name"]) || isset($_POST["username"]) || isset($_POST["pass"])) {
	$failedToRegister = true;
	?>
	<div class="fixed container">
		<div class="col-xs-12 col-md-6 col-md-offset-3">
			<div class="alert alert-danger text-center">
				<strong>Vul alle gegevens correct in</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
		</div>
	</div>
	<?php
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
					<label for="name">Naam<span>*</span></label>
					<input type="text" class="form-control text-center" name="name" id="name" placeholder="Voornaam" minlength="2"
					 <?php if (isset($name)) { echo "value='" . $name . "'"; } ?> required>
					 <?php if (isset($failedToRegister) && $failedToRegister === true) { echo "<div class='darkred'>Minimaal 2 tekens</div>"; } ?>
					<label for="username">Gebruikersnaam<span>*</span></label>
					<input type="text" class="form-control text-center" name="username" id="username" placeholder="Gebruikersnaam" minlength="6" maxlength="25" 
					<?php if (isset($username)) { echo "value='" . $username . "'"; } ?> required>
					<?php if (isset($failedToRegister) && $failedToRegister === true) { echo "<div class='darkred'>Minimaal 6 tekens, spaties niet toegestaan</div>"; } ?>
					<label for="password">Wachtwoord<span>*</span></label>
					<input type="password" class="form-control text-center" name="pass" id="password" placeholder="Wachtwoord" minlength="9" required>
					<?php if (isset($failedToRegister) && $failedToRegister === true) { echo "<div class='darkred'>Minimaal 9 tekens, spaties niet toegestaan</div>"; } ?>
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