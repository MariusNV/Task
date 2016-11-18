<?php
class Login {
	private $data;
	public function loginUser($username, $password) {
		if (empty($username) && empty($password)) {
			return 'Both username and password fields are empty';
		} elseif (empty($username) && !empty($password)) {
			return 'The username field is empty';
		} elseif (!empty($username) && empty($password)) {
			return 'The password field is empty';
		} elseif (!empty($username) && !empty($password)) {
			$sql = 'SELECT username FROM login WHERE username = "%s" LIMIT 1'; # An SQL query is stored in the sql variable where its stated to select the username field from the database table 'login' where it the same as the ones entered by the user
			$db = new Database(); # Next is creating a new database class object to prepare and execute the query
			$db->prepare($sql,array($username));
			$this->data = $db->execute();
			# If the response is empty it means that the username is not matching the one entered hereupon a 'The username is not correct' string is returned to be displayed 
			if (empty($this->data)) {
				return 'The username is not correct';
			} else {
				$password = md5($password); #The password received is converted to md5. This adds an extra layer of security to the process
				$sql = 'SELECT username, password, first_name, last_name, email FROM login WHERE username = "%s" AND password = "%s" LIMIT 1'; # Another SQL query is stored in the sql variable replacing the previous one
				# A new database class object is not required being already created. This time the query includes the password aswell
				$db->prepare($sql,array($username,$password));
				$this->data = $db->execute();
				if (empty($this->data)) {
					return 'The password is not correct';
				} else {
					# In the good case scenario when the received data is not empty four session parameters are set, three to store some information from the database and the last one to set the permission to true so in the end the user could login and access the index page using PHP header
					$_SESSION['firstname'] = $this->data[0]->first_name;
					$_SESSION['lastname'] = $this->data[0]->last_name;
					$_SESSION['email'] = $this->data[0]->email;
					$_SESSION['permission'] = true;
					header('location: index.php');
				}
			}
		}
	}
	public function logout() {
		if (isset($_SESSION['username'])) {
			unset($_SESSION['username']);
		}
		if (isset($_SESSION['permission'])) {
			unset($_SESSION['permission']);
		}
		$_SESSION['loggedout'] = true;
		header('location: login.php');
	}
	public function session_check() {
		if ($_SESSION['permission'] == true) {
			return true;
		} else {
			header('location: login.php');
		}
	}
}
?>
