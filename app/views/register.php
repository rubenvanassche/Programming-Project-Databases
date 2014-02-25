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
  $userName = $firstName = $lastName = $email = $country = $password = "";  
  $userNameErr = $firstNameErr = $lastNameErr = $emailErr = $countryErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $con=mysqli_connect("localhost","CoachCenter","xSN2asvRPVU3Lrsa","Users");

  // Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }


  //Validate

  if (empty($_POST["userName"]))
    {$userNameErr = "Username is required";}
  else {
    $userName = test_input($_POST["userName"]);
    //username restrictions
    $sql="SELECT * FROM user WHERE username = '$userName'";
    $result = mysqli_query($con,$sql);
    if($result->num_rows != 0) {
      $userNameErr = "Username already in use";
    }
  }
  if (empty($_POST["firstName"]))
    {$firstNameErr = "First ame is required";}
  else
    {$firstName = test_input($_POST["firstName"]);}
  if (empty($_POST["lastName"]))
    {$lastNameErr = "Last name is required";}
  else
    {$lastName = test_input($_POST["lastName"]);}
  if (empty($_POST["email"]))
    {$emailErr = "Email address is required";}
  else
    {$email = test_input($_POST["email"]);
    $sql="SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($con,$sql);
    if($result->num_rows != 0) {
      $emailErr = "Email address already in use";
    }
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
    $emailErr = "Invalid email format";
    }

  }
  $country = test_input($_POST["country"]);
  if (empty($_POST["password"]))
    {$passwordErr = "Password is required";}
  else
    {$password = Hash::make(test_input($_POST["password"]));}



  $registrationCode = str_random(24);

  //Circumvents need for registration code, undo once email server has been setup!
  $registrationCode = "";

  if(empty($userNameErr) && empty($firstNameErr) && empty($lastNameErr) && 
  empty($emailErr) && empty($countryErr) && empty($passwordErr)) {
    $sql="INSERT INTO user (username, firstname, lastname, email, password, country, registrationcode)
    VALUES
    ('$userName', '$firstName','$lastName','$email', '$password', '$country', '$registrationCode')";

    if (!mysqli_query($con,$sql)) {
      echo "fail";
    }
    else {
      //$url = URL::to('registrationAccepted');
      //header('Location: registrationAccepted');
      echo "Registration accepted!";
      exit();
    }
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


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
User Name:  <input type="text" name="userName" value="<?php echo $userName ?>">
<span class="error">* <?php echo $userNameErr;?></span><br>
First Name: <input type="text" name="firstName" value="<?php echo $firstName ?>">
<span class="error">* <?php echo $firstNameErr;?></span><br>
Last Name: <input type="text" name="lastName" value="<?php echo $lastName ?>">
<span class="error">* <?php echo $lastNameErr;?></span><br>
E-mail: <input type="text" name="email" value="<?php echo $email ?>">
<span class="error">* <?php echo $emailErr;?></span><br>
Country: <input type="text" name="country" value="<?php echo $country ?>">
<span class="error"> <?php echo $countryErr;?></span><br>
Password: <input type="password" name="password">
<span class="error">* <?php echo $passwordErr;?></span><br>
<input type="submit">
</form>

</body>
</html>
