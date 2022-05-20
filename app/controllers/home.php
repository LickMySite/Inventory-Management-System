<?php

Class Home extends Controller
{
	public function index($url)
	{
		if($url === 'home'){
			$data['page'] = 'home';

			return $this->view('home', $data);
		}	
		return $this->view('404');
	}
}