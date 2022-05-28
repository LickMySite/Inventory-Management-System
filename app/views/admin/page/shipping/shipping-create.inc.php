<form id="shipAdd" method="POST" class="needs-validation" autocomplete="off">

<div class="form-group row pb-3">
  <label class="col-lg-1 control-label text-lg-end pt-2" for="po"><b>PO&num;</b></label>
  <div class="col-lg-6">
    <div class="input-group">
      <span class="input-group-text">
        <i class="fas fa-edit"></i>
      </span>
      <input type="text" name="po" class="form-control" id="po" value="<?=isset($_POST['po']) ? show_input($_POST['po']) : '';?>">
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
      <input type="text" name="container" class="form-control" id="container" value="<?=isset($_POST['container']) ? show_input($_POST['container']) : '';?>">
    </div>
  </div>
</div>

<div class="form-group row pb-4">
  <label class="col-lg-1 control-label text-lg-end pt-2"><b>Date</b></label>
  <div class="col-lg-6">
    <div class="input-group">
      <span class="input-group-text">
        <i class="fas fa-calendar-alt"></i>
      </span>
      <input type="text" name="date" data-plugin-datepicker data-plugin-masked-input data-input-mask="99-99-9999" placeholder="__-__-____" value="<?=isset($_POST['date']) ? show_input($_POST['date']) : date("m-d-Y");?>" class="form-control">
    </div>
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
  <tbody>
    <?php if(isset($table)):foreach($table as $data):?>


      <tr data-item-id="<?=$data->item_id;?>">

        <td><input type="tel" class="form-control" name="PCS" maxlength="4"></td>

        <td data-title="Shipped">
          <input type="tel" class="form-control" name="quantity[]" maxlength="4">
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


    <?php endforeach;endif;?>
  </tbody>
</table>
<input type="hidden" name="type" value="ship">
<input type="hidden" name="client_id" value="<?=$company_info->id;?>">
<button type="submit" class="btn btn-outline btn-rounded btn-success mb-2 text-uppercase font-weight-bold" data-loading-text="Loading..." onclick="this.disabled=true;this.form.submit();">Submit</button>
<button type="reset" class="btn btn-outline btn-rounded btn-primary mb-2 text-uppercase">Reset</button>

</form>
