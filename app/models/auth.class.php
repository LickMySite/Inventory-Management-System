<?php 

Class Auth 
{
	private $error = "";
	private $id = null;
	private $blocked = false;


  public static function logged_in()
	{
		if(!empty($_SESSION['user_url']) && isset($_SESSION['user_role'])){
			return true;
		}
		return false;
	}


	public static function check_login($redirect = false, $allowed = null){


		if(!empty($_SESSION['user_url']) && !empty($_SESSION['user_role'])){
			$access['admin'] = ['admin'];
			$access[3] = ['admin',3];
			$access[2] = ['admin',3,2];
			$access[1] = ['admin',3,2,1];

			if(!in_array($_SESSION['user_role'], $access[$allowed])){
				header("Location: " . ADMIN);
				die;
			}
		}else{
			if($redirect){
        redirect(ROOT. "login");
			}
		}

		return false;
	}


	public static function logout(){

		if(isset($_SESSION['user_url']) || isset($_SESSION['user_role']))
		{
			unset($_SESSION['user_url']);
			unset($_SESSION['user_role']);
			unset($_SESSION['error']);
			session_destroy();
      my_session_regenerate_id();
		}
    redirect(ROOT);
	}


	public static function is_admin()
	{
		if(!empty($_SESSION['USER_DATA']))
		{
			if($_SESSION['USER_DATA']->role == 'admin'){
				return true;
			}
		}

		return false;
	}
	
}