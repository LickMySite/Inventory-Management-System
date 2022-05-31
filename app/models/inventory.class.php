<?php 

Class Inventory
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
	public function edit_item(int $ID){

		$arr['item'] = trim(filter_input(INPUT_POST,'item',FILTER_SANITIZE_SPECIAL_CHARS));
		$arr['types'] = trim(filter_input(INPUT_POST,'types',FILTER_SANITIZE_SPECIAL_CHARS));
		$arr['per'] = trim(filter_input(INPUT_POST,'per',FILTER_SANITIZE_SPECIAL_CHARS));
		$arr['begin'] = trim(filter_input(INPUT_POST,'begin',FILTER_SANITIZE_SPECIAL_CHARS));
		$data['csrf_token'] = clean_input($_POST['csrf_token']);
		$arr['item_id'] = $ID;

		!empty($arr['item'])?: $_SESSION['error'] = "Please enter an item name";
		preg_match("/^[a-zA-Z0-9- ]+$/", $arr['item'])?:$_SESSION['error'] = "Please enter a valid item name";
		!preg_match("/^[0-9]+$/", $arr['per'])
			|| !is_int($arr['per'])
			|| $arr['per'] != 0
			?: $_SESSION['error'] = "Per must be a number";
		!is_int($arr['begin']) || $arr['begin'] != 0 ?: $_SESSION['error'] = "Begin must be a number";

		if(!isset($_SESSION['error']) || $_SESSION['error'] == ""){
			$query = "UPDATE inventory set item = :item, per = :per, begin =:begin, type =:types where item_id = :item_id";
			$DB = Database::newInstance();
			$check = $DB->write($query,$arr);

			if($check){
				$_SESSION['msg'] = "Item Edited!";
				return true;
			}
		}

		return false;
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
		$query = "select * from inventory";

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
	public function ship_add($DATA){
		if(empty($DATA['item_id'])){
			$this->error .= "Please add an item</br>";
			$_SESSION['error'] = $this->error;
			return;
		}else{

			if(empty($DATA['quantity'])){
				$this->error .= "Please add quantity</br>";
			}else{

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
			}
			
			$arr['client_id'] = $DATA['client_id'];
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

		}

		// if(filter_var($DATA['item_id'], FILTER_VALIDATE_INT) === false){
		// 	$this->error .= "Select Company <br>";
		// }

		$_SESSION['error'] = $this->error;

		if(!isset($_SESSION['error']) || $_SESSION['error'] == ""){
			$x = 0;
			$DB = Database::newInstance(); 

			foreach($item_ids as $value){
				if($quantity[$x] > 0 ){
					$arr['item_id'] = $value;
					$arr['quantity'] = $DATA['quantity'][$x];
		 
					$query = "insert into shipping (item_id,client_id,qty_ship,po,container,date) values (:item_id,:client_id,:quantity,:po,:container,:date)";
					$DB->write($query,$arr);
				}
				$x++;
			}
		}

		return false;

	}
	//use
	public function get_all_ship_table(){

    $DB = Database::newInstance();


		$query = 
			"SELECT s.ship_id,s.qty_ship,s.po,s.container,s.date,s.client_id,c.client_name,s.item_id,i.item,i.per
			FROM shipping AS s
			LEFT JOIN (
				SELECT id,client_name
				FROM client) 
				AS c 
				ON c.id = s.client_id
			LEFT JOIN (
				SELECT begin,item_id,item,per
				FROM inventory) 
				AS i 
				ON i.item_id = s.item_id
			ORDER BY s.ship_id ASC
		";
	
		$datas = $DB->read($query);
		if(is_array($datas)){

			return $datas;
		}
	}
	//use
	public function get_all_rec_table(){

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
	public function get_inv_table(int $id){
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
	public function get_rec_table(int $id){
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
	public function get_ship_table(int $id){
		$arr['id'] = $id;

    $DB = Database::newInstance();

		$query = 
			"SELECT s.ship_id,s.item_id,s.qty_ship,s.po,s.container,s.date,i.item,i.item_id,i.per
			FROM shipping AS s
			LEFT JOIN (
				SELECT item_id,item,per
				FROM inventory) AS i 
				ON i.item_id = s.item_id
			WHERE s.client_id = :id 
			GROUP BY ship_id
			ORDER BY s.date ASC
		";

		$datas = $DB->read($query,$arr);
		if(is_array($datas)){

			return $datas;
		}
	}
	//use
	public function client_stats_one(int $id){

		$arr['id'] = $id;
		$DB = Database::newInstance();
		$query = 
		"SELECT id, client_name AS name, fullname,
			IFNULL(i.item_count,0) AS items,
			IFNULL(r.rec_count,0) AS rec,
			IFNULL(s.ship_count,0) AS ship, 
			IFNULL(u.user_count,0) AS user 
		FROM client 
			LEFT JOIN (
				SELECT client_id, COUNT(item_id) AS item_count
				FROM inventory 
				GROUP BY client_id) AS i
				ON i.client_id = client.id
			LEFT JOIN (
				SELECT client_id, COUNT(rec_id) AS rec_count
				FROM receiving 
				GROUP BY client_id) AS r
				ON r.client_id = client.id
			LEFT JOIN (
				SELECT client_id, COUNT(ship_id) AS ship_count
				FROM shipping 
				GROUP BY client_id) AS s
				ON s.client_id = client.id
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

	public function client_stats_all(){

		$DB = Database::newInstance();
		$query = "SELECT id, client_name AS name, fullname,
			IFNULL(i.item_count,0) AS items,
			IFNULL(r.rec_count,0) AS rec,
			IFNULL(s.ship_count,0) AS ship, 
			IFNULL(u.user_count,0) AS user 
		FROM client 
			LEFT JOIN (
				SELECT client_id, COUNT(item_id) AS item_count
				FROM inventory 
				GROUP BY client_id) AS i
				ON i.client_id = client.id
			LEFT JOIN (
				SELECT client_id, COUNT(rec_id) AS rec_count
				FROM receiving 
				GROUP BY client_id) AS r
				ON r.client_id = client.id
			LEFT JOIN (
				SELECT client_id, COUNT(ship_id) AS ship_count
				FROM shipping 
				GROUP BY client_id) AS s
				ON s.client_id = client.id
			LEFT JOIN (
				SELECT client_id, COUNT(client_id) AS user_count
				FROM users 
				GROUP BY client_id) AS u
				ON u.client_id = client.id

		";

		$result = $DB->read($query);

		if(is_array($result)){
			return $result;
		}
		return false;
	}

	public function set_rate($DATA){

		$arr['client_id'] = $DATA['client_id'];
		$arr['handling'] = $DATA['handling'];
		$arr['storage'] = $DATA['storage'];

		if(!isset($_SESSION['error']) || $_SESSION['error'] == ""){
			$query = "INSERT INTO rate (client_id,handling,storage) VALUES (:item,:handling,:storage)";
			$DB = Database::newInstance(); 
			$check = $DB->write($query,$arr);

			if($check){
				$_SESSION['msg'] = "Rate Created!";
				return true;
			}
		}

		return false;
	}

	public function get_rate(int $client_id){

		$arr['client_id'] = $client_id;

    $DB = Database::newInstance();
		$query = "SELECT * from rate WHERE client_id = :client_id " ;

		$result = $DB->read($query,$arr);
		
		if(is_array($result))
		{
			return $result[0];
		}

		return false;
	}

	public function get_location(){


    $DB = Database::newInstance();
		$query = 
		"SELECT l.id,l.section,s.item_id,i.item,s.item_count,s.date 
		FROM section_location AS l
		LEFT JOIN (
			SELECT section_id,item_id,item_count,date
			FROM item_section) 
			AS s 
			ON l.id = s.section_id
		LEFT JOIN (
			SELECT item_id,item
			FROM inventory) 
			AS i 
			ON i.item_id = s.item_id
		" ;

		$result = $DB->read($query);
		
		if(is_array($result))
		{
			return $result;
		}

		return false;
	}

	public function get_section(){


    $DB = Database::newInstance();
		$query = 
		"SELECT * 
		FROM section_location
		" ;

		$check = $DB->read($query);
		
		if(is_array($check)){

			$result = array();
			foreach ($check as $object)
			{
				$result[$object->id] = $object->section;
			}

			return $result;
		}

		return false;
	}

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
		// '.isset($POST['quantity'][$x]) ? show_input($POST['quantity'][$x]) : "".'
	}

	public function make_inv_rec_table($invs){



		$result = "";
		if(is_array($invs)){
			$x = 0;
			foreach ($invs as $data) {

				$edit_args = $data->rec_id.",'".addslashes($data->item)."',".$data->qty_rec;

				$result .= '

				<tr data-item-id="'.$data->rec_id.'">
        <td>'.$data->rec_id.'</td>

        <td>'.$data->qty_rec.'</td>
        <td data-title="Item"><a class="modal-with-form" href="#editItem_'.$data->item_id.'"><strong>'.$data->item.'</strong></a></td>
        <td>'.$data->po.'</td>
        <td>'.$data->container.'</td>
        <td class="center">'.date("M jS, Y",strtotime($data->date)).'</td>

					<td>	
							<button onclick="show_edit_category('.$edit_args.',event)" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
							<button onclick="delete_row('.$data->rec_id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
					</td>
				</tr>
				';

				$x++;
			}
		}

		return $result;
	}

	public function get_one_rec($rec_id){

		$arr['rec_id'] = $rec_id;

		$query = "SELECT * from receiving WHERE rec_id = :rec_id";
		$DB = Database::newInstance();
		$result = $DB->read($query,$arr);
		
		if(is_array($result))
		{
			return $result;
		}

		return false;
	}

	public function get_one_item($ID){

		$arr['ID'] = $ID;

		$query = "SELECT * from inventory WHERE item_id = :ID";
		$DB = Database::newInstance();
		$result = $DB->read($query,$arr);
		
		if(is_array($result))
		{
			return $result[0];
		}

		return false;
	}
	public function get_client_name_by_id($id){

		$arr['id'] = $id;

		$DB = Database::newInstance();
		$query = "select client_name from client where id = :id limit 1";
		$result = $DB->read($query,$arr);

		if(is_array($result))
		{
			return $result[0];
		}

		return false;
	}

}