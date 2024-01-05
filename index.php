<?php
	session_start();
	
	$searchTerm = "";
	if (isset($_GET['searchTerm'])) {
		$searchTerm = $_GET['searchTerm'];
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
			<h1>Dealership</h1>
		</div>
		<nav class="navbar navbar-expand-sm justify-content-center">
			<form action="/" method="get">
				<ul class="navbar-nav justify-content-center">
					<li class="nav-item" style="padding-right: 25px"><input type="search" name="searchTerm" placeholder="Search term" style="display: inline;" value="<?php echo $searchTerm; ?>"></li>
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
		<div class="container">
			<div class="row">
				<?php
					$conn = new mysqli("localhost", "website", "5ED66BCC2A66AD7B339B29F8BD1BC9B2", "mysql");
					if ($conn->connect_error) {
						die("Database error");
					}
					
					$sql = "SELECT * FROM cars WHERE ShouldDisplay=1";
					if (!empty($searchTerm)) {
						$sql .= " AND INSTR(Title, ?) > 0";
					}
					$stmt = $conn->prepare($sql);
					if (!empty($searchTerm)) {
						$stmt->bind_param("s", $searchTerm);
					}
					$stmt->execute();
					$result = $stmt->get_result();
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<div class=\"col border\" style=\"max-width: 220px; margin: 25px\"><a href=\"car.php?id=" . ltrim($row["VehicleID"], "0"). "\" style=\"color: black; text-decoration: none\"><img src=\"images\\" . ltrim($row["VehicleID"], "0"). ".jpg\" style=\"width: 200px\">";
							echo "<br><h3>$" . $row["Price"]. "</h3><span style=\"font-size: 0.7em\">" . $row["Make"]. "</span>";
							echo "<br>" . $row["Title"];
							echo "<br><div style=\"margin: 0px; padding: 0px; display: inline; font-size: 0.7em\">";
							echo "Condition: " . $row["VehicleCondition"];
							echo "<br>Stock #: " . $row["StockNumber"];
							echo "<br>Miles: " . $row["Miles"];
							echo "</div></a></div>";
						}
					} else {
						echo "No results";
					}
					
					$conn->close();
				?>
			</div>
		</div>
	</body>
</html>