<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
	</style>
</head>
<body>


<?php

$con=mysqli_connect("localhost","CoachCenter","xSN2asvRPVU3Lrsa","Users");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_COOKIE["user"]) && isset($_COOKIE["userSession"])) {
  $user = $_COOKIE["user"];
  $sql = "SELECT session_id FROM user WHERE username = '$user'";
  $result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($result);
  if ($row && Hash::check($row["session_id"], $_COOKIE["userSession"])) {
    echo "logged in as $user";
  }
}
else {
  echo "not logged in";
}

?>


</body>
</html>
