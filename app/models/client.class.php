<?php 

Class Client
{
	public function create($DATA){

		$arr['company'] 	= strtolower($DATA['company']);
		$arr['fullname'] 	= strtolower($DATA['companyfull']);

		if(empty($arr['company'])){
			$_SESSION['error'] = "Please enter a company name";
		}

		if(!preg_match("/^[a-zA-Z ]+$/", trim($arr['company']))){
			$_SESSION['error'] = "Please enter a valid company name";
		}

		if(!isset($_SESSION['error']) || $_SESSION['error'] == ""){
			$query = "INSERT into client (client_name,fullname) values (:company,:fullname)";
			$DB = Database::newInstance(); 
			$check = $DB->write($query,$arr);
			$DB = null;

			if($check){
				$_SESSION['client'] = $arr['company'];
				return true;
			}
		}

		return false;

	}

	public function get_all(){
		$query = "SELECT * FROM client ORDER BY client_name";
    $DB = Database::newInstance();
		$result = $DB->read($query);
		$DB = null;
		if(is_array($result))
		{
			return $result;
		}

		return false;
	}

	public function get_one_by_id($id){

		$arr['id'] = $id;

		$DB = Database::newInstance();
		$query = "select * from client where id = :id limit 1";
		$result = $DB->read($query,$arr);

		if(is_array($result))
		{
			return $result[0];
		}

		return false;
	}

	public function get_client_users($id){

		$arr['id'] = $id;

		$DB = Database::newInstance();
		$query = "select * from users where client_id = :id";
		$result = $DB->read($query,$arr);

		if(is_array($result))
		{
			return $result;
		}

		return false;
	}

	public function get_one_by_name($name){

		$arr['name'] = $name;

		$DB = Database::newInstance();
		$query = "SELECT * from client where client_name = :name limit 1";
		$result = $DB->read($query,$arr);

		if($result){
			return $result[0];
		}

		return false;
	}

	public function edit($DATA){
		$DB = Database::newInstance();
		$arr['id'] = $DATA['id'];
		$arr['client_name'] = $DATA['companyName'];
		$arr['fullname'] = $DATA['companyFullName'];

		$query = "UPDATE client set client_name = :client_name,fullname = :fullname where id = :id limit 1";
		$DB->write($query,$arr);
	}

	public static function company_name_list(){
		$query = "SELECT id,client_name from client";
    $DB = Database::newInstance();
		$check = $DB->read($query);
		$DB = null;
		if(is_array($check)){

			$result = array();
			foreach ($check as $object)
			{
				$result[$object->id] = $object->client_name;
			}

			return $result;
		}

		return false;
	}

	public function get_id($name){

		$arr['name'] = $name;

		$DB = Database::newInstance();
		$query = "select id from client where client_name = :name limit 1";
		$result = $DB->read($query,$arr);
		$DB = null;
		if($result){
			return $result[0]->id;
		}

		return false;
	}

	public function get_user_company(int $id){
		$db = Database::newInstance();

		$arr['id'] = addslashes($id);
		$query = "select * from client where id = :id limit 1";

		$result = $db->read($query,$arr);
		
		if(is_array($result)){
			return $result[0];
		}

		return false;
	}

	public function exists($name){

		$arr['name'] = $name;

		$DB = Database::newInstance();
		$query = "select client_name from client";
		$result = $DB->read($query);
		$DB = null;
		if(in_array($name,$result,true)){
			return true;
		}
		return false;
	}
}