<?php

Class Home extends Controller
{
	public function index($url)
	{
		if($url === 'home'){
			$data['page'] = 'home';

			return $this->view('index', $data);
		}	
		return $this->view('page/404');
	}
}