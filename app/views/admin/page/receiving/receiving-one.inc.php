<style type="text/css">

  .edit_category{
    /* width: 500px;
    height:450px; */
    background-color: #eae8e8;
    box-shadow: 0px 0px 10px #aaa;
    /* position: absolute;
    padding: 6px;
    z-index: 1; */
  }

  .show{
    display: block;
  }

  .hide{
    display: none;
  }
</style>

<table class="table table-bordered table-striped table-hover mb-0" id="datatable-default">
  <thead>
    <tr>
    <th width="5%">ID</th>

    <th width="5%">QTY</th>
    <th width="35%">Item</th>
    <th width="10%">PO</th>
    <th width="10%">Container</th>
    <th width="10%">Date</th>
    <th width="10%">Action</th>

  </thead>
  <tbody id="table_body">

    <?php if(isset($tbl_rows)):?>
      <?=$tbl_rows?>

      <?php endif;?>

  </tbody>
</table>

<!--edit category-->
<div class="edit_category hide" >
  <section class="card">
    <div class="card-header">
      <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Category</h4>
    </div>
    <form class="form-horizontal style-form" method="post">
      <div class="card-body">
      <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Qty:</label>
          <div class="col-sm-10">
            <input id="category_edit" name="qty" type="text" class="form-control" autofocus>
          </div>
        </div>
        <br><br style="clear: both;"><br>
      </div>
      <div class="card-footer">
        <button type="button" class="btn btn-danger" onclick="show_edit_category(0,event,'')">Cancel</button>
        <button type="button" class="btn btn-success" onclick="collect_edit_data(event)">Save</button>
      </div>
    </form>
  </section>  
</div>
<!--edit category end-->


<script type="text/javascript">
  
  var EDIT_ID = 0;

  function show_add_new(){
    var show_edit_box = document.querySelector(".add_new");
    var category_input = document.querySelector("#category");
    
    if(show_edit_box.classList.contains("hide")){

      show_edit_box.classList.remove("hide");
      category_input.focus();
    }else{

      show_edit_box.classList.add("hide");
      category_input.value = "";
    }

  }

  function show_edit_category(id,category,e){

    EDIT_ID = id;
    var show_add_box = document.querySelector(".edit_category");
    //show_add_box.style.left = (e.clientX - 700) + "px";
    show_add_box.style.top = (e.clientY - 100) + "px";

    var category_input = document.querySelector("#category_edit");
    category_input.value = e;

    // var parent_input = document.querySelector("#parent_edit");
    // parent_input.value = parent;
    
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

    // var parent_input = document.querySelector("#parent_edit");
    // if(isNaN(parent_input.value.trim()))
    // {
    //   alert("Please enter a valid category name");
    // }

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

    if(result != ""){    alert(result);
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



<!-- DELETE ME -->
<?php if(isset($table)):foreach($table as $data):?>

  <tr data-item-id="<?=$data->rec_id;?>">
    <td><?=$data->qty_rec;?></td>
    <td data-title="Item"><a class="modal-with-form" href="#editItem_<?=$data->item_id;?>"><strong><?=$data->item;?></strong></a></td>
    <td><?=$data->po;?></td>
    <td><?=$data->container;?></td>
    <td><?=date("M jS, Y",strtotime($data->date));?></td>
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


<?php endforeach;endif;?>

