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

//Define all field entries and error messages as empty before filling them in
$userName = $password = $userNameErr = $passwordErr = $validatedErr = "";

//Form sends input to same script for processing, only execute following then
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $con=mysqli_connect("localhost","CoachCenter","xSN2asvRPVU3Lrsa","Users");

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  //Security?
  $userName = test_input($_POST["userName"]);
  $password = test_input($_POST["password"]);

  //Validate
  $validator = Validator::make(
      array('username' => $userName,
            'password' => $password
  ),
      array('username' => array('required'),
            'password' => array('required')
  )
  );

  //Set error messages
  if ($validator->fails()) {
    $messages = $validator->messages();
    $userNameErr = $messages->first('username');
    $passwordErr = $messages->first('password');
  }
  //No need to check any further if validator found errors
  else {

    $sql="SELECT password, registrationcode FROM user WHERE username = '$userName' ";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);

    if (!$row) {
      $userNameErr = "This username does not exist!";
    }
    else if (!Hash::check($password, $row['password'])) {
      $passwordErr = "Username and password do not match!";
    }
    else if ($row["registrationcode"]) {
      $validatedErr = "Email address not yet validated!";
      //add resend option
    }
    else {
      echo "Login successful" ;
      $sessionID = str_random(24);
      $sql="UPDATE user SET session_id = '$sessionID' WHERE username = '$userName' ";
      mysqli_query($con,$sql);
      //Set cookies to remember login (sessionID to prevent forged cookies, secure?)
      //Cookie expires after 2 hours, find a way to prevent users from getting logged out
      //while still actively browsing site. Propagate login some other way too?
      setcookie("user", $userName, time() + 7200); 
      setcookie("userSession", Hash::make($sessionID), time() + 7200); 
      exit();
    }
  }	

  mysqli_close($con);
}

//Put this somewhere else? (if needed after improving security)
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
