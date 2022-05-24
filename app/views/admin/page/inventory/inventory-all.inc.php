<table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
  <thead>
    <tr>
    <?= ($master === true && !isset($company_info)) ? '<th width="17%">Company</th>' : '';?>
    
    <th>Item</th>
    <th class="d-none d-lg-block">Per</th>
    <th>Begin</th>
    <th>Received</th>
    <th>Shipped</th>
    <th>Finish</th>
  </thead>
  <tbody>
    <?php if(isset($table)):?>
      <?php foreach($table as $data):?>
        <tr data-item-id="<?=$data->item_id;?>">
          <?= ($master === true && !isset($company_info)) ? '<td><a href="'.ADMIN.'inventory/'.$data->client_name.'"><strong>'.$data->client_name.'</strong></a></td>' : '';?>
          <td data-title="Item"><?=$data->item;?></strong></td>
          <td class="d-none d-lg-block"><?=$data->per;?></td>
          <td><?=$data->begin;?></td>
          <td><?=$data->rec;?></td>
          <td><?=$data->ship;?></td>
          <td class="<?php if($data->finish < 0){ echo 'danger';}?> text-end"><?=$data->finish;?></td>
        </tr>

      <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>