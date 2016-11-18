<?php
class Database {
	private $config = array();
	private $connected = false;
	private $link = NULL;
	private $statement = '';
	private $result = NULL;
	private $message = '';
	public function __construct($config = array()) {
		$this->config['host'] = '';
		$this->config['user'] = '';
		$this->config['pass'] = '';
		$this->config['data'] = '';
		$this->config['port'] = ini_get('mysqli.default_port');
		$this->config['sock'] = ini_get('mysqli.default_socket');
		if (is_array($config)) {
			foreach ($config as $item => $value) {
				if (array_key_exists($item, $this->config)) {
					$this->config[$item] = $value;
				}
			}
		}
		$this->connect();
	}
	public function connect() {
		if (!$this->connected) {
			$this->link = new mysqli($this->config['host'],$this->config['user'],$this->config['pass'],$this->config['data'],$this->config['port'],$this->config['sock']);
			if (mysqli_connect_error()) {
				throw new Exception('Mysqli connection error: ' . $this->link->connect_error, $this->link->connect_errno);
			} else {
				$this->connected = true;
			}
		}
	}
	# The prepare function is firstly storing in the params variable the optional values received as an array by the function using array_map. The applied callback is containing an array of the $this->link which is a mysqli created object that connects to the database together with the function real_escape_string of the same object to prevent Sql injections 
	# After that it will add the query before the parameters using array_unshift
	# Doing so by calling call_user_func_array inside the query variable which is later stored as $this->statement, the received Sql operation it has the ‘%s’ strings replaced with the parameters that has been already through the real_escape_string function
	public function prepare($query, $params = array()) {
		$params = array_map(array($this->link,'real_escape_string'), $params);
		array_unshift($params, $query);
		$query = call_user_func_array('sprintf', $params);
		$this->statement = $query;
	}
	# Furthermore when the execute method in the class is called is checking if the statement is empty or not
	public function execute() {
		if (empty($this->statement)) {
			return false;
		}
		# If the query if found is then executed to the database using the mysqli object mentioned above
		# To ensure that no more than one statement is fired the variable is then initialized as an empty string
		# Next step is to get the result using the fetch_records function
		$this->result = $this->link->query($this->statement);
		$this->statement = '';
		return $this->fetch_records();
	}

	public function fetch_records() {
		#  If the result stored previously in a variable with the same name by the execute method of the class is empty then a 'No rows found' message is returned 
		if (!$this->result) {
			$this->message = 'No rows found';
			return false;
		}
		# Otherwise if $this->result is received as an object the rows will be fetched and returned as an array for further processing in other PHP files
		if (is_object($this->result)) {
			$r = array();
			while ($res = $this->result->fetch_object()) {
				$r[] = $res;
			}
			return $r;
		} elseif ($this->result) {
			return true;
		} else {
			return false;
		}
	}
}
?>
