<?php
include_once 'php/load.php';
# The script checks if a variable with the name 'loggeding' has been set in a GET request and if as well it is equal to 0 then it calls the logout function on the login class object
if (isset($_GET['loggedin']) && $_GET['loggedin'] == '0') {
	$login->logout();
	# Otherwise it checks if the session parameter named 'loggedout' is set and also true to replace the empty string of the loginMessage variable present in the load.php file with a 'You are now logged out' text before unsetting the session parameter against which it was made the check
	} else {
	if (isset($_SESSION['loggedout']) && $_SESSION['loggedout'] == true) {
		$loginMessage = 'You are now logged out';
		unset($_SESSION['loggedout']);
	}
}
# Another scenario could be the one when the login button is pressed which fires up the POST request, setting the submit parameter 
if (isset($_POST['submit'])) {
	# If the condition is met the loginUser function is called on the login class object sending as parameters the two input field: username and password
	$loginMessage = $login->loginUser($_POST['username'],$_POST['password']);
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Task | Login</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="outer">
			<div class="middle">
				<div id="formContainer">
					<div class="row">
						<div class="col-xs-12">
							<span>Welcome</span>
						</div>
					</div>
					<form id="loginForm" action="login.php" method="POST"><!-- The login form is sending a POST request to itself (login.php) in order to authenticate the credentials inputs by the user -->
						<div class="row">
							<div class="col-xs-12">
								<input name="username" type="text" placeholder="Username">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<input name="password" type="password" placeholder="Password">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<input id="loginBtn" name="submit" type="submit" value="Login">
							</div>
						</div>
					</form>
					<div id="loginResponse" class="row">
						<div class="col-xs-12">
							<p><?php echo $loginMessage; ?></p><!-- Here is shown a message when the user logout or inputs wrong credentials -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/tether.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
</html>
