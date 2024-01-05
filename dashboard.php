<?php
	session_start();
	
	if ((isset($_SESSION['userID']) AND !empty($_SESSION['userID'])) AND (isset($_POST['VehicleID']) AND !empty($_POST['VehicleID']))) {
		$conn = new mysqli("localhost", "website", "5ED66BCC2A66AD7B339B29F8BD1BC9B2", "mysql");
		if ($conn->connect_error) {
			die("Database error");
		}
		
		$stmt = $conn->prepare("UPDATE cars SET Title=?, Make=?, Model=?, ModelYear=?, VehicleCondition=?, Color=?, Price=?, StockNumber=?, Miles=?, VIN=?, Engine=?, Transmission=?, Location=?, FuelType=?, ShouldDisplay=?, MPG=? WHERE VehicleID=?");
		$VehicleID = $_POST['VehicleID'];
		$Title = $_POST['Title'];
		$Make = $_POST['Make'];
		$Model = $_POST['Model'];
		$ModelYear = $_POST['ModelYear'];
		$VehicleCondition = $_POST['VehicleCondition'];
		$Color = $_POST['Color'];
		$Price = $_POST['Price'];
		$StockNumber = $_POST['StockNumber'];
		$Miles = $_POST['Miles'];
		$VIN = $_POST['VIN'];
		$Engine = $_POST['Engine'];
		$Transmission = $_POST['Transmission'];
		$Location = $_POST['Location'];
		$FuelType = $_POST['FuelType'];
		$ShouldDisplay = 0;
		if (isset($_POST['ShouldDisplay']) AND $_POST['ShouldDisplay'] == 1) {
			$ShouldDisplay = 1;
		}
		$MPG = $_POST['MPG'];
		$stmt->bind_param("sssssssssssssssss", $Title, $Make, $Model, $ModelYear, $VehicleCondition, $Color, $Price, $StockNumber, $Miles, $VIN, $Engine, $Transmission, $Location, $FuelType, $ShouldDisplay, $MPG, $VehicleID);
		$stmt->execute();
		if ($stmt === false) {
			die("Database error while updating car #" . $VehicleID);
		}
		
		$stmt->close();
		$conn->close();
	} elseif (!isset($_SESSION['userID']) OR empty($_SESSION['userID'])) {
		header('Location: login.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Dealership</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="jumbotron" style="margin-bottom: 0; padding-bottom: 50px; background-color: lightgray">
			<h1>Dealership dashboard</h1>
		</div>
		<nav class="navbar navbar-expand-sm justify-content-center">
			<form action="/" method="get">
				<ul class="navbar-nav justify-content-center">
					<li class="nav-item" style="padding-right: 25px"><input type="search" name="searchTerm" placeholder="Search term" style="display: inline;"></li>
					<li class="nav-item"><button type="submit" style="display: inline; margin-right: 50px">Search</button></li>
					<li class="nav-item">
						<?php
							if (isset($_SESSION['userID']) AND !empty($_SESSION['userID'])) {
								echo "Hello, " . $_SESSION['username']. " <a href=\"logout.php\">Log out</a>";
							} else {
								echo "<a href=\"login.php\">Log In</a>";
							}
						?>
					</li>
				</ul>
			</form>
		</nav>
		<br><br><br><br>
		<div class="container">
				<?php
					$conn = new mysqli("localhost", "website", "5ED66BCC2A66AD7B339B29F8BD1BC9B2", "mysql");
					if ($conn->connect_error) {
						die("Database error");
					}
					
					$result = $conn->query("SELECT * FROM cars");
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<div class=\"row border\" style=\"max-width: 500px; margin: 25px\"><img src=\"images\\" . ltrim($row["VehicleID"], "0"). ".jpg\" style=\"width: 200px\">";
							echo "<div style=\"margin: 0px; padding: 0px; display: inline;\">";
							echo "<form method=\"post\"><input type=\"hidden\" name=\"VehicleID\" value=\"" . $row["VehicleID"]. "\">";
							echo "Display name: <input type=\"text\" name=\"Title\" value=\"" . $row["Title"]. "\">";
							echo "<br>Price: <input type=\"number\" name=\"Price\" min=\"0\" step=\"0.01\" value=\"" . $row["Price"]. "\">";
							echo "<br>Make: <input type=\"text\" name=\"Make\" value=\"" . $row["Make"]. "\">";
							echo "<br>";
							echo "Condition: <input type=\"text\" name=\"VehicleCondition\" value=\"" . $row["VehicleCondition"]. "\">";
							echo "<br>Stock #: <input type=\"text\" name=\"StockNumber\" value=\"" . $row["StockNumber"]. "\">";
							echo "<br>Miles: <input type=\"number\" name=\"Miles\" min=\"0\" value=\"" . $row["Miles"]. "\">";
							echo "<br>Model: <input type=\"text\" name=\"Model\" value=\"" . $row["Model"]. "\">";
							echo "<br>Year: <input type=\"number\" name=\"ModelYear\" min=\"0\" value=\"" . $row["ModelYear"]. "\">";
							echo "<br>Color: <input type=\"text\" name=\"Color\" value=\"" . $row["Color"]. "\">";
							echo "<br>VIN: <input type=\"text\" name=\"VIN\" value=\"" . $row["VIN"]. "\">";
							echo "<br>Transmission: <input type=\"text\" name=\"Transmission\" value=\"" . $row["Transmission"]. "\">";
							echo "<br>Engine: <input type=\"text\" name=\"Engine\" value=\"" . $row["Engine"]. "\">";
							echo "<br>Location: <input type=\"text\" name=\"Location\" value=\"" . $row["Location"]. "\">";
							echo "<br>FuelType: <input type=\"text\" name=\"FuelType\" value=\"" . $row["FuelType"]. "\">";
							echo "<br>City/Highway MPG: <input type=\"text\" name=\"MPG\" value=\"" . $row["MPG"]. "\">";
							echo "<br><label for=\"shouldDisplayCar" . ltrim($row["VehicleID"], "0"). "\">Visible</label>&nbsp;&nbsp;<input type=\"checkbox\" id=\"shouldDisplayCar" . ltrim($row["VehicleID"], "0"). "\" name=\"ShouldDisplay\" value=\"1\"";
							if ($row["ShouldDisplay"] == 1) { echo " checked"; }
							echo "><br><button type=\"submit\">Update</button></form></div></div>";
						}
					} else {
						echo "No results";
					}
					
					$conn->close();
				?>
		</div>
	</body>
</html>