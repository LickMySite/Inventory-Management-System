<table class="table table-bordered table-striped table-hover mb-0" id="datatable-tabletools">
  <thead>
    <tr>
    <th width="5%">QTY</th>
    <th width="35%">Item</th>
    <th width="10%">PO</th>
    <th width="10%">Container</th>
    <th width="10%">Date</th>
  </thead>
  <tbody>

    <?php if(isset($table)):foreach($table as $data):?>

      <tr data-item-id="<?=$data->ship_id;?>">
        <td><?=$data->qty_ship;?></td>
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

  </tbody>
</table>