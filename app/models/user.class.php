<?php 

Class User 
{
	private $error = "";
	private $id = null;
	private $blocked = false;
	

	public function edit($data){
		$arr['id'] = $data['user_id'];
		$arr['name'] = $data['name'];
		$query = "UPDATE users set name = :name where id = :id limit 1";
		$DB = Database::newInstance();
		$DB->write($query,$arr);
		$DB = null;
		$_SESSION['msg'] = "Name Edited!";

	}

	public function signup($POST){

		$POST['username'] = 'testpiolet';
		$POST['company'] = 1;
		$POST['user_role'] = 3;

		//Check for empty inputs
		foreach($POST as $key => $value){
			if(empty($value)) {
				$this->error .= "Value $key is required <br>";
			}
		}
		//Validate inputs
		if($this->error == ""){
			if(!preg_match("/^[a-zA-Z- ]+$/", $POST['name'])){
				$this->error .= "Please enter a valid name <br>";
			}

			if(!preg_match("/^[a-zA-Z0-9-]+$/", $POST['username'])){
				$this->error .= "Please enter a valid username <br>";
			}

			if(filter_var($POST['company'], FILTER_VALIDATE_INT) === false){
				$this->error .= "Select Company <br>";
			}

			if(filter_var($POST['user_role'], FILTER_VALIDATE_INT) === false){
				$this->error .= "Select user role <br>";
			}

			$this->validate_email($POST['email']);
			$this->validate_pwd($POST['password']);
		}
		//check if email already exists
		if($this->error == ""){

			$arr = array();
			$arr['email'] 	= $this->clean($POST['email']);
			$query = 
			"SELECT email from users where email = :email limit 1";
			$DB = Database::getInstance();
			$check = $DB->read($query,$arr);

			if(is_array($check)){
				$this->error .= "That email is already in use <br>";
			}else{
			$data['email'] = $arr['email'];
			}
		}

		//check if username already exists
		if($this->error == ""){
			$arr = array();
			$arr['username'] 	= $this->clean($POST['username']);

			$query = "SELECT username from users where username = :username limit 1";
			$check = $DB->read($query,$arr);

			if(is_array($check)){
				$this->error .= "That username is already in use <br>";
			}else{
			$data['username'] = $arr['username'];
			}


		}

		//check for url_address
		if($this->error == ""){
			$arr = array();

			$arr['url_address'] = $this->get_random_string_max(60);

			$query = "SELECT url_address from users where url_address = :url_address limit 1";
			$check = $DB->read($query,$arr);
			if(is_array($check)){
				$arr['url_address'] = $this->get_random_string_max(60);
			}
			$data['url_address'] = $arr['url_address'];
		}
		//Set variables -> Sanitize data -> Write to DB
		if($this->error == ""){
			$data['name'] = $this->clean($POST["name"]);
			$data['user_role'] = $this->clean($POST['user_role']);
			$data['company'] = $this->clean($POST['company']);
			$data['avatar'] = "abc";
			$data['password'] = hash('sha1',$POST['password']);
			$data['date'] = date("Y-m-d H:i:s");

	
			$query = "INSERT into users (url_address,name,email,password,date,username,avatar,user_role,client_id) values (:url_address,:name,:email,:password,:date,:username,:avatar,:user_role,:company)";

			$result = $DB->write($query,$data);

			if($result){
				unset($_POST);
				$_SESSION['msg'] = "User Created";
				//return false;
				header("Location: " . ROOT . "login");
				die;
			}else{
				$this->error .= "Something went wrong";
			}
		}
	
		$_SESSION['error'] = $this->error;
	}


	//start login and checks
	public function login(){

		$POST = array();
		$POST['email'] = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
		$POST['password'] = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
		$POST['csrf_token'] = clean_input($_POST['csrf_token']);


		if(
			isset($POST['email'])
			&& isset($POST['password'])
			&& isset($POST['csrf_token'])
			&& validateToken($POST['csrf_token'])
			&& $this->attempts_ip()
			&& $this->validate_pwd($POST['password'])
			&& $this->validate_email($POST['email'])
			&& $this->check_email($POST['email'])
			&& $this->attempts_email($POST['email'])

		){

				$result = $this->validate_db($POST['email'], $POST['password']);

				if(!empty($result)){
					my_session_regenerate_id();
					$_SESSION['user_url'] = $result;
					$this->user_data($result);
					header("Location: " . ADMIN);
				}

		}

		if(!$this->blocked){
			$DB = Database::getInstance();

			$arr = array();
			$arr['user'] = $this->id;
			$arr['ip'] = $_SERVER['REMOTE_ADDR'];
			$arr['timestamp'] = time();

			$query = "INSERT INTO loginattempts (user, ip, timestamp) VALUES (:user,:ip,:timestamp)";
			$DB->write($query,$arr);

			$this->error .= "Wrong email or password <br>";
		}

		$_SESSION['error'] = $this->error;
	}
	
	private function attempts_ip(){

		if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {

			$arr['ip'] = $_SERVER['REMOTE_ADDR'];
			$arr['hourAgo'] = time() - 60*60;

			$query = 
			"SELECT COUNT(id) AS attempt
				from loginattempts
				where ip = :ip AND timestamp> :hourAgo
			";

			$DB = Database::getInstance();
			$result = $DB->read($query,$arr);

				if($result[0]->attempt > MAX_LOGIN_ATTEMPTS_PER_HOUR) {
					$this->error .= "You have been locked out for 1 hour!<br>".$result[0]->attempt;
					$this->blocked = true;
					return false;

				}
				return true;
		}
	}

	private function validate_pwd(string $data){
		if(empty($data))
		{
			$this->error .= "Please enter a password <br>";
			return $this->error;
		}

		// Validate password strength
		$uppercase = preg_match('@[A-Z]@', $data);
		$lowercase = preg_match('@[a-z]@', $data);
		$number    = preg_match('@[0-9]@', $data);
		$special = preg_match('@[^\w]@', $data);
		$space = preg_match('@[ ]@', $data);

		if(!$uppercase || !$lowercase || !$number || !$special || $space || strlen($data) < 8 || strlen($data) > 50) {
			return false;
		}
		return true;
		
	}

	private function validate_email(string $email){
		if(empty($email)){
			$this->error .= "Please enter an email <br>";
			return $this->error;
		}else

		$test = filter_var($email,FILTER_SANITIZE_EMAIL);

		if($email !== $test || !preg_match("/^[a-zA-Z0-9-.@]+$/", count_chars($email,3)) || !preg_match("/^[a-zA-Z0-9-]+@[a-zA-Z]+.[a-zA-Z]+$/", $email) || strlen($email) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
			return false;
		}
		return true;
	}

	private function check_email(string $email){

		$data['email'] = filter_var($email,FILTER_SANITIZE_EMAIL);
		
		//check if email exists
		$query = 
		"SELECT COUNT(email) AS e
			from users
			where email = :email 
		";

		$DB = Database::getInstance();
		$result = $DB->read($query,$data);

		if(is_array($result) && $result[0]->e == 1){
			return true;
		}
		return false;
	}

	private function attempts_email(string $email){

		$arr['email'] = $email;
		$arr['hourAgo'] = time() - 60*60;

		$query = 
			"SELECT users.id,COUNT(loginattempts.id) AS attempt
			from users
			LEFT JOIN loginattempts ON users.id = user AND timestamp> :hourAgo
			where email = :email 
			GROUP BY users.id
			limit 1
			";


		$DB = Database::getInstance();
		$result = $DB->read($query,$arr);

			if($result[0]->attempt > MAX_LOGIN_ATTEMPTS_PER_HOUR) {
				$this->error .= "You have been locked out for 1 hour!<br>".$result[0]->attempt;
				$this->blocked = true;
				return false;
			}
		return true;
	}

	private function validate_db(string $email, string $password){
		$data['email'] = filter_var($email,FILTER_SANITIZE_EMAIL);
		
		//check if user exists
		$DB = Database::getInstance();
		$query = 
		"SELECT users.id,url_address,password
			from users
			where email = :email 
			limit 1
		";
		$result = $DB->read($query,$data);

		if(is_array($result)){

			if(hash('sha1',$password) === $result[0]->password) {

				$arr = array();
				$arr['user'] = $result[0]->id;
				$arr['ip'] = $_SERVER['REMOTE_ADDR'];
				$query = "DELETE FROM loginattempts WHERE user=:user;DELETE FROM loginattempts WHERE ip=:ip";
				$DB->write($query,$arr);

				$result = $result[0]->url_address;
				return $result;
				
			}
			$this->id = $result[0]->id;
		}
		
		return false;
	}

	private function user_data($user_url){

		if(isset($user_url)){
			$arr = array();
			$arr['url'] = $user_url;
			$query = 
			"SELECT users.name,users.email,users.user_role,users.avatar,users.client_id,client.client_name,client.fullname 
			from users 
			inner join client on users.client_id=client.id 
			where users.url_address = :url limit 1";

			$DB = Database::getInstance();
			$result = $DB->read($query,$arr);
			
			if(is_array($result)){

				$_SESSION['name'] = $result[0]->name;
				$_SESSION['email'] = $result[0]->email;
				$_SESSION['user_role'] = $result[0]->user_role;
				$_SESSION['avatar'] = $result[0]->avatar;
				$_SESSION['client_id'] = $result[0]->client_id;
				$_SESSION['client_name'] = $result[0]->client_name;
				$_SESSION['fullname'] = $result[0]->fullname;

				return true;
			}
			return false;
		}

	}
	
	//end login and checks



	public function get_user($url){

		$db = Database::newInstance();
		$arr = null;

		$arr['url'] = addslashes($url);
		$query = "SELECT * from users where url_address = :url limit 1";

		$result = $db->read($query,$arr);
		
		if(is_array($result))
		{
			return $result[0];
		}

		return false;
	}

	public function get_users(){

		$db = Database::newInstance();
		$query = "SELECT * from users";

		$result = $db->read($query);
		
		if(is_array($result))
		{
			return $result;
		}

		return false;
	}

	private function get_random_string_max($length) {

		$array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$text = "";

		$length = rand(4,$length);

		for($i=0;$i<$length;$i++) {

			$random = rand(0,61);
			
			$text .= $array[$random];

		}

		return $text;
	}

	public function check_login($redirect = false, $allowed = null){

		if(isset($_SESSION['user_url']) && isset($_SESSION['user_role'])){
			$user_role = $_SESSION['user_role'];
			$access['admin'] = ['admin'];
			$access[3] = ['admin',3];
			$access[2] = ['admin',3,2];
			$access[1] = ['admin',3,2,1];

			if(!in_array($user_role, $access[$allowed])){
				header("Location: " . ADMIN);
				die;
			}
		}else{

			if($redirect){
				header("Location: " . ROOT . "login");
				die;
			}
		}

		return false;
	}

	public function logout(){

		if(isset($_SESSION['user_url']))
		{
			unset($_SESSION['user_url']);
			unset($_SESSION['error']);
			session_destroy();
		}

		header("Location: " . ROOT . "home");
		die;
	}


	public function get_all_table(){

    $DB = Database::newInstance();
		$query = "SELECT * from users";
		$datas = $DB->read($query);

		if(is_array($datas))
		{

			$result = null; 
			foreach($datas as $user){
				if(isset($user->client_id)){

					$arr['id'] = $user->client_id;
					$query = "SELECT client_name from client where id = :id limit 1";
					$client = $DB->read($query,$arr);

					$result .=
					'<tr data-item-id="'.$user->id.'">
						<td><a href="'.ADMIN.'users/profile/'.$user->name.'">'.$user->name.'</a></td>
						<td><a href="'.ADMIN.'inventory/'.$client[0]->client_name.'"><strong>'.$client[0]->client_name.'</strong></a></td>
						<td>'.$user->user_role.'</td>
						<td>'.$user->username.'</td>
						<td>'.$user->email.'</td>
						<td>'.$user->date.'</td>
					</tr>';
				}
			}

			return $result;
		}

		return false;
	}

	public function get_user_list(){

    $DB = Database::newInstance();


		$query =
		"SELECT users.id,users.name,email,users.user_role,users.client_id,client.client_name 
		FROM users
		LEFT JOIN client on users.client_id=client.id
		";

		$datas = $DB->read($query);
		if(is_array($datas)){

			return $datas;
		}
	}

	public function get_client_users(int $ID){

		$arr['id'] = $ID;

		$db = Database::newInstance();
		$query = 
		"SELECT id,name,username,email,user_role 
		FROM users
		WHERE client_id = :id
		";

		$result = $db->read($query,$arr);
		
		if(is_array($result))
		{
			return $result;
		}

		return false;
	}

	public function get_info(){
		$db = Database::getInstance();

		
		$arr['url'] = isset($_SESSION['user_url']) ? $_SESSION['user_url'] : '' ;
		$query = "select * from users where url_address = :url limit 1";
		$result = $db->read($query,$arr);
			
		if(is_array($result))
		{
			$result = $result[0];

				return $result;

		}
	}

	private function clean($data) {
		$data = trim($data);
		$data = addslashes($data);
		$data = htmlentities($data, ENT_QUOTES, 'UTF-8');
		return $data;
	}
	
}