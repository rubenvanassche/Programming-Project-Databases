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
  $userName = $firstName = $lastName = $email = $email2 = $country = $password = $password2 = "";  
  $userNameErr = $firstNameErr = $lastNameErr = $emailErr = $email2Err = $countryErr = $passwordErr = $password2Err  = "";

//Form sends input to same script for processing, only execute following then
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $con=mysqli_connect("localhost","CoachCenter","xSN2asvRPVU3Lrsa","Users");

  // Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

  //Improve security against injections
  $userName = test_input($_POST["userName"]);
  $firstName = test_input($_POST["firstName"]);
  $lastName = test_input($_POST["lastName"]);
  $email = test_input($_POST["email"]);
  $email2 = test_input($_POST["email2"]);
  $country = test_input($_POST["country"]);
  $password = $_POST["password"];   //make secure without changing?
  $password2 = $_POST["password2"];

  //Validate
  $validator = Validator::make(
      array('username' => $userName,
            'first name' => $firstName,
            'last name' => $lastName,
            'email address' => $email,
            'retype email address' => $email2,
            'password' => $password,
            'retype password' => $password2,
  ),
      array('username' => array('required', 'min:5'),
            'first name' => array('required'),
            'last name' => array('required'),
            'email address' => array('required', 'email'),
            'retype email address' => array('same:email address'),
            'password' => array('required', 'min:6', 'alpha_dash'),
            'retype password' => array('same:password')
  )
  );



  if ($validator->fails()) {
    $messages = $validator->messages();
    $userNameErr =  $messages->first('username');
    $firstNameErr =  $messages->first('first name');
    $lastNameErr =  $messages->first('last name');
    $emailErr =  $messages->first('email address');
    $email2Err =  $messages->first('retype email address');
    $passwordErr =  $messages->first('password');
    $password2Err =  $messages->first('retype password');
  }


  //Unique username
  if ($userNameErr == "") {
    $sql="SELECT * FROM user WHERE username = '$userName'";
    $result = mysqli_query($con,$sql);
    if($result->num_rows != 0) {
      $userNameErr = "Username already in use";
    }
  }


  //Unique email
  if ($emailErr == "") {
    $sql="SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($con,$sql);
    if($result->num_rows != 0) {
      $emailErr = "Email address already in use";
    }
  }


  //If all input is valid
  if(!$validator->fails() && $userNameErr == "" && $emailErr == ""  ) {
    $registrationCode = str_random(24); 
    //Circumvents need for registration code, undo once email server has been setup!
    //Supposed to be set to empty once registration code has been entered
    $registrationCode = "";
    $hashedPassword = Hash::make($password);
    $sql="INSERT INTO user (username, firstname, lastname, email, password, country, registrationcode)
    VALUES
    ('$userName', '$firstName','$lastName','$email', '$hashedPassword', '$country', '$registrationCode')";

    if (!mysqli_query($con,$sql)) {
      echo "fail";
    }
    else {
      echo "Registration accepted!";
      exit();  //Makes sure form is no longer shown
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

<!-- Error messages not red? Also add "* means required" somewhere -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

User Name:  <input type="text" name="userName" value="<?php echo $userName ?>">
<span class="error">* <?php echo $userNameErr;?></span><br>

First Name: <input type="text" name="firstName" value="<?php echo $firstName ?>">
<span class="error">* <?php echo $firstNameErr;?></span><br>

Last Name: <input type="text" name="lastName" value="<?php echo $lastName ?>">
<span class="error">* <?php echo $lastNameErr;?></span><br>

Country: <input type="text" name="country" value="<?php echo $country ?>">
<span class="error"> <?php echo $countryErr;?></span><br><br>

Email address: <input type="text" name="email" value="<?php echo $email ?>">
<span class="error">* <?php echo $emailErr;?></span><br>

Retype e-mail: <input type="text" name="email2" value="<?php echo $email2 ?>">
<span class="error">* <?php echo $email2Err;?></span><br><br>

Password: <input type="password" name="password">
<span class="error">* <?php echo $passwordErr;?></span><br>

Retype password: <input type="password" name="password2">
<span class="error">* <?php echo $password2Err;?></span><br>

<input type="submit">
</form>

</body>
</html>

