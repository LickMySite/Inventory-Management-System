<?php 

Class Receiving
{
	private $error = "";

	private function get_random_string_max($length) {

		$array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$text = "";

		$length = rand(4,$length);

		for($i=0;$i<$length;$i++) {

			$random = rand(0,61);
			
			$text .= $array[$random];

		}

		return $text;
	}

	//use
	public function create($data){

		if(is_array($data)){
			$arr['client_id'] = $data['client_id'];
			$arr['item'] = $data['item'];
		}
		elseif(is_object($data)){
		$arr['client_id'] = $data->client_id;
		$arr['item'] = $data->item;
		}

		
		if(empty($arr['client_id'])){
			$_SESSION['error'] = "Please select a company";
		}

		if(empty($arr['item'])){
			$_SESSION['error'] = "Please enter an item name";
		}

		if(!preg_match("/^[a-zA-Z0-9- ]+$/", trim($arr['item'])))
		{
			$_SESSION['error'] = "Please enter a valid item name";
		}

		if(!isset($_SESSION['error']) || $_SESSION['error'] == ""){
			$query = "INSERT INTO inventory (item,client_id) VALUES (:item,:client_id)";
			$DB = Database::newInstance(); 
			$check = $DB->write($query,$arr);

			if($check){
				$_SESSION['msg'] = "Item Created!";
				return true;
			}
		}

		return false;

	}
	//use
	public function edit($data){

		if(is_array($data)){
			$arr['item_id'] = $data['item_id'];
			$arr['item'] = $data['item'];
			}else
		if(is_object($data)){
			$arr['item_id'] = $data->item_id;
			$arr['item'] = $data->item;
			}
		$query = "UPDATE inventory set item = :item where item_id = :item_id limit 1";
		$DB = Database::newInstance();
		$DB->write($query,$arr);
		$DB = null;
		$_SESSION['msg'] = "Item Edited!";

	}

	public function edit_rec($data){

		if(is_array($data)){
			$arr['item_id'] = $data['item_id'];
			$arr['item'] = $data['item'];
			}else
		if(is_object($data)){
			$arr['item_id'] = $data->item_id;
			$arr['item'] = $data->item;
			}
		$query = "UPDATE inventory set item = :item where item_id = :item_id limit 1";
		$DB = Database::newInstance();
		$DB->write($query,$arr);
		$DB = null;
		$_SESSION['msg'] = "Item Edited!";

	}

	//use
	public function delete($data){

		$DB = Database::newInstance();
		$arr['item_id'] = $data['item_id'];


		$query = "delete from inventory where item_id = :item_id limit 1";
		$DB->write($query,$arr);
		$_SESSION['msg'] = "Item Deleted!";

	}

	public function get_all(){
    $DB = Database::newInstance();
		$query = "SELECT * from receiving";

		$result = $DB->read($query);
		
		if(is_array($result))
		{
			return $result;
		}

		return false;
	}

	//use
	public function receive_add($DATA,$client_id){

			if(empty($DATA['quantity'])){
				$this->error .= "Please add quantity</br>";
			}
				// $location = array();
				// $location = $DATA['location'];

				$item_ids = array();
				$item_ids = $DATA['item_id'];

				$quantity = array();
				$quantity = $DATA['quantity'];

				foreach ($item_ids as $value) {
					if (!is_numeric($value) && !empty($value)) {
						$this->error .= "Error with item</br>";
					}
				}

				foreach ($quantity as $value) {
					if (!is_numeric($value) && !empty($value)) {
						$this->error .= "Error with QTY</br>";
					}
				}
			
			
			$arr['client_id'] = $client_id;
			$arr['po'] = trim($DATA['po']);
			$arr['container'] = trim($DATA['container']);
			$arr['date'] = date_format(date_create_from_format('m-d-Y', $DATA['date']), 'Y-m-d');
	
			if(empty($arr['po']) && empty($arr['container'])){
				$this->error .= "Please enter a PO or a Container</br>";
			}
			if(!preg_match("/^[a-zA-Z0-9- ]+$/", $arr['po'])){
				$this->error .= "Please enter a valid po</br>";
			}
			if(!preg_match("/^[a-zA-Z0-9- ]+$/", $arr['container'])){
				$this->error .= "Please enter a valid container</br>";
			}

		
		$_SESSION['error'] = $this->error;

		if(!isset($_SESSION['error']) || $_SESSION['error'] == ""){

		//check for url_address
			$DB = Database::newInstance(); 

			$data['rec_id'] = $this->get_random_string_max(60);

			$query = "SELECT rec_id from receiving where rec_id = :rec_id limit 1";
			$check = $DB->read($query,$data);
			if(is_array($check)){
				$data['rec_id'] = $this->get_random_string_max(60);
			}
			$arr['rec_id'] = $data['rec_id'];



			$x = 0;

			foreach($item_ids as $value){
				if($quantity[$x] > 0 ){
					
					$arr['item_id'] = $value;
					$arr['quantity'] = $DATA['quantity'][$x];

					$query = 
					"INSERT into receiving (rec_id,item_id,qty_rec,po,container,date,client_id) values (:rec_id,:item_id,:quantity,:po,:container,:date,:client_id)
					";
					$DB->write($query,$arr);
				}
				$x++;
			}
		}
	}
	//use
	public function get_all_client_rec_table(){

    $DB = Database::newInstance();


		$query = 
			"SELECT r.rec_id,r.qty_rec,r.po,r.container,r.date,r.client_id,c.client_name,r.item_id,i.item,i.per
			FROM receiving AS r
			LEFT JOIN (
				SELECT id,client_name
				FROM client) 
				AS c 
				ON c.id = r.client_id
			LEFT JOIN (
				SELECT begin,item_id,item,per
				FROM inventory) 
				AS i 
				ON i.item_id = r.item_id
			ORDER BY r.rec_id ASC
		";
	
		$datas = $DB->read($query);
		if(is_array($datas)){

			return $datas;
		}
	}
	//use
	public function get_all_inv_table(){

    $DB = Database::newInstance();


		$query = 
			"SELECT c.id,c.client_name,i.client_id,i.item,i.item_id,i.per,i.begin,rec,ship,(IFNULL(i.begin,0) + IFNULL(rec,0) - IFNULL(ship,0)) as finish
			FROM inventory AS i
			LEFT JOIN (
				SELECT id,client_name
				FROM client) 
				AS c 
				ON c.id = i.client_id
			LEFT JOIN (
				SELECT item_id,SUM(qty_ship) AS ship
				FROM shipping 
				GROUP BY item_id) AS s 
				ON s.item_id = i.item_id
			LEFT JOIN (
				SELECT item_id,SUM(qty_rec) AS rec
				FROM receiving 
				GROUP BY item_id) AS r 
				ON r.item_id = i.item_id
			GROUP BY i.item_id
			ORDER BY i.item ASC
		";

		$datas = $DB->read($query);
		if(is_array($datas)){

			return $datas;
		}
	}
	//use
	public function get_one_rec_table(int $id){
		$arr['id'] = $id;

    $DB = Database::newInstance();

		$query = 
			"SELECT i.item,i.item_id,i.per,i.begin,rec,ship,(IFNULL(i.begin,0) + IFNULL(rec,0) - IFNULL(ship,0)) as finish
			FROM inventory AS i
			LEFT JOIN (
				SELECT item_id,SUM(qty_ship) AS ship
				FROM shipping 
				GROUP BY item_id) AS s 
				ON s.item_id = i.item_id
			LEFT JOIN (
				SELECT item_id,SUM(qty_rec) AS rec
				FROM receiving 
				GROUP BY item_id) AS r 
				ON r.item_id = i.item_id
			WHERE i.client_id = :id 
			GROUP BY i.item_id
			ORDER BY i.item ASC
		";

		$datas = $DB->read($query,$arr);
		if(is_array($datas)){

			return $datas;
		}
	}
	//use
	public function get_client_rec_table(int $id){
		$arr['id'] = $id;

    $DB = Database::newInstance();


		$query = 
			"SELECT id,rec_id,qty_rec,po,container,date,i.item,i.item_id,i.per
			FROM receiving AS r
			LEFT JOIN (
				SELECT item_id,item,per
				FROM inventory) AS i 
				ON i.item_id = r.item_id
			WHERE r.client_id = :id 
			ORDER BY r.date ASC
		";

		$datas = $DB->read($query,$arr);
		if(is_array($datas)){

			return $datas;
		}
	}
	//use
	public function make_inv_rec_form($invs){


		$result = "";
		if(is_array($invs)){
			$x = 0;
			foreach ($invs as $data) {

				$result .= '
				<tr data-item-id="'.$data->item_id.'">

					<td><input type="tel" class="form-control" name="PCS" maxlength="4"></td>

					<td data-title="Received">
						<input type="tel" class="form-control" name="quantity[]" maxlength="4" value="">
						<input type="hidden" name="item_id[]" value="'.$data->item_id.'">
					</td>

					<td data-title="Item"><strong>'.$data->item.'</strong></td>
					<td class="text-end">'.$data->finish.'</td>
				</tr>

				';

				$x++;
			}
		}

		return $result;
	}

	public function client_stats_by_rec(int $id){

		$arr['id'] = $id;
		$DB = Database::newInstance();
		$query = "SELECT client_name AS name,
			IFNULL(r.rec_count,0) AS rec,
			IFNULL(r.rec_total,0) AS rec_total
		FROM client 
			LEFT JOIN (
				SELECT client_id, COUNT(DISTINCT rec_id) AS rec_count, SUM(qty_rec) AS rec_total
				FROM receiving 
				GROUP BY client_id) AS r
				ON r.client_id = client.id
			LEFT JOIN (
				SELECT client_id, COUNT(client_id) AS user_count
				FROM users 
				GROUP BY client_id) AS u
				ON u.client_id = client.id
				WHERE client.id = :id
		";

		$result = $DB->read($query,$arr);

		if(is_array($result)){
			return $result;
		}
		return false;
	}


	//reciving/view
	private function get_all_rec_stats(){

		$DB = Database::newInstance();
		$query = "SELECT client_name AS name,
			IFNULL(r.rec_count,0) AS rec,
			IFNULL(r.rec_total,0) AS rec_total
		FROM client 
			LEFT JOIN (
				SELECT client_id, COUNT(DISTINCT rec_id) AS rec_count, SUM(qty_rec) AS rec_total
				FROM receiving 
				GROUP BY client_id) AS r
				ON r.client_id = client.id
		";
		$result = $DB->read($query);

		if(is_array($result)){
			return $result;
		}
		return false;
	}
	public function make_all_rec_stats(){
		$data = $this->get_all_rec_stats();

		$result = '
		<table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
			<thead>
				<tr>
				<th>Client</th>
				<th>Total REC</th>
				<th>Total Items</th>
			</thead>
			<tbody>

		';
		$count = 0;
		for($x = 0; $x < count($data); $x++){
			$count = $count + $data[$x]->rec;
			$result .= '
      <tr data-item-id="row_'.($x + 1).'">
        <td><a href="'.ADMIN.'receiving/view/'.$data[$x]->name.'" class="btn btn-default w-100"><strong>'.$data[$x]->name.'</strong></a></td>
        <td>'.$data[$x]->rec.'</td>
        <td>'.$data[$x]->rec_total.'</td>
      </tr>
			';
		}
		$result .= '
			</tbody></table><p>Total '.$count.'
		';

		return $result;
	}

	//receiving/view/client-one
	private function get_one_client_rec(int $client_id, $rec_id){
		$arr['client_id'] = $client_id;
		$arr['rec_id'] = $rec_id;

		$query = 
		"SELECT client_id,id,rec_id,qty_rec,po,container,date,i.item,i.item_id,i.per 
		from receiving AS r
		LEFT JOIN (
				SELECT item_id,item,per
				FROM inventory) AS i 
				ON i.item_id = r.item_id

		WHERE client_id = :client_id AND rec_id = :rec_id
		";

		$DB = Database::newInstance();
		$result = $DB->read($query,$arr);
		
		if(is_array($result))
		{
			return $result;
		}

		return false;
	}
	public function make_one_client_rec(int $client_id,$rec_id){

		$data = $this->get_one_client_rec($client_id,$rec_id);

		$result = '
			<thead>
				<tr>
					<th width="5%">ID</th>
					<th width="5%">QTY</th>
					<th width="35%">Item</th>
					<th width="10%">PO</th>
					<th width="10%">Container</th>
					<th width="10%">Date</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody id="table_body">
		';

		if(is_array($data)){
			for($x = 0; $x < count($data); $x++) {

				$edit_args = $data[$x]->rec_id.",'".addslashes($data[$x]->item)."',".$data[$x]->qty_rec;

				$result .= '

				<tr data-item-id="'.$data[$x]->rec_id.'">
					<td>'.$data[$x]->rec_id.'</td>
					<td>'.$data[$x]->qty_rec.'</td>
					<td data-title="Item"><a class="modal-with-form" href="#editItem_'.$data[$x]->item_id.'"><strong>'.$data[$x]->item.'</strong></a></td>
					<td>'.$data[$x]->po.'</td>
					<td>'.$data[$x]->container.'</td>
					<td class="center">'.date("M jS, Y",strtotime($data[$x]->date)).'</td>
					<td>	
							<button onclick="show_edit_category('.$edit_args.',event)" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
							<button onclick="delete_row('.$data[$x]->rec_id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
					</td>
				</tr>
				';
			}
		}

		$result .= '</tbody>';
		return $result;
	}

	//receiving/view/client-all 
	private function get_all_client_rec(int $client_id){
		$arr['client_id'] = $client_id;

		$DB = Database::newInstance();
		$query = 
			"SELECT rec_id, COUNT(rec_id) AS rec_count, SUM(qty_rec) AS rec_total, po, container,date
				FROM receiving 
				WHERE client_id = :client_id
				GROUP BY rec_id
			";

		$result = $DB->read($query, $arr);

		if(is_array($result)){
			return $result;
		}
		return false;
	}
	public function make_all_client_rec(int $client_id,$url_client_NAME){

		$data = $this->get_all_client_rec($client_id);

		$result = '
			<thead>
				<tr>
					<th>Rec id</th>
					<th>Items</th>
					<th>Total Items</th>
					<th>PO</th>
					<th>Container</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody id="table_body">
		';

		if(is_array($data)){
			for($x = 0; $x < count($data); $x++) {
				$result .= '
					<tr data-item-id="'.$data[$x]->rec_id.'">
						<td><a href="'.ADMIN.'receiving/view/'.$url_client_NAME.'/'.$data[$x]->rec_id.'" class="btn btn-default w-100"><strong>VIEW</strong></a></td>
						<td>'.$data[$x]->rec_count.'</td>
						<td>'.$data[$x]->rec_total.'</td>
						<td>'.$data[$x]->po.'</td>
						<td>'.$data[$x]->container.'</td>
						<td>'.date("M jS, Y",strtotime($data[$x]->date)).'</td>
					</tr>
				';
			}
		}

		$result .= '</tbody>';
		return $result;
	}
}