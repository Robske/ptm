<?php
class users {
	function __construct($conn) {
		$this->conn = $conn;
	}
		/* Registreren */
	function register($name, $username, $pass) {
		$usernameSpaces = substr_count($username, " ");
		$passSpaces = substr_count($pass, " ");

		if (strlen($name) < 2 || 
			$usernameSpaces >= 1 || strlen($username) < 6 ||
			$passSpaces >= 1 || strlen($pass) < 9) {
			?>
			<div class="fixed container">
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="alert alert-danger text-center">
						<strong>Vul alle gegevens correct in!</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
				</div>
			</div>
			<?php
			global $failedToRegister;
			return $failedToRegister = true;
		}

		/* Check of naam bestaat */
		$checkName = $this->conn->prepare("SELECT username FROM users WHERE username = ? AND inactive = 0");
		$checkName->bind_param("s", $username);
		$checkName->execute();
		$checkName->bind_result($user);
		$checkName->fetch();
		$checkName->close();

		if (isset($user)) {
			?>
			<div class="fixed container">
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="alert alert-danger text-center">
						<strong>Gebruikersnaam <?php echo $username; ?> is in gebruik</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
				</div>
			</div>
			<?php
		} else {
			$password = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 10]);
			$createUser = $this->conn->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");
			$createUser->bind_param("sss", $name, $username, $password);

			if ($createUser->execute()) {
				?>
				<div class="fixed container">
					<div class="col-xs-12 col-md-6 col-md-offset-3">
						<div class="alert alert-success text-center">
							<strong>Account aangemaakt</strong> Je kunt nu inloggen
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						</div>
					</div>
				</div>
				<?php
				global $register;
				return $register = true;
			} else {
				?>
				<div class="fixed container">
					<div class="col-xs-12 col-md-6 col-md-offset-3">
						<div class="alert alert-danger text-center">
							<strong>Registreren mislukt</strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						</div>
					</div>
				</div>
				<?php
			}
			
			$createUser->close();
		}
	}
	/* End Registreren */

	/* Inloggen */
	function logon($username, $pass) {
		$getUser = $this->conn->prepare("SELECT id, name, username, password, blocked_until, login_fails FROM users WHERE username = ? AND inactive = 0;");
		$getUser->bind_param("s", $username);
		$getUser->execute();
		$getUser->bind_result($id, $name, $username, $hash, $blockedUntil, $loginFails);
		$getUser->fetch();
		$getUser->close();

		if (isset($id)) {
			$now = date("Y-m-d H:i:s");
			if ($loginFails != NULL && $loginFails % 3 == 0 && $blockedUntil > $now) {
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
						$updateFails = $this->conn->prepare("UPDATE users SET blocked_until = NULL, login_fails = NULL WHERE username = ?");
						$updateFails->bind_param("s", $username);
						$updateFails->execute();
						$updateFails->close();
					}

					// Set access and userinfo
					$_SESSION["id"] = $id;
					$_SESSION["name"] = htmlspecialchars($name);
					$_SESSION["username"] = htmlspecialchars($username);
					$_SESSION["access"] = true;

					?>
					<script>
						window.location = "/";
					</script>
					<?php
				} else {
					$loginFails++;
					if ($loginFails >= 3) {
						$now = strtotime($now);
						$now = $now + (5*60);
						$blockedUntil = date('Y-m-d H:i:s', $now);
						$updateAccount = $this->conn->prepare("
							UPDATE users SET blocked_until = '$blockedUntil', login_fails = '$loginFails' WHERE username = ?
							");
						$updateAccount->bind_param("s", $username);
						$updateAccount->execute();
						$updateAccount->close();
					} else {
						$updateAccount = $this->conn->prepare("
							UPDATE users SET login_fails = $loginFails WHERE username = ?
							");
						$updateAccount->bind_param("s", $username);
						$updateAccount->execute();
						$updateAccount->close();
					}
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
	}
	/* End Inloggen */

	/* Ophalen profiel */
	function getProfile($id) {
		
		$getProfile = $this->conn->prepare("SELECT pic, lives_in, bio, birth FROM profile WHERE account_id = ?");
		$getProfile->bind_param("s", $id);
		$getProfile->execute();
		$getProfile->bind_result($pic, $livesIn, $bio, $birth);
		$getProfile->fetch();
		$getProfile->close();

		$profile = array("pic" => $pic, "livesIn" => $livesIn, "bio" => $bio, "birth" => $birth);

		if ($profile["livesIn"] == "" || $profile["bio"] == "" || $profile["birth"] == "") {
			?>
			<div class="container">
				<div class="col-xs-12">
					<div class="text-center error">
						Profielgegevens niet compleet, maak je profiel compleet voordat je verder gaat.
					</div>
				</div>
			</div>
			<?php
		}
		return $profile;
	}
	/* End ophalen profiel */
}

$users = new users($connect->conn);