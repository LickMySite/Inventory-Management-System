<?php if($master === true):?>
  <a class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4 m-4" href="<?=ADMIN;?>account/create/">Create Account</a>
<?php endif;?>

<div class="row">
  <div class="col-lg">
    <div class="tabs tabs-vertical tabs-left">
      <ul class="nav nav-tabs">
        <?php foreach($client_stats as $client):?>
          <li class="nav-item border<?php if($client->id == $client_id){ echo " active"; }?>">
            <a class="nav-link" data-bs-target="#client_<?=$client->id;?>" href="#client_<?=$client->id;?>" data-bs-toggle="tab"> <strong><?=$client->client_name;?></strong></a>
          </li>
        <?php endforeach;?>
      </ul>

      <div class="tab-content">

        <?php foreach($client_stats as $client):?>

          <div id="client_<?=$client->id;?>" class="tab-pane<?php if($client->id == $client_id){ echo " active "; }?>">

            <h3><?=$client->fullname;?></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitat.</p>
            <a class="btn btn-lg btn-default m-2" href="<?=ROOT.ADMIN;?>/account/<?=$client->client_name;?>">Edit Account</a>

            <div class="col-lg col-xl">
              <h5 class="font-weight-semibold text-dark text-uppercase mb-3 mt-3">Client Details</h5>
              <p>Name: <?=$client->client_name;?></p>
              <p>Date: <?=$client->date;?></p>
            </div>
          </div>
        <?php endforeach;?>

      </div>

    </div>
  </div>
</div>
