<?php 

Class Admin extends Controller{

	protected $master = false;
	protected $default = false;
	protected $page = false;
	protected $action;
	protected $type;
	protected $style;
	protected $script;
	protected $example;
	protected $REC = null;
	protected $user_role;
	protected $client_ID = int;
	protected $url_client_ID = int;
	protected $url_client_NAME = null;

	//page assets
	private function load_user_data($role = null){
		$User = $this->load_model('User');
		$User->check_login(true, $role);
		$this->client_ID = $_SESSION['client_id'];
		$this->user_role = $_SESSION['user_role'];

		if($this->client_ID == "1" && $this->user_role == "admin"){
			$this->master = true;
		}

		return;
	}

	private function client_url_check($url){

		$company_list = $this->load_model('Client')->company_name_list();

		if(in_array($url,$company_list,true)){
			$this->type = "one";

			$this->url_client_NAME = $url;
			$this->url_client_ID = array_search($url,$company_list,true);
			return true;
		}
		return false;
	}

	private function get_data($data = []){
		if(is_array($data)){
			foreach($data as $key => $value){
				if(!empty($value)){
					$result[$key] = $value;
				}
			}
			return $result;
		}
		return false;
	}

	private function assets_table(){
		$this->style = array(

			array("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css", "sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="),
			array("https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css","sha512-3//o69LmXw00/DZikLz19AetZYntf4thXiGYJP6L49nziMIhp6DVrwhkaQ9ppMSy8NWXfocBwI3E8ixzHcpRzw=="),
			array("https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.11.5/dataTables.bootstrap5.min.css","sha512-160haaGB7fVnCfk/LJAEsACLe6gMQMNCM3Le1vF867rwJa2hcIOgx34Q1ah10RWeLVzpVFokcSmcint/lFUZlg=="),




			 "select2/css/select2",
			 "select2-bootstrap-theme/select2-bootstrap.min",
			// "datatables/media/css/dataTables.bootstrap5",
				#during add/create
				//"bootstrap-multiselect/css/bootstrap-multiselect.css",

			"pnotify/pnotify.custom",
			"bootstrap-tagsinput/bootstrap-tagsinput",
			"summernote/summernote-bs4",
			"dropzone/basic",
			"dropzone/dropzone"
		);
		$this->script = array(

			"select2/js/select2",
			"datatables/media/js/jquery.dataTables.min",
			"datatables/media/js/dataTables.bootstrap5.min",
			"datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min",
			"datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min",
			"datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min",
			"datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min",
			"datatables/extras/TableTools/JSZip-2.5.0/jszip.min",
			"datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min",
			"datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts",
				#during add/create
			"dropzone/dropzone",
			"bootstrap-tagsinput/bootstrap-tagsinput",
			"summernote/summernote-bs4",
			"jquery-validation/jquery.validate",
			"bootstrapv5-wizard/jquery.bootstrap.wizard",
			"pnotify/pnotify.custom",
			"jquery-maskedinput/jquery.maskedinput"
		);

		$this->example = array(
			"examples.datatables.default",
			"examples.datatables.row.with.details",
			"datatables.tabletools",
			"examples.modals",
				#during add/create
			"examples.wizard",
			"examples.advanced.form"

		);
	}

	private function load_page($data = []){


		$arr = array(
			"page" => $this->page,
			"action" => $this->action,
			"master" => $this->master,
			"style" => $this->style,
			"script" => $this->script,
			"example" => $this->example
		);

		$data['page'] = $this->page;
		$data['type'] = $this->type;
		$data['master'] = $this->master;
		$data['url_client_NAME'] = $this->url_client_NAME;

		$this->view("admin/layout/head",$arr);
		$this->view("admin/layout/header");
		$this->view("admin/layout/sidebar",$data);
		$this->view("admin/index",$data);
		$this->view("admin/layout/script");

	}

	//pages
	public function index($url, $err = null){
		$this->load_user_data(3);
		if($url == CONTROLLER && is_null($err)){
			$this->page = "home";
			if($this->master === true){
				$Inventory = $this->load_model('Inventory');
				$arr['client_stats'] = $Inventory->client_stats_all();
				}
			if($this->master === false){
				$Inventory = $this->load_model('Inventory');
				$arr['client_stats'] = $Inventory->client_stats_one($this->client_ID);
				}
		}		

		if(!empty($arr)){
			return $this->load_page($this->get_data($arr));
		}
		return $this->load_page();
	}

	public function location($url, $err = null){
		$this->load_user_data('admin');
		if($url === CONTROLLER){
			$Inventory = $this->load_model('Inventory');
			$this->type = "all";
			$arr['section'] = $Inventory->get_section();
			$arr['locate'] = $Inventory->get_location();
			$this->page = "location";
		}

		if(!empty($arr)){
			return $this->load_page($this->get_data($arr));
		}
		return $this->load_page();
	}

	public function account($url, $err = null){
		$this->load_user_data(3);
		$this->default = true;

		$this->style = array(
			"bootstrap-datepicker/css/bootstrap-datepicker3",
			"pnotify/pnotify.custom"
		);
		$this->script = array(
			"jquery-ui/jquery-ui",
			"jqueryui-touch-punch/jquery.ui.touch-punch",
			"moment/moment",
			"fullcalendar/fullcalendar"
		);
		$this->example = array("examples.calendar");

		$client_class = $this->load_model('Client');

		if(is_null($err)){
			if($this->master === true){
				if($url === CONTROLLER){
					$this->page = "account";
					$this->type = "all";
					$arr['client_stats'] = $client_class->get_all();

				}

				elseif($url == "create"){
					$this->page = "account";
					$this->type = "create";
				}

				elseif($url !== CONTROLLER){
					if($this->client_url_check($url)){

					$this->page = "account";
					$this->type = "one";

					$arr['client_NAME'] = $this->url_client_NAME;
					$arr['company_info'] = $client_class->get_one_by_id($this->url_client_ID);
					$arr['company_users'] = $client_class->get_client_users($this->url_client_ID);
					}
				}

			}

			elseif($this->master === false){
				if($url === CONTROLLER){
					$this->page = "account";		
					$this->type = "one";
					$arr['company_users'] = $client_class->get_client_users($this->client_ID);
				}
			}

			if(count($_POST) > 0){
				if($this->type == "create"){
					$client_class->create($_POST);
				}
				if($this->type == "one"){
					$client_class->edit($_POST);
				}


				if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
					$arr['errors'] = $_SESSION['error'];
					$arr['POST'] = $_POST;
				}else{
					$thisClient = isset($arr['client']->name) ? $arr['client']->name : $_SESSION['client'];
					redirect(ADMIN."/account/".$thisClient);
				}

			}

			if(!empty($arr)){
				return $this->load_page($this->get_data($arr));
			}
		}

		return $this->load_page();
	}

	public function inventory($url, $err = null){
		$this->load_user_data(3);
		if(is_null($err)){

			if($url === CONTROLLER){
				$this->assets_table();
				$this->page = "inventory";
				$this->default = true;
				$Inventory = $this->load_model('Inventory');

				if($this->master === true){
					$this->type = "all";
					$arr['table'] = $Inventory->get_all_inv_table();
				}else{
					$this->type = "one";
					$arr['table'] = $Inventory->get_inv_table($this->client_ID);
				}
			}else

			if($url != CONTROLLER){
				if($this->master === true){
					if($this->client_url_check($url)){
						$this->assets_table();
						$this->page = "inventory";
						$this->default = true;
		
						$arr['client_NAME'] = $this->url_client_NAME;
						$Inventory = $this->load_model('Inventory');
						$arr['table'] = $Inventory->get_inv_table($this->url_client_ID);
						$arr['rate'] = $Inventory->get_rate(5);
					}
				}

				if(count($_POST) > 0){

						if(isset($_POST['type'])){
							if($_POST['type'] == "editItem"){
								$Inventory->edit($_POST);
							}
							if($_POST['type'] == "deleteItem"){
								$Inventory->delete($_POST);
							}
					}

					if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
						$data['errors'] = $_SESSION['error'];

						$data['POST'] = $_POST;
					}else{
						if(isset($_SESSION['msg']) && $_SESSION['msg'] != ""){
							$data['msg'] = $_SESSION['msg'];
						}
						redirect(ADMIN."/inventory/".$arr['company_name']);
					}
				}
			}

			if(!empty($arr)){
				return $this->load_page($this->get_data($arr));
			}
		}

		return $this->load_page();
	}

	public function receiving($url, $err = null, $three = null){
		$this->load_user_data(3);
		$this->assets_table();
		$this->default = true;

		if($this->master === false){
			if($url == CONTROLLER && is_null($err)){
				$REC = $this->load_model('Receiving');
				$this->page = "receiving";
				$this->type = "client";
				$arr['table'] = $REC->get_client_rec_table($this->client_ID);
				$arr['stats'] = $REC->client_stats_all();
			}
		}else

		if($this->master === true){

			if($url == CONTROLLER && is_null($err)){
				$this->page = "receiving";
				$this->type = "index";
				$REC = $this->load_model('Receiving');

				$arr['client_list'] = $this->load_model('Client')->company_name_list();
			}else

			if($url === 'view'){
				if(is_null($err)){
					$this->page = "receiving";
					$this->type = "stats";
					$REC = $this->load_model('Receiving');
					$arr['table'] = $REC->make_all_rec_stats();

				}else

				if($this->client_url_check($err)){
					$this->page = "receiving";
					$REC = $this->load_model('Receiving');
					if(is_null($three)){
						$this->type = "statsone";
						$arr['table'] = $REC->make_all_client_rec($this->url_client_ID, $err);
					}
					if(!is_null($three)){
						$this->type = "viewone";
						$arr['table'] = $REC->make_one_client_rec($this->url_client_ID, $three);
					}
				}
			}else

			if($url == 'add'){
				if(is_null($err)){
					$this->page = "receiving";
					$this->type = "create";
				}else
				if($this->client_url_check($err)){
					$this->page = "receiving";
					$this->type = "create";
					$REC = $this->load_model('Receiving');
					$inv = $this->load_model('Inventory')->get_inv_table($this->url_client_ID);
					$arr['tbl_rows'] = $REC->make_inv_rec_form($inv);
				}
			}else

			if($url == 'edit'){
				if($this->client_url_check($err)){
					$this->page = "receiving";
					
				}
			}else

			if($url === "invoiceprint"){
				$this->page = "invoiceprint";
				return $this->view("admin/page/invoiceprint",$this->get_data($arr));

			}else

			if($url === "invoice"){
				$this->page = "receiving-invoice";
				return $this->view("admin/page/receiving-invoice",$this->get_data($arr));
			}

			if(count($_POST) > 0){
				if(isset($_POST['type'])){
					$Inventory = $this->load_model('Inventory');
					if($_POST['type'] == "receive"){
						$Inventory->receive_add($_POST,$this->url_client_ID);
					}
					if($_POST['type'] == "addItem"){
						$Inventory->create($_POST);
					}
					if($_POST['type'] == "editItem"){
						$Inventory->edit($_POST);
					}
					if($_POST['type'] == "deleteItem"){
						$Inventory->delete($_POST);
					}
				}


				if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
					$arr['errors'] = $_SESSION['error'];
					$arr['POST'] = $_POST;
				}else{
					if(isset($_SESSION['msg']) && $_SESSION['msg'] != ""){
						$arr['msg'] = $_SESSION['msg'];
					}

					if($_POST['type'] == "receive"){
						$this->type = "invoice";
						$this->page = "receiving-invoice";
						$arr['POST'] = $_POST;
						$company_info = $this->client_url_check($url);
						if($company_info){
							redirect(ADMIN."/receiving/".$url."/invoice/");
						}
					}

					//redirect(ADMIN."/receiving/".$company_name);
				}

			}
		}

			
			if(!empty($arr)){
				return $this->load_page($this->get_data($arr));
			}

		return $this->load_page();
	}

	public function shipping($url, $err = null){

		$this->load_user_data(3);
		$this->assets_table();
		$this->default = true;

		if(is_null($err)){

			if($url == CONTROLLER){
				$Inventory = $this->load_model('Inventory');
				$this->page = "shipping";

				if($this->master === true){
					$arr['table'] = $Inventory->get_all_ship_table();
					$this->type = "all";
				}else{
					$arr['table'] = $Inventory->get_ship_table($this->client_ID);
					$this->type = "one";
				}
			}
			
			elseif($url !== CONTROLLER){
				if($this->master === true){
					
					if($this->client_url_check($url)){
						$arr['client_NAME'] = $this->url_client_NAME;

						$Inventory = $this->load_model('Inventory');
						$this->page = "shipping";
		
						if($err === null){
							$arr['table'] = $Inventory->get_ship_table($this->url_client_ID);
							$this->type = "one";
						}
						if($err === "create"){
							$arr['table'] = $Inventory->get_inv_table($this->url_client_ID);
							$this->type = "create";
						}
					}
				}
				if($this->master === false){
					if($url === "create"){
						$Inventory = $this->load_model('Inventory');
						$this->page = "shipping";

						$arr['table'] = $Inventory->get_inv_table($this->$client_ID);
						$this->type = "create";
					}
				}
			}

			if($_SERVER['REQUEST_METHOD'] != "POST"){
				$_SESSION['token'] = bin2hex(random_bytes(35));
			}

			if(count($_POST) > 0){

				if(isset($_POST['type'])){
					$Inventory = $this->load_model('Inventory');
					if($_POST['type'] == "ship"){
						$Inventory->ship_add($_POST);
					}
					if($_POST['type'] == "addItem"){
						$Inventory->create($_POST);
					}
					if($_POST['type'] == "editItem"){
						$Inventory->edit($_POST);
					}
					if($_POST['type'] == "deleteItem"){
						$Inventory->delete($_POST);
					}
				}


				if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
					$data['errors'] = $_SESSION['error'];
					$data['POST'] = $_POST;
				}else{
					redirect(ADMIN."/shipping/".$company_name);
				}

			}
			
			if(!empty($arr)){
				return $this->load_page($this->get_data($arr));
			}
		}

		return $this->load_page();
	}

	public function users($url, $err = null){
		
		$this->load_user_data(3);
		$this->assets_table();
		$this->default = true;
		$this->page = "users";

		$User = $this->load_model('User');

		if(is_null($err)){

			if($url === CONTROLLER){
				if($this->master === true){
				$arr['table'] = $User->get_user_list();
				$this->type = "all";
				}
				elseif($this->master === false){
				$arr['table'] = $User->get_client_users($this->client_ID);
				$arr['company_name'] = $this->user_info->client_name;
				$this->type = "one";
				}
			}

			elseif($url !== CONTROLLER){
				if($this->master === true){

					if($this->client_url_check($url)){
						$arr['client_NAME'] = $this->url_client_NAME;
						
						$this->page = "users";
						if($err === null){
							$arr['table'] = $User->get_client_users($this->url_client_ID);
							$this->type = "one";
						}elseif($err == "create"){
							$this->type = "create";
							$this->example = "examples/examples.modals";
						}

					}
				}
			}
		}
		$client_class = $this->load_model('Client');
		if($url == "create"){
			// work on me
			$company_list = $client_class->company_name_list();
	
			if($err == null){
				$arr['company_list'] = $company_list;
			}
			if($this->client_url_check($err)){
				$arr['company_info'] = $client_class->get_one_by_id($this->$client_ID);
			}
			$this->type = "create";
		}


		if($url === 'profile'){
			if($this->client_url_check($err)){

				$this->type = "one";
			}
		}

		if($_SERVER['REQUEST_METHOD'] != "POST"){
			$_SESSION['token'] = bin2hex(random_bytes(35));
		}

		if($_SERVER["REQUEST_METHOD"] == "POST") {

			if(count($_POST) > 0)
			{
				if(isset($_POST['type'])){
					if($_POST['type'] == "editUser"){
						$User->edit($_POST);
					}

					if($_POST['type'] == "create"){
						$User->signup($_POST);
					}
				}
				if(isset($_SESSION['error']) && $_SESSION['error'] != ""){
					$data['errors'] = $_SESSION['error'];
					$data['POST'] = $_POST;
				}
			}
		}

		if(!empty($arr)){
			return $this->load_page($this->get_data($arr));
		}
	
		return $this->load_page();
	}

	public function settings(){
		$this->load_user_data(3);
		$Settings = new Settings();

		if(isset($_GET['saved']) && $_GET['saved'] == true){
			$arr['saved'] = "Settings Saved!";
		}

		if(count($_POST) > 0)
		{
			$errors = $Settings->save_settings($_POST);
			redirect(ADMIN.'/settings?saved=true');
			die;
		}

		$arr['settings'] = $Settings->get_all_settings();
		$this->page = "settings";

		if(!empty($arr)){
			return $this->load_page($this->get_data($arr));
		}
		return $this->load_page();
	}

	public function logout(){
		if(isset($_SESSION['user_url']))
		{
			unset($_SESSION);
			my_session_regenerate_id();
			session_destroy();
		}

		header("Location: " . ROOT . "login");
		die;
	}
}