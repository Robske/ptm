<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>

<title>PTM | Profiel</title>
<?php require("../include/header.php"); ?>

</head>
<body>
<?php require("../include/navigation.php"); ?>

<?php require("../include/htmlheader.php"); ?>
<!-- Profiel gegevens ophalen -->
<?php

$avatar = "../favicon.ico";
$username = "Test gebruiker";
$birthdate = 1996-11-11;
$location = "Test locatie";
$bio = "Test bio";
?>

<!-- Profiel gegevens showen -->
<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
			<div class="col-md-6">
				<img class="col-md-6 profile-avatar" src="<?php echo $avatar; ?>" alt="<?php echo $username; ?>" />
			</div>
			<div class="col-md-6">
				<label for="username">Naam</label>
				<input type="text" class="form-control text-center" name="username" id="username" minlength="2" maxlength="25" value="<?php echo $username; ?>" readonly="true">
				<label for="username">Geboortedatum</label>
				<input type="date" class="form-control text-center" name="birthdate" id="birthdate" minlength="2" maxlength="25" value="<?php echo $birthdate; ?>" readonly="true">
				<label for="username">Locatie</label>
				<input type="text" class="form-control text-center" name="location" id="location" minlength="2" maxlength="25" value="<?php echo $location; ?>" readonly="true">
			</div>
		</div>
		<div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
			<label for="username">Bio</label>
			<textarea class="form-control text-center" name="bio" id="bio" minlength="2" maxlength="25" readonly="true"><?php echo $bio; ?></textarea>
		</div>>
	</div>
</div>
<?php require("../include/footer.php"); ?>
</body>
</html>