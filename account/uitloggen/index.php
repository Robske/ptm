<?php
session_start();
if (isset($_SESSION["access"]) && isset($_SESSION["username"])) {
	unset($_SESSION["access"]);
	unset($_SESSION["username"]);
	?>
	<script>
		window.location = "/";
	</script>
	<?php
} else {
	?>
	<script>
		window.location = "/";
	</script>
	<?php
}