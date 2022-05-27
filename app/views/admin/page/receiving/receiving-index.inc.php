<?php if($master === true):?>
  <a class="btn btn-dark btn-md font-weight-semibold btn-py-2 px-4 mb-4" href="<?=ADMIN.$page.'/view';?>">View All <?=ucwords($page);?></a>

  <div class="container">
    <div class="form-group row pb-3">
      <label class="col-lg-3 control-label text-lg-end pt-2">Add New Receiving</label>
      <div class="col-lg-6">
        <select data-plugin-selectTwo class="form-control populate" name="clientLink" id="Link">
          <?php foreach($client_list as $key => $value):?>
            <option value="<?=$value;?>"><?=$value;?></option>
          <?php endforeach;?>
        </select>
        <div class="btn-group">
          <button class="btn btn-outline-primary btn-md font-weight-semibold btn-py-2 px-4 " type="button"  onclick="this.disabled=true;gotos('view')">VIEW</button>
          <button class="btn btn-outline-primary btn-md font-weight-semibold btn-py-2 px-4 m-2" type="button" onclick="this.disabled=true;gotos('add')">ADD</button>
        </div>
      </div>
    </div>
  </div>

<?php endif;?>
     
<script>
  function gotos(type) {
    var e = document.getElementById('Link');
    var value = e.options[e.selectedIndex].value;
    if (type == "view" || type == "add"){
      document.location.assign("<?=ADMIN;?>receiving/" + type + "/" + e.value)
    }
  }
</script>