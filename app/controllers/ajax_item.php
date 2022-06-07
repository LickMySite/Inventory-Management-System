<?php 

Class Ajax_item extends Controller
{
	private function client_url_check($url){

		$client_class = $this->load_model('Client');
		$company_list = $client_class->company_name_list();

		if(in_array($url,$company_list,true)){
			$this->type = "one";

			$ID = array_search($url,$company_list,true);
			$result = $client_class->get_one_by_id($ID);
		}
		if(isset($result)){
			return $result;
		}
		return false;
	}

	public function index()
	{
		$_SESSION['error'] = "";
		
 		$data = file_get_contents("php://input"); 
		$data = json_decode($data);

		if(is_object($data) && isset($data->data_type))
		{

			$DB = Database::getInstance();
			$category = $this->load_model('Category');
			$Inventory = $this->load_model('inventory');
			if($data->data_type == 'add_category')
			{
				//add new category
				$check = $Inventory->create($data);
				//$check = $category->create($data);
				if($_SESSION['error'] != "")
				{
					$arr['message'] = $_SESSION['error'];
					$_SESSION['error'] = "";
					$arr['message_type'] = "error";
					$arr['data'] = "";
					$arr['data_type'] = "add_new";
					
					echo json_encode($arr);
				}else
				{
					$arr['message'] = "Item added successfully!";
					$arr['message_type'] = "info";
					// $cats = $category->get_all();
					// $arr['data'] = $category->make_table($cats);
					$arr['data_type'] = "add_new";
					$inv =  $Inventory->get_inv_table($data->client_id);
					$arr['data'] = $Inventory->make_inv_rec_form($inv);

					echo json_encode($arr);
				}
			}else
			if($data->data_type == 'disable_row')
			{

				$disabled = ($data->current_state == "Enabled") ?  1 : 0 ;
				$id = $data->id ;

				$query = "update categories set disabled = '$disabled' where id = '$id' limit 1";
				$DB->write($query);

				$arr['message'] = "";
				$_SESSION['error'] = "";
				$arr['message_type'] = "info";

				$cats = $category->get_all();
				$arr['data'] = $category->make_table($cats);

				$arr['data_type'] = "disable_row";

				echo json_encode($arr);

			}else
			if($data->data_type == 'edit_category')
			{

				$Inventory->edit_rec($data);
				$arr['message'] = "Your row was successfully edited";
				$_SESSION['error'] = "";
				$arr['message_type'] = "info";
				
				// $cats = $category->get_all();
				// $arr['data'] = $category->make_table($cats);
				$inv =  $Inventory->get_rec_table($company_info->id);
				$arr['tbl_rows'] = $Inventory->make_inv_rec_table($inv);


				$arr['data_type'] = "edit_category";

				echo json_encode($arr);

			}else
			if($data->data_type == 'delete_row')
			{

				$category->delete($data->id);
				$arr['message'] = "Your row was successfully deleted";
				$_SESSION['error'] = "";
				$arr['message_type'] = "info";
				
				$cats = $category->get_all();
				$arr['data'] = $category->make_table($cats);

				$arr['data_type'] = "delete_row";

				echo json_encode($arr);
			}


		}
		
	}




}