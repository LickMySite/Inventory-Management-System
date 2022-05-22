<?php
Class Admin extends Controller{

	protected $pages;

	public function index($url)
	{

		$this->pages = array(
			CONTROLLER
		);

		$key = array_search($url,$this->pages);
		if(is_int($key)){
			$data['page'] = $this->pages[$key];
		}
		
		return $this->view('admin/index', !isset($data)?:$data);
	}
}