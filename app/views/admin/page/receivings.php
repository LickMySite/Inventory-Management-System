<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2"><?=ucfirst($page);?> Page</h1>
  <p>This is the <?=ucfirst($page);?> page</p>
</div>
<?php if($master === true && $type === "one"):?>
  <a class="btn btn-dark btn-md font-weight-semibold btn-py-2 px-4 mb-4" href="<?=ADMIN.$page;?>/view/">All <?=ucwords($page);?></a>
<?php endif;?>

<div class="row">
  <div class="col">
    <section class="card">
      <header class="card-header">
        <h2 class="card-title"><?=isset($client_NAME) ? ucwords($client_NAME).'&apos;s' : 'All'?> <?=ucwords($page);?></h2>
      </header>
      
      <?php
        $this->view("admin/includes/quick-links.inc",$data);
        $this->view("admin/includes/error-msg.inc");
      ?>

      <div class="card-body">

        <?php isset($type) ? $this->view('admin/page/'.$page.'/'.$page.'-'.$type.'.inc',$data) : "";?>

      </div>
    </section>
  </div>
</div>