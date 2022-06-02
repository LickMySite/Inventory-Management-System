<?php 

Class Login extends Controller
{

	public function index()
	{

		if(isset($_SESSION['user_url']) && $_SESSION['user_url'] != ""){
			header("Location: " . ADMIN);
			die;
		}


		if($_SERVER['REQUEST_METHOD'] == "POST"){


			$this->load_model("User")->login();

			if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
				$data['errors'] = $_SESSION['error'];
			}
		}
		$data['page'] = 'login';

		$this->view('page/login',$data);
		show($_SESSION);
	}

}