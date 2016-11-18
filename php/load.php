<?php
# The below code is responsible for including the login and database classes of the task, starting the session, storing an empty string in the loginMessage variable and creating a new object of the Login class
# These are present on the pages (login.php & index.php) by using include_once
include_once 'classes/class.login.php';
include_once 'classes/class.database.php';
session_start();
$loginMessage = '';
$login = new Login();
?>
