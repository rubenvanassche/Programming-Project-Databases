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
$userName = $password = $userNameErr = $passwordErr = $validatedErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $con=mysqli_connect("localhost","CoachCenter","xSN2asvRPVU3Lrsa","Users");

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  if (empty($_POST["userName"]))
    {$userNameErr = "Userame is required";}
  else {
    $userName = test_input($_POST["userName"]);
  }
  if (empty($_POST["password"])) {

    $passwordErr = "Password is required";
  }
  else {
    $password = test_input($_POST["password"]);
  }

  $sql="SELECT password, registrationcode FROM user WHERE username = '$userName' ";
  $result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($result);

  if (!$row) {
    $userNameErr = "This username does not exist!";
  }
  else if ($passwordErr == "" && !Hash::check($password, $row['password'])) {
    $passwordErr = "Username and password do not match!";
  }
  else if ($row["registrationcode"]) {
    $validatedErr = "Email address not yet validated!";
    //add resend option
  }
  if (empty($userNameErr) && empty($passwordErr) && empty($validatedErr)) {
    echo "Login successful" ;
    $sessionID = str_random(24);
    $sql="UPDATE user SET session_id = '$sessionID' WHERE username = '$userName' ";
    mysqli_query($con,$sql);
    setcookie("user", $userName, time() + 7200); 
    setcookie("userSession", Hash::make($sessionID), time() + 7200); 
    exit();
  }
	

  mysqli_close($con);
}
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
User Name:  <input type="text" name="userName" value="<?php echo $userName ?>">
<span class="error">* <?php echo $userNameErr;?></span><br>
Password: <input type="password" name="password" value="<?php echo $password ?>">
<span class="error">* <?php echo $passwordErr;?></span><br>
<span class="error"><?php echo $validatedErr;?></span>
<input type="submit">
</form>



</body>
</html>
