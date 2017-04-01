<?php 
session_start(); 
if (!isset($_SESSION["access"]) || $_SESSION["access"] !== true) {
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

<title>PTM | Profiel</title>
<?php require("../../include/header.html"); ?>
<link rel="stylesheet" type="text/css" href="/public/css/profile/profile.css">

</head>
<body>
<?php require("../../include/navigation.php"); ?>

<?php require("../../include/htmlheader.html"); ?>
<?php require("../../include/sql/connect.php"); ?>

<?php 
require("../../include/sql/profile.php");
$accountProfile = $profile->getProfile($_SESSION["id"]);
if ($accountProfile["location"] === NULL || $accountProfile["birth"] == NULL) {
	?>
	<div class="container">
		<div class="col-xs-12">
			<div class="text-center error">
				Profielgegevens niet compleet, <a href="/account/profiel/bewerken" class="underline">klik hier</a> om je profiel compleet te maken
			</div>
		</div>
	</div>
	<?php
}

$pic = $accountProfile["pic"];
if ($pic == NULL) {
	$pic = "/public/images/profilepic.jpg";
}
$name = $_SESSION["name"];
$birth = $accountProfile["birth"];
$location = $accountProfile["location"];
$bio = $accountProfile["bio"];
?>
<!-- Profiel gegevens -->
<div class="container profile">
	<div class="row">
		<div class="col-xs-6 col-sm-4 col-md-3">
			<a href="/account/profiel/bewerken" class="text text-left edit block"><span class="glyphicon glyphicon-pencil"></span> Profiel bewerken</a>
		</div>
		<div class="col-xs-6 col-sm-8 col-md-9">
			<label class="text text-right lightblue block"><?php echo $_SESSION["username"]; ?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<img class="img-responsive center-block pic" src="<?php echo $pic; ?>" alt="Profiel foto" />
		</div>
		<div class="col-xs-12 col-sm-8">
			<label for="name" class="text margin-top-0">Naam</label>
			<input type="text" class="form-control text-center" id="name" value="<?php echo $name; ?>" readonly>

			<label for="birthdate" class="text">Geboortedatum</label>
			<input type="text" class="form-control text-center" id="birthdate" value="<?php echo $birth; ?>" readonly>

			<label for="location" class="text">Locatie</label>
			<input type="text" class="form-control text-center" id="location" value="<?php echo $location; ?>" readonly>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<label for="bio" class="text">Bio</label>
			<textarea class="form-control text-center" id="bio" readonly><?php echo $bio; ?></textarea>
		</div>
	</div>
</div>
<?php require("../../include/footer.php"); ?>
</body>
</html>