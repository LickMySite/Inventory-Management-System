<h1>edit ITEM</h1>

<form method="post" id="form" novalidate>
<input type="text" value="edit" name="type">
<input type="text" value="<?=$item->item_id;?>" name="item_id">
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Name&colon; <?=$item->item;?></label>
    <input type="text" name="item" class="form-control" id="exampleFormControlInput1" placeholder="<?=$item->item;?>" required>
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Type&colon; <?=$item->type;?></label>
    <input type="text" name="types" class="form-control" id="exampleFormControlInput1" placeholder="<?=$item->type;?>" value="<?=$item->type;?>">
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Per&colon; <?=$item->per;?></label>
    <input type="text" name="per" class="form-control" id="exampleFormControlInput1" placeholder="<?=$item->per;?>" value="<?=$item->per;?>">
  </div>
  <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Begin&colon; <?=$item->begin;?></label>
    <input type="text" name="begin" class="form-control" id="exampleFormControlInput1" placeholder="<?=$item->begin;?>" value="<?=$item->begin;?>">
  </div>

  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Notes</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>

  <button type="submit" class="btn btn-outline-success">Edit</button>
</form>


<?=show($data);?>

<!-- [item] => stdClass Object
        (
            [item_id] => 141
            [type] => 
            [per] => 1
            [item] => fourth
            [begin] => 0
            [client_id] => 8
            [rate_id] => 
        ) -->