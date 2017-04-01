<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>

<title>People To Meet</title>
<?php require("include/header.html"); ?>

</head>
<body>
<?php require("include/navigation.php"); ?>

<?php require("include/htmlheader.html"); ?>

<?php 
if (isset($_SESSION["access"]) && $_SESSION["access"] === true) {
	require("include/features.html");
}
?>

<?php require("include/footer.php"); ?>
</body>
</html>