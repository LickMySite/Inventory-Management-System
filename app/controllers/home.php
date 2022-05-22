<?php

Class Home extends Controller
{

	protected $pages;

	public function index($url)
	{

		$this->pages = array(
			CONTROLLER,
			'about',
			'contact'
		);

		$key = array_search($url,$this->pages);
		if(is_int($key)){
			$data['page'] = $this->pages[$key];
		}

		return $this->view('index', !isset($data)?:$data);
	}
}