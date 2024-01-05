<?php
	session_start();
	$carDetailsHTML = "";
	$title = "";
	if ((isset($_GET['id']) AND !empty($_GET['id'])) OR $_GET['id'] == '0') {
		$conn = new mysqli("localhost", "website", "5ED66BCC2A66AD7B339B29F8BD1BC9B2", "mysql");
		if ($conn->connect_error) {
			die("Database error");
		}
		
		$stmt = $conn->prepare("SELECT * FROM cars WHERE VehicleID=?");
		$id = $_GET['id'];
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			
			$title = $row["Title"];
			$carDetailsHTML = "<img src=\"images\\" . $id. ".jpg\" style=\"width: 40%\">";
			$carDetailsHTML .= "<br><h1>" . $title. "</h1>";
			$carDetailsHTML .= "Make: " . $row["Make"];
			$carDetailsHTML .= "<br>Model: " . $row["Model"];
			$carDetailsHTML .= "<br>Year: " . $row["ModelYear"];
			$carDetailsHTML .= "<br>Condition: " . $row["VehicleCondition"];
			$carDetailsHTML .= "<br>Color: " . $row["Color"];
			$carDetailsHTML .= "<br>Price: " . $row["Price"];
			$carDetailsHTML .= "<br>StockNumber: " . $row["StockNumber"];
			$carDetailsHTML .= "<br>Miles: " . $row["VIN"];
			$carDetailsHTML .= "<br>Engine: " . $row["Engine"];
			$carDetailsHTML .= "<br>Transmission: " . $row["Transmission"];
			$carDetailsHTML .= "<br>Location: " . $row["Location"];
			$carDetailsHTML .= "<br>Fuel Type: " . $row["FuelType"];
			$carDetailsHTML .= "<br>City/Highway MPG: " . $row["MPG"];
		} else {
			$carDetailsHTML = "<span style=\"color: red\">Car #" . $_GET["id"]. " doesn't exist.</span>";
		}
		
		$stmt->close();
		$conn->close();
	} else {
		die("Missing \"id\" parameter");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="jumbotron" style="margin-bottom: 0; padding-bottom: 50px; background-color: lightgray">
			<h1>Dealership</h1>
		</div>
		<nav class="navbar navbar-expand-sm justify-content-center">
			<form action="index.php" method="get">
				<ul class="navbar-nav justify-content-center">
					<li class="nav-item" style="padding-right: 25px"><input type="search" name="searchTerm" placeholder="Search term" style="display: inline;"></li>
					<li class="nav-item"><button type="submit" style="display: inline; margin-right: 50px">Search</button></li>
					<li class="nav-item">
						<?php
							if (isset($_SESSION['userID']) AND !empty($_SESSION['userID'])) {
								echo "Hello, " . $_SESSION['username']. " <a href=\"dashboard.php\">Dashboard</a>&nbsp;&nbsp;<a href=\"logout.php\">Log out</a>";
							} else {
								echo "<a href=\"login.php\">Log In</a>";
							}
						?>
					</li>
				</ul>
			</form>
		</nav>
		<br><br><br><br>
		<div class="container" style="margin-bottom: 200px">
			<div class="row">
				<?php echo $carDetailsHTML; ?>
			</div>
		</div>
	</body>
</html>