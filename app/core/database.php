<?php 

Class Database
{

	public static $con;

	public function __construct()
	{
		$DB_TYPE = "mysql";
		$DB_HOST = "localhost";
		$DB_NAME = "inv_db";
		$DB_USER = "root";
		$DB_PASS = "";

		 try{
			
			$string = $DB_TYPE . ":host=". $DB_HOST .";dbname=". $DB_NAME;
			self::$con = new PDO($string,$DB_USER,$DB_PASS);
			self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		}catch (PDOException $e){
			echo "Connection failed: ";
			die($e->getMessage());
		}
	}

	public static function getInstance()
	{
		if(self::$con){

			//return self::$con;
		}

		return $instance = new self();
 	}

 	public static function newInstance()
	{
		return $instance = new self();
 	}


	// read from database

	public function read(string $query,array $data = array())
	{
		$stm = self::$con->prepare($query);
		$result = $stm->execute($data);
		
		if($result){

			$data = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($data) && count($data) > 0)
			{
				
				return $data;
			}
		}
		return false;
	}

	// write to database
	public function write(string $query,array $data = array())
	{

		$stm = self::$con->prepare($query);
		$result = $stm->execute($data);

		if($result){
			return true;
 		}
		return false;
	}
}