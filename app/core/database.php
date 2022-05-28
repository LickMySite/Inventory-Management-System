<?php 

Class Database
{

	public static $con;

	// public function __construct(){
	// 	$DB_TYPE = "mysql";
	// 	$DB_HOST = "localhost";
	// 	$DB_NAME = "inv_db";
	// 	$DB_USER = "root";
	// 	$DB_PASS = "";

	// 	 try{
	// 			$string = $DB_TYPE . ":host=". $DB_HOST .";dbname=". $DB_NAME;
	// 			self::$con = new PDO($string,$DB_USER,$DB_PASS);
	// 			self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
	// 		}catch (PDOException $e){
	// 			echo "Connection failed: ";
	// 			die($e->getMessage());
	// 		}
	// }

	private function connection(){
		$DB_TYPE = "mysql";
		$DB_HOST = "localhost";
		$DB_NAME = "inv_db";
		$DB_USER = "root";
		$DB_PASS = "";

		 try{
			
			$string = $DB_TYPE . ":host=". $DB_HOST .";dbname=". $DB_NAME;
			$con = new PDO($string,$DB_USER,$DB_PASS);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		}catch (PDOException $e){
			echo "Connection failed: ";
			die($e->getMessage());
		}
		return $con;
	}

 	public static function newInstance(){
		return $instance = new self();
 	}


	// read from database

	public function read(string $query,array $data = array(),$type = 'object'){

		$con = $this->connection();

		if($con){
			$stm = $con->prepare($query);
			if($stm){
				$test = $stm->execute($data);
			
				if($test){
					if($type == 'object'){
						$method = PDO::FETCH_OBJ;
					}else{
						$method = PDO::FETCH_ASSOC;
					}
	
					$data = $stm->fetchAll($method);
					if(is_array($data) && count($data) > 0){
						return $data;
					}
				}
	
			}
		}
		
		return false;
	}

	// write to database
	public function write(string $query,array $data = array()){

		$con = $this->connection();
		$stm = $con->prepare($query);

		if($stm){
			$result = $stm->execute($data);

			if($result){
				return true;
			}
		}
		return false;
	}

	public function create_tables(){
		//users table
		$query = "

			CREATE TABLE IF NOT EXISTS `users` (
			 `id` int(11) NOT NULL AUTO_INCREMENT,
			 `email` varchar(100) NOT NULL,
			 `firstname` varchar(30) NOT NULL,
			 `lastname` varchar(30) NOT NULL,
			 `password` varchar(255) NOT NULL,
			 `role` varchar(20) NOT NULL,
			 `date` date DEFAULT NULL,
			 PRIMARY KEY (`id`),
			 KEY `email` (`email`),
			 KEY `firstname` (`email`),
			 KEY `lastname` (`email`),
			 KEY `date` (`date`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

		";

		$this->query($query);
	}
}