<?php if($url_client_NAME):?>
<style type="text/css">
  .add_new{
    background-color: #eae8e8;
    box-shadow: 0px 0px 10px #aaa;
  }

  .edit_category{
    width: 500px;
    height:450px;
    background-color: #eae8e8;
    box-shadow: 0px 0px 10px #aaa;
    position: absolute;
    padding: 6px;
    z-index: 1;
  }

  .show{
    display: block;
  }

  .hide{
    display: none;
  }
</style>

<button class="btn btn-primary btn-sm font-weight-semibold btn-py-2 m-4" onclick="show_add_new(event)"><i class="fa fa-plus"></i> Add New Item</button>

<!--add new item-->
<div class="add_new hide">
  <section class="card">
    <div class="card-header">
      <h4 class="mb"><i class="fa fa-angle-right"></i> Add New Item</h4>
    </div>
    <form class="form-horizontal style-form" method="post">
    <input type="hidden" id="clientId" name="clientId" value="<?=isset($company_info) ? $company_info->id : $user_info->client_id;?>">

      <div class="card-body">

        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Item Name:</label>
          <div class="col-sm-10">
            <input id="newItem" name="item" type="text" class="form-control" autofocus>
          </div>
        </div>
        <br><br style="clear: both;"><br>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Parent (optional):</label>
          <div class="col-sm-10">
            <select id="parent" name="parent"  class="form-control" required>
              <option value="1"></option>
                <?php if(is_array($categories)): ?>
                  <?php foreach($categories as $categ): ?>
                    <option value="<?=$categ->id?>"><?=$categ->category?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="card-footer">
        <button type="button" class="btn btn-danger" onclick="show_add_new(event)">Close</button>
        <button type="button" class="btn btn-success" onclick="this.disabled=true;collect_data(event);this.disabled=false">Save</button>
      </div>
    </form>
  </section>
</div>
<!--add new category end-->

<!--edit category-->
<div class="edit_category hide" >
  <section class="card">
    <div class="card-header">
      <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Category</h4>
    </div>
    <form class="form-horizontal style-form" method="post">
      <div class="card-body">
      <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Category Name:</label>
          <div class="col-sm-10">
            <input id="category_edit" name="category" type="text" class="form-control" autofocus>
          </div>
        </div>
        <br><br style="clear: both;"><br>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Parent (optional):</label>
          <div class="col-sm-10">
              <select id="parent_edit" name="parent"  class="form-control" required>
              <option></option>
              <?php if(is_array($categories)): ?>
                <?php foreach($categories as $categ): ?>
                  <option value="<?=$categ->id?>"><?=$categ->category?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="button" class="btn btn-danger" onclick="show_edit_category(0,'',event,'')">Cancel</button>
        <button type="button" class="btn btn-success" onclick="collect_edit_data(event)">Save</button>
      </div>
    </form>
  </section>  
</div>
<!--edit category end-->


<!-- <div class="row">
  <div class="col-sm-6">
    <div class="mb-3">
      <button class="btn btn-primary btn-sm font-weight-semibold btn-py-2 m-4" data-bs-toggle="modal" data-bs-target="#formModal_newItem">Add Item <i class="fas fa-plus"></i></button>
    </div>
  </div>
</div> -->



<form id="receiveAdd" method="POST" class="needs-validation" autocomplete="off" enctype="multipart/form-data">

  <div class="form-group row pb-3">
    <label class="col-lg-1 control-label text-lg-end pt-2" for="po"><b>PO&num;</b></label>
    <div class="col-lg-6">
      <div class="input-group">
        <span class="input-group-text">
          <i class="fas fa-edit"></i>
        </span>
        <input type="text" name="po" class="form-control" id="po" value="<?=isset($POST['po']) ? show_input($POST['po']) : '';?>">
      </div>
    </div>
  </div>

  <div class="form-group row pb-3">
    <label class="col-lg-1 control-label text-lg-end pt-2" for="container"><b>Container&num;</b></label>
    <div class="col-lg-6">
      <div class="input-group">
        <span class="input-group-text">
          <i class="fas fa-truck"></i>
        </span>
        <input type="text" name="container" class="form-control" id="container" value="<?=isset($POST['container']) ? show_input($POST['container']) : '';?>">
      </div>
    </div>
  </div>

  <div class="form-group row pb-3">
    <label class="col-lg-1 control-label text-lg-end pt-2"><b>Date</b></label>
    <div class="col-lg-6">
      <div class="input-group">
        <span class="input-group-text">
          <i class="fas fa-calendar-alt"></i>
        </span>
        <input type="text" name="date" data-plugin-datepicker data-plugin-masked-input data-input-mask="99-99-9999" placeholder="__-__-____" value="<?=isset($POST['date']) ? show_input($POST['date']) : date("m-d-Y");?>" class="form-control">
      </div>
    </div>
  </div>


  <div class="form-group row pb-3">
    <label class="col-lg-1 control-label text-lg-end pt-2" for="image"><b>File Upload</b></label>
    <div class="col-lg-6">
      <span class="input-group-text">
        <i class="fas fa-file-import"></i>
      </span>
      <div action="<?=ROOT;?>upload" type="file" name="image" class="dropzone dz-square" id="dropzone-example"></div>
    </div>
  </div>


  
  <table class="table table-bordered table-striped table-hover mb-0" id="datatable-default">

    <thead>
      <tr>
        <th width="15%">PCS</th>
        <th width="15%">PLT</th>
        <th width="60%">Item</th>
        <th width="10%">Current</th>
      </tr>
    </thead>
    <tbody id="table_body">
      <?=$tbl_rows?>
    </tbody>
  </table>

  <input type="hidden" name="type" value="receive">
  <hr class="mt-4 mb-4"/>
  <div class="text-end">
    <button type="submit" class="btn btn-outline btn-rounded btn-success mb-2 text-uppercase font-weight-bold w-25" data-loading-text="Loading..." onclick="this.disabled=true;this.form.submit();">Submit</button>
  </div>

</form>



<?php if(isset($table)): $x=0; foreach($table as $data):?>


  <tr data-item-id="<?=$data->item_id;?>">

    <td><input type="tel" class="form-control" name="PCS" maxlength="4"></td>

    <td data-title="Received">
      <input type="tel" class="form-control" name="quantity[]" maxlength="4" value="<?=isset($POST['quantity'][$x]) ? show_input($POST['quantity'][$x]) : '';?>">
      <input type="hidden" name="item_id[]" value="<?=$data->item_id?>">
    </td>

    <td data-title="Item"><a class="modal-with-form" href="#editItem_<?=$data->item_id;?>"><strong><?=$data->item;?></strong></a></td>
    <td class="text-end"><?=$data->finish;?></td>
  </tr>

  <!-- Edit Item Form -->
  <div id="editItem_<?=$data->item_id;?>" class="modal-block modal-block-primary mfp-hide">
    <section class="card">
      <header class="card-header">
        <h2 class="card-title">Edit: <?=$data->item;?></h2>
        <a class="modal-with-form btn btn-rounded btn-danger float-end" href="#deleteItem_<?=$data->item_id;?>">
          <i class="fas fa-trash"></i>DELETE
        </a>
      </header>
      <form id="editItem" method="post" class="needs-validation">
        <input type="hidden" name="type" value="editItem">
        <input type="hidden" name="item_id" value="<?=$data->item_id;?>">
        <div class="card-body">
          <div class="form-group">
            <label for="item">Name</label>
            <input type="text" class="form-control" name="item" id="item" maxlength="40" placeholder="<?=$data->item;?>" value="<?=$data->item;?>">
          </div>
        </div>
        <footer class="card-footer">
          <div class="row">
            <div class="col-md-12 text-end">
              <button class="btn btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
              <button class="btn btn-default modal-dismiss">Cancel</button>
            </div>
          </div>
        </footer>
      </form>

    </section>
  </div>

  <!-- Delete Item Form -->
  <div id="deleteItem_<?=$data->item_id;?>" class="modal-block modal-block-primary mfp-hide">
    <form id="deleteItem" method="post" class="needs-validation">
      <input type="hidden" name="type" value="deleteItem">
      <input type="hidden" name="item_id" value="<?=$data->item_id;?>">

      <section class="card">
        <header class="card-header">
          <h2 class="card-title">Delete: <?=$data->item;?></h2>
          <a class="modal-with-form btn btn-rounded btn-info float-end" href="#editItem_<?=$data->item_id;?>">
            <i class="fas fa-edit"></i>Go Back to Edit
          </a>
        </header>
        <div class="card-body">
        <h2 class="card-title">Are you sure you want to delete <?=$data->item;?> ?</h2>
        <p>This action cant be undone!</p>
        </div>
        <footer class="card-footer">
          <div class="row">
            <div class="col-md-12 text-end">
              <button class="btn btn-danger" type="submit" onclick="this.disabled=true;this.form.submit();">Confirm</button>
              <button class="btn btn-default modal-dismiss">Cancel</button>
            </div>
          </div>
        </footer>
      </section>
    </form>
  </div>


<?php $x++; endforeach;endif;?>
<?php else:?>



<?php endif;?>

<script type="text/javascript">
  
  var EDIT_ID = 0;

  function show_add_new(){
    var show_edit_box = document.querySelector(".add_new");
    var category_input = document.querySelector("#newItem");
    
    if(show_edit_box.classList.contains("hide")){

      show_edit_box.classList.remove("hide");
      category_input.focus();
    }else{

      show_edit_box.classList.add("hide");
      category_input.value = "";
    }

  }

  function show_edit_category(id,category,parent,e){

    EDIT_ID = id;
    var show_add_box = document.querySelector(".edit_category");
    //show_add_box.style.left = (e.clientX - 700) + "px";
    show_add_box.style.top = (e.clientY - 100) + "px";

    var category_input = document.querySelector("#category_edit");
    category_input.value = category;

    var parent_input = document.querySelector("#parent_edit");
    parent_input.value = parent;
    
    if(show_add_box.classList.contains("hide")){

      show_add_box.classList.remove("hide");
      category_input.focus();
    }else{

      show_add_box.classList.add("hide");
      category_input.value = "";
    }


  }

  function collect_data(e){

    var item_input = document.querySelector("#newItem");
    if(item_input.value.trim() == "" || !isNaN(item_input.value.trim()))
    {
      alert("Please enter a valid item name");
    }

    var item = item_input.value.trim();

    send_data({
      item:item,
      client_id:<?=$company_info->id;?>,
      data_type:'add_category'
    });
  }
  
  function collect_edit_data(e){

    var category_input = document.querySelector("#category_edit");
    if(category_input.value.trim() == "" || !isNaN(category_input.value.trim()))
    {
      alert("Please enter a valid category name");
    }

    var parent_input = document.querySelector("#parent_edit");
    if(isNaN(parent_input.value.trim()))
    {
      alert("Please enter a valid category name");
    }

    var category = category_input.value.trim();
    var parent = parent_input.value.trim();

    send_data({
      id:EDIT_ID,
      category:category,
      parent:parent,
      data_type:'edit_category'
    });
  }

  function send_data(data = {}){
    var ajax = new XMLHttpRequest();

    ajax.addEventListener('readystatechange', function(){

      if(ajax.readyState == 4 && ajax.status == 200)
      {
        handle_result(ajax.responseText);
      }
    });

    ajax.open("POST","<?=ROOT?>ajax_item",true);
    ajax.send(JSON.stringify(data));
  }

  function handle_result(result){
    if(result != ""){
      var obj = JSON.parse(result);

      if(typeof obj.data_type != 'undefined')
      {

        if(obj.data_type == "add_new")
        {
          if(obj.message_type == "info")
          {
            alert(obj.message);

            show_add_new();

            var table_body = document.querySelector("#table_body");
            table_body.innerHTML = obj.data;
          }else
          {
            alert(obj.message);
          }
        }else
        if(obj.data_type == "edit_category")
        {

          show_edit_category(0,'','',false);

          var table_body = document.querySelector("#table_body");
          table_body.innerHTML = obj.data;

        }else
        if(obj.data_type == "disable_row")
        {

          var table_body = document.querySelector("#table_body");
          table_body.innerHTML = obj.data;

        }else
        if(obj.data_type == "delete_row")
        {

          var table_body = document.querySelector("#table_body");
          table_body.innerHTML = obj.data;

          alert(obj.message);
        }


      }
    }
  }

  function edit_row(id){

    send_data({
      data_type: ""
    });
  }

  function delete_row(id){

    if(!confirm("Are you sure you want to delete this row?"))
    {
      return;
    }

    send_data({
      data_type: "delete_row",
      id:id
    });
  }

  function disable_row(id,state){
    send_data({
      data_type: "disable_row",
      id:id,
      current_state:state,
    });
  }
</script>
