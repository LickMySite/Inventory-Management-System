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

<table class="table table-bordered table-striped table-hover mb-0" id="datatable-tabletools">

  <?php if(isset($table)):?>
    <?=$table;?>
  <?php endif;?>

</table>

<a href="<?=ADMIN.$page.'/view/'.$url_client_NAME;?>" class="btn btn-dark btn-md font-weight-semibold btn-py-2 px-4 mb-4">All <?=ucwords($url_client_NAME);?>&apos;s Received</a>

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