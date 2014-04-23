<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Coachcenter Account activationt</h2>

		<div>
			To activate your account, please click : {{ URL::to('user/activate', array($username, $registrationCode)) }}.
		</div>
	</body>
</html>