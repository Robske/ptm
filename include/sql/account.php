<?php
class users {
	function __construct($conn) {
		$this->conn = $conn;
	}

	/* Inloggen */
	function logon($username, $pass) {
		$username = strip_tags($username);
		$username = preg_replace('/\W/', '', $username);
		$pass = strip_tags($pass);
		$pass = preg_replace('/\W/', '', $pass);

		$getUser = "SELECT * FROM users WHERE username = '$username' AND inactive = 0";
		$result = $this->conn->query($getUser);
		$user = mysqli_fetch_assoc($result);

		if (isset($user)) {
			$username = $user["username"];
			$hash = $user["password"];
			$loginFails = $user["login_fails"];
			$now = date('Y-m-d H:i:s');
			$blockedUntil = $user["blocked_until"];

			if ($loginFails % 3 == 0 && $blockedUntil > $now) {
			// Account blocked
			?>
			<div class="fixed container">
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="alert alert-danger text-center">
						<strong>Account geblokkeerd</strong> Je kunt weer inloggen om <b><?php echo $blockedUntil; ?></b>.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
				</div>
			</div>
			<?php
			} else {
				// Account not blocked
				if (password_verify($pass, $hash)) {
					if ($loginFails != NULL) {
						$update = "UPDATE users SET blocked_until = NULL, login_fails = NULL WHERE username = '$username'";
						$this->conn->query($update);
					}

					$_SESSION["username"] = $username;
					$_SESSION["access"] = true;
					header("Location: /");
				} else {
					$loginFails++;
					if ($loginFails >= 3) {
						$now = strtotime($now);
						$now = $now + (5*60);
						$blockedUntil = date("Y-m-d H:i:s", $now);
						$update = "UPDATE users SET blocked_until = '$blockedUntil' WHERE username = '$username'";
						$this->conn->query($update);
					}
					$update = "UPDATE users SET login_fails = $loginFails WHERE username = '$username'";
					$this->conn->query($update);
					?>
					<div class="fixed container">
						<div class="col-xs-12 col-md-6 col-md-offset-3">
							<div class="alert alert-danger text-center">
								<strong>Inloggen mislukt</strong>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							</div>
						</div>
					</div>
					<?php
				}
			}
		} else {
			?>
			<div class="fixed container">
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="alert alert-danger text-center">
						<strong>Naam is niet bekend</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
				</div>
			</div>
			<?php
		}
		$now = new DateTime('now');
		$now = date_format($now, 'Y-m-d H:i:s');
	}
	/* End Inloggen */

	/* Registreren */
	function register($firstname, $lastname, $username, $pass) {
		$firstname = strip_tags($firstname);
		$firstname = preg_replace('/\W/', '', $firstname);
		$lastname = strip_tags($lastname);
		$lastname = preg_replace('/\W/', '', $lastname);
		$username = strip_tags($username);
		$username = preg_replace('/\W/', '', $username);
		$pass = strip_tags($pass);
		$pass = preg_replace('/\W\s/', '', $pass);

		//Als naam kleiner is zonder quotes en tekens is melding

		/* Check of naam bestaat */
		$checkName = "SELECT * FROM users WHERE username = '$username';";
		$result = $this->conn->query($checkName);
		if (mysql_num_rows($result) == 1) {
			?>
			<div class="fixed container">
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="alert alert-warning text-center">
						<strong>Naam is in gebruik</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
				</div>
			</div>
			<?php
		} else {

		}
	}
	/* End Registreren */
}

$users = new users($connect->conn);