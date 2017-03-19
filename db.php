<?php
class db
{
	//Defineer variabel voor connectie
	protected $conn;
	
	function __construct($servername, $username, $password, $db)
	{
		$this->servername 	= $servername;
		$this->username 	= $username;
		$this->password 	= $password;
		$this->db 			= $db;
		//Maakt connectie
		$this->conn 		= new mysqli($servername, $username, $password, $db);
	}
	
	public function filter($name)
	{
		$name = strip_tags($name);
		$name = preg_replace('/\W/', '', $name);
		return $name;
	}
	
	public function retreive()
	{
		$select = "SELECT * FROM countcustomer WHERE id = 1;";
		if ($result = $this->conn->query($select))
		{
			?>
			<div class="container">
				<div class="row text-center">
					<?php
					while($row = $result->fetch_assoc())
					{
						?>
						<div class="col-sm-4">
							Names used with 3 - 5 characters<br>
							<?php echo $row['3_5']; ?>
						</div>
						<div class="col-sm-4">
							Names used with 6 - 10 characters<br>
							<?php echo $row['6_10']; ?>
						</div>
						<div class="col-sm-4">
							Names used with >10 characters<br>
							<?php echo $row['biggerThen10']; ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
	}
	
	public function update($amount)
	{
		if ($amount >= 3 && $amount <= 5)
		{
			$update = "UPDATE countcustomer SET 3_5 = 3_5 + 1 WHERE id = 1;";
			$this->conn->query($update);
		}
		elseif ($amount >= 6 && $amount <= 10)
		{
			$update = "UPDATE countcustomer SET 6_10 = 6_10 + 1 WHERE id = 1;";
			$this->conn->query($update);
		}
		else
		{
			$update = "UPDATE countcustomer SET biggerThen10 = biggerThen10 + 1 WHERE id = 1;";
			$this->conn->query($update);
		}
	}
}