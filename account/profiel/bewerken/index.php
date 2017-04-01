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
<?php require("../../../include/header.html"); ?>
<link rel="stylesheet" type="text/css" href="/public/css/profile/profile.css">

</head>
<body>
<?php require("../../../include/navigation.php"); ?>

<?php require("../../../include/htmlheader.html"); ?>
<?php require("../../../include/sql/connect.php"); ?>

<?php 
require("../../../include/sql/profile.php");

if (isset($_POST["name"]) && isset($_POST["birth"]) && isset($_POST["bio"])) {
	$accountProfile = $profile->getProfile($_SESSION["id"]);
	$name = $_POST["name"];
	
	if (isset($_POST["new-pic"])) {
		$pic = $_POST["new-pic"];
	} else {
		$pic = $accountProfile["pic"];
	}

	if (isset($_POST["location"]) && isset($_POST["latitude"]) && isset($_POST["longitude"])) {
		$location = $_POST["location"];
		$latitude = $_POST["latitude"];
		$longitude = $_POST["longitude"];
	} else {
		$location = $accountProfile["location"];
		$latitude = $accountProfile["latitude"];
		$longitude = $accountProfile["longitude"];
	}

	if ($_POST["bio"] != $accountProfile["bio"]) {
		$bio = $_POST["bio"];
	} else {
		$bio = $accountProfile["bio"];
	}

	if (isset($_POST["birth"]) && $_POST["birth"] != $accountProfile["birth"]) {
		$birth = $_POST["birth"];
	} else {
		$birth = $accountProfile["birth"];
	}

	$profile->editProfile($_SESSION["id"], $name, $pic, $location, $birth, $bio, $latitude, $longitude);
	$accountProfile = $profile->getProfile($_SESSION["id"]);
} else {
	$accountProfile = $profile->getProfile($_SESSION["id"]);
}

// Set profile values to display
$name = $_SESSION["name"];

if ($accountProfile["pic"] == NULL) {
	$pic = "/public/images/profilepic.jpg";
} else {
	$pic = $accountProfile["pic"];
}

$birth = $accountProfile["birth"];
$location = $accountProfile["location"];
$bio = $accountProfile["bio"];
?>

<!-- Show profile -->
<div class="container profile">
	<div class="row">
		<div class="col-xs-6 col-sm-4 col-md-3">
			<a href="/account/profiel" class="edit pull-left"><span class="glyphicon glyphicon-eye-open"></span> Profiel bekijken</a>
		</div>
		<div class="col-xs-6 col-sm-8 col-md-9">
			<label class="text-right lightblue block"><?php echo $_SESSION["username"]; ?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<label for="current-pic" class="text">Huidige profielfoto</label>
			<img class="img-responsive center-block pic" id="current-pic" src="<?php echo $pic; ?>" alt="Profiel foto" />
		</div>
		<div class="col-xs-12 col-sm-6">
			<label for="new-pic-input" class="text">Nieuwe profielfoto</label>
		    <img class="img-responsive center-block pic hide" id="new-pic-output" src="#" alt="Nieuwe profielfoto" />
		    <input type='file' class="text-center center-block" id="new-pic-input" onchange="previewFile()">
		</div>
	</div>
	<form action="" method="POST" id="editProfile">
	<div class="row">
		<div class="col-xs-12">
			<label for="name">Naam<span>*</span></label>
			<input type="text" class="form-control text-center" name="name" id="name" value="<?php echo $name; ?>" required>
			<?php if (isset($failedToEditProfile) && $failedToEditProfile === true) { echo "<div class='darkred'>Minimaal 2 tekens</div>"; } ?>

			<label for="locationSelect">Kies uw woonplaats<span>*</span></label>
			<input type="text" class="form-control text-center" id="locationSelect" placeholder="Selecteer uw woonplaats" value="<?php echo $location; ?>" required>
			<?php if (isset($failedToEditProfile) && $failedToEditProfile === true) { echo "<div class='darkred'>Kies een geldige woonplaats</div>"; } ?>

			<label for="birth">Geboortedatum<span>*</span></label>
			<input type="date" class="form-control text-center" name="birth" id="birth" value="<?php echo $birth; ?>" required>
			<?php if (isset($failedToEditProfile) && $failedToEditProfile === true) { echo "<div class='darkred'>Voer een geldige geboortedatum in</div>"; } ?>

			<label for="bio">Bio</label>
			<textarea class="form-control text-center" name="bio" id="bio" maxlength="250" rows="5"><?php echo $bio; ?></textarea>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="col-xs-12">
			<button type="submit" form="editProfile" class="btn text pull-left lightblue"><span class="glyphicon glyphicon-floppy-saved"></span> Opslaan</button>
			<a href="/account/verwijderen" class="remove pull-right"><span class="glyphicon glyphicon-remove"></span> Verwijder account</a>
		</div>
	</div>
</div>
<?php require("../../../include/footer.php"); ?>
<?php require("../../../include/account/profile/placesAutocomplete.html"); ?>
<script type="text/javascript">
// Aditional onSubmit function to finish the location / image
$('#editProfile').submit(function (e) {
	if (typeof open['location'] !== "undefined" && typeof open['latitude'] !== "undefined" && typeof open['longitude'] !== "undefined") {
		$('#editProfile').append('<input type="hidden" name="location" id="location" value="' + open['location'] + '">');
		$('#editProfile').append('<input type="hidden" name="latitude" id="latitude" value="' + open['latitude'] + '">');
		$('#editProfile').append('<input type="hidden" name="longitude" id="longitude" value="' + open['longitude'] + '">');
	}
	
	if (typeof open['newImgSrc'] !== "undefined") {
		$('#editProfile').append('<input type="hidden" name="new-pic" id="new-pic" value="' + open['newImgSrc'] + '">');
	}
});
</script>
</body>
</html>