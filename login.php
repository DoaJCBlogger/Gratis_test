<?php
	$loginStatusHTML = "";
	if (isset($_POST['username']) AND !empty($_POST['username']) AND isset($_POST['password']) AND !empty($_POST['password'])) {
		//Username and password
		$conn = new mysqli("localhost", "website", "5ED66BCC2A66AD7B339B29F8BD1BC9B2", "mysql");
		if ($conn->connect_error) {
			die("Database error");
		}
		
		$stmt = $conn->prepare("SELECT * FROM users WHERE username=? ORDER BY passwordSalt DESC LIMIT 1");
		$username = $_POST['username'];
		$password = $_POST['password'];
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			
			if (hash('sha3-256', ($password . $row["passwordSalt"])) == $row["passwordHash"]) {
				session_start();
				$_SESSION["userID"] = $row["UserID"];
				$_SESSION["username"] = $row["username"];
				header('Location: dashboard.php');
			} else {
				$loginStatusHTML = "<span style=\"color: red\">Wrong password</span>";
			}
		} else {
			$loginStatusHTML = "<span style=\"color: red\">User \"" . $username. "\" doesn't exist.</span>";
		}
		
		$stmt->close();
		$conn->close();
	} elseif (isset($_POST['username']) AND !empty($_POST['username']) AND (!isset($_POST['password']) OR empty($_POST['password']))) {
		//Username but no password
		$loginStatusHTML = "<span style=\"color: red\">Blank passwords aren't allowed.</span>";
	} elseif ((!isset($_POST['username']) OR empty($_POST['username'])) AND (isset($_POST['password']) AND !empty($_POST['password']))) {
		//Password but no username
		$loginStatusHTML = "<span style=\"color: red\">The username can't be empty.</span>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Log in</title>
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
					<li class="nav-item" style="padding-right: 25px"><input type="search" name="searchTerm" placeholder="Search term" style="display: inline;"></li>
					<li class="nav-item"><button type="submit" style="display: inline; margin-right: 50px">Search</button></li>
					<li class="nav-item"><a href="login.php">Log In</a></li>
				</ul>
			</form>
		</nav>
		<br><br><br><br><form method="post">
		<div class="container text-center">
			<div class="row">
				<div class="col">Username: <input type="text" name="username" value="<?php if (isset($_POST['username'])) { echo $_POST['username']; } ?>"></div>
			</div>
			<div class="row">
				<div class="col">Password: <input type="password" name="password"></div>
			</div>
			<div class="row">
				<div class="col"><button type="submit">Log in</button></div>
			</div><div class="row">
				<div class="col"><?php echo $loginStatusHTML; ?></div>
			</div>
		</div>
		</form>
	</body>
</html>