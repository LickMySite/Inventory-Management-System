<?php if($type == "one"):?>
<div class="card-body">
  <div class="btn-group d-flex">
    <a class="btn btn-<?php echo ($page == "account") ? "success" : "default";?> w-25" href="<?=ADMIN;?>account/<?=isset($client_NAME) ? $client_NAME : '';?>"> Account</a>

    <a class="btn btn-<?php echo ($page == "users") ? "success" : "default";?> w-25" href="<?=ADMIN;?>users/<?=isset($client_NAME) ? $client_NAME : '';?>"> Users</a>

    <a class="btn btn-<?php echo ($page == "inventory") ? "success" : "default";?> w-100" href="<?=ADMIN;?>inventory/view/<?=isset($client_NAME) ? $client_NAME : '';?>">Inventory</a>

    <a class="btn btn-<?php echo ($page == "receiving") ? "success" : "default";?> w-100" href="<?=ADMIN;?>receiving/<?=isset($client_NAME) ? 'view/' .$client_NAME : '';?>">Receive</a>

    <a class="btn btn-<?= ($page == "shipping") ? "success" : "default";?> w-100" href="<?=ADMIN;?>shipping/<?=isset($client_NAME) ? $client_NAME : '';?>">Shipping</a>
  </div>
</div>
<?php endif;?>
