<?php 

Class Signup extends Controller
{

	public function index()
	{

		if(isset($_SESSION['user_url']) && $_SESSION['user_url'] != ""){
			header("Location: " . ADMIN);
			die;
		}


		if($_SERVER['REQUEST_METHOD'] == "POST"){

			$user = new User();

			$user->signup($_POST);

			if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
				$data['errors'] = $_SESSION['error'];
			}
		}

		$data['page'] = 'signup';

		$this->view('page/signup',$data);

	}

}