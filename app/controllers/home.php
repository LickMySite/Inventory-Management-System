<?php

Class Home extends Controller
{
	protected $page;
	protected $pages = array(
		CONTROLLER,
		'about',
		'contact'
	);


	private function load_page(){

		$data['page'] = $this->page;

		$this->view("layout/head",$data);
		$this->view("layout/navbar",$data);
		$this->view("index",$data);
		$this->view("layout/footer");
		$this->view("layout/script");

	}




	public function index($url){


		$key = array_search($url,$this->pages);

		$this->page = !is_int($key)?null:$this->pages[$key];

		return $this->load_page();
	}


}