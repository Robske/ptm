<?php
class profile {
	function __construct($conn) {
		$this->conn = $conn;
	}

	/* Ophalen profiel */
	function getProfile($id) {
		$getProfile = $this->conn->prepare("SELECT pic, location, longitude, latitude, bio, birth FROM profile WHERE account_id = ?");
		$getProfile->bind_param("i", $id);
		$getProfile->execute();
		$getProfile->bind_result($pic, $location, $longitude, $latitude, $bio, $birth);
		$getProfile->fetch();
		$getProfile->close();

		$profile = array("pic" => $pic, "location" => $location, "longitude" => $longitude, "latitude" => $latitude, "bio" => $bio, "birth" => $birth);

		if (!isset($accountId) || $accountId == "") {
			$createProfile = $this->conn->prepare("INSERT INTO profile (account_id) VALUES (?)");
			$createProfile->bind_param("i", $id);
			$createProfile->execute();
			$createProfile->close();
		}

		return $profile;
	}
	/* End ophalen profiel */

	/* Edit profile */
	function editProfile($id, $name, $pic, $location, $birth, $bio, $latitude, $longitude) {
		// Check aantal spaties in naam
		$nameSpaces = substr_count($name, " ");
		
		// Check datum
		$splitBirth = explode('-', $birth);
		$year = $splitBirth[0];
		$month = $splitBirth[1];
		$day = $splitBirth[2];
		$checkDate = checkdate($month, $day, $year);

		// Check leeftijd
		$birthDate = new DateTime($birth);
		$currentDate = new DateTime("now");
		$diff = $birthDate->diff($currentDate);
		$age = $diff->y;

		// Basic checks for valid data
		if (strlen($name) - $nameSpaces < 2 ||
			$checkDate === false ||
			strlen($location) < 2 ||
			$age < 3 || $age > 150 ||
			$location === NULL ||
			$latitude === NULL ||
			$longitude === NULL ||
			$birth === NULL) {
			?>
			<div class="fixed container">
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="alert alert-danger text-center">
						<strong>Vul alle gegevens correct in</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				</div>
			</div>
			<?php
			global $failedToEditProfile;
			return $failedToEditProfile = true;
		} else {
			// Check location
			$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $latitude . "," . $longitude . "&sensor=true";
			$data = @file_get_contents($url);
			$jsondata = json_decode($data, true);

			foreach ($jsondata["results"] as $result) {
				foreach ($result["address_components"] as $apiLocation) {
					if ($apiLocation["long_name"] == $location || $apiLocation["short_name"] == $location) {
						$locationValid = true;
						break;
					}
				}
				if (isset($locationValid) && $locationValid === true) {
					break;
				}
			}

			if (isset($locationValid) && $locationValid === true) {
				$updatePic = $this->conn->prepare("UPDATE profile SET pic = ?, location = ?, latitude = ?, longitude = ?, bio = ?, birth = ? WHERE account_id = ?");
				$updatePic->bind_param("ssssssi", $pic, $location, $latitude, $longitude, $bio, $birth, $id);
				$updatePic->execute();
				$updatePic->close();
				
				if ($name != $_SESSION["name"]) {
					$updateName = $this->conn->prepare("UPDATE users SET name = ? WHERE id = ?");
					$updateName->bind_param("si", $name, $id);
					$updateName->execute();
					$updateName->close();

					$_SESSION["name"] = $name;
				}
				?>
				<div class="fixed container">
					<div class="col-xs-12 col-md-6 col-md-offset-3">
						<div class="alert alert-success text-center">
							<strong>Profiel opgeslagen</strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
				</div>
				<?php
				return;
			} else {
				?>
				<div class="fixed container">
					<div class="col-xs-12 col-md-6 col-md-offset-3">
						<div class="alert alert-danger text-center">
							<strong>Locatie is niet geldig</strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
				</div>
				<?php
				global $failedToEditProfile;
				return $failedToEditProfile = true;
			}
		}
	}
	/* End edit profile */
}

$profile = new profile($connect->conn);