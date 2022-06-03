<?php 

Class Auth 
{

  public static function logged_in(){
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
				redirect_ADMIN();
			}
		}else{
			if($redirect){
        redirect("login");
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
    redirect();
	}


	public static function is_admin(){
		if(!empty($_SESSION['user_role'])){
			if($_SESSION['user_role'] == 'admin'){
				return true;
			}
			return false;
		}
	}
	
}