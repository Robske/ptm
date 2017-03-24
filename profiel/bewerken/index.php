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
<?php require("../include/header.php"); ?>
<link rel="stylesheet" type="text/css" href="/public/css/profile.css">

</head>
<body>
<?php require("../include/navigation.php"); ?>

<?php require("../include/htmlheader.php"); ?>
<?php require("../include/sql/connect.php"); ?>

<?php 
if (isset($_SESSION["id"])) {

	require("../include/sql/account.php");
	$profile = $account->getProfile($_SESSION["id"]);
	if ($profile["livesIn"] == "" || $profile["bio"] == "" || $profile["birth"] == "") {
			?>
			<div class="container">
				<div class="col-xs-12">
					<div class="text-center error">
						Profielgegevens niet compleet, <a href="/profiel/bewerken" class="underline">klik hier</a> om je profiel compleet te maken
					</div>
				</div>
			</div>
			<?php
		}
	
	$pic = $profile["pic"];
	if ($pic == NULL) {
		$pic = "/public/images/profilepic.jpg";
	}
	$name = $_SESSION["name"];
	$birth = $profile["birth"];
	$location = $profile["livesIn"];
	$bio = $profile["bio"];
} else {
	?>
	<script>
		window.location = "/";
	</script>
	<?php
}
?>
<!-- Profiel gegevens showen -->
<div class="container profile">
	<div class="row">
		<div class="col-xs-6 col-sm-4 col-md-3">
			<a href="/profiel/bewerken" class="edit text-left block"><span class="glyphicon glyphicon-pencil"></span> Profiel bewerken</a>
		</div>
		<div class="col-xs-6 col-sm-8 col-md-9">
			<label class="text-right lightblue block"><?php echo $_SESSION["username"]; ?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-4">
			<img class="img-responsive center-block pic" src="<?php echo $pic; ?>" alt="Profiel foto" />
		</div>
		<div class="col-xs-6 col-sm-8">
			<label for="name" class="margin-top-0">Naam</label>
			<input type="text" class="form-control text-center" id="name" value="<?php echo $name; ?>" readonly>
			<label for="birth">Geboortedatum</label>
			<input type="text" class="form-control text-center" id="birth" value="<?php echo $birth; ?>" readonly>
			<label for="location">Locatie</label>
			<input type="text" class="form-control text-center" id="location" value="<?php echo $location; ?>" readonly>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<label for="bio">Bio</label>
			<textarea class="form-control text-center" id="bio" readonly><?php echo $bio; ?></textarea>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<a href="/" class="remove text-left block"><span class="glyphicon glyphicon-pencil"></span> Verwijder account</a>
		</div>
	</div>
</div>
<?php require("../include/footer.php"); ?>
</body>
</html>