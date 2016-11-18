<?php
include_once 'php/load.php';
$login->session_check();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Task | Index</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div id="loggedinOuter" class="outer">
			<div class="middle">
				<div id="logoutContainer">
					<div class="row">
						<div class="col-xs-12">
							<span><?php echo $_SESSION['firstname']; ?> <?php echo $_SESSION['lastname']; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<span><?php echo $_SESSION['email']; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<p>The above information are fetched from the database thanks to the login process</p>
						</div>
					</div>
					<form id="logoutForm" action="login.php" method="GET">
						<input name="loggedin" type="hidden" value="0">
						<div class="row">
							<div class="col-xs-12">
								<input name="submit" type="submit" value="Logout">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/tether.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
</html>
