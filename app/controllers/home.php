<?php

Class Home extends Controller
{

	protected $pages;

	public function index($url)
	{

		$this->pages = array(
			'about',
			'contact'
		);

		if($url == 'home' || in_array($url,$this->pages)){
			$data['page'] = $url;
		}

		if($url == LOGIN){
			$data['page'] = 'login';
		}


		return $this->view('index', !isset($data)?:$data);
	}
}