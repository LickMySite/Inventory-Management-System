<table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
  <thead>
    <tr>           
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
          <td data-title="Item"><strong><a href="<?=ADMIN.'inventory/edit/'.$data->item_id;?>"><?=$data->item;?></a></strong></td>
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