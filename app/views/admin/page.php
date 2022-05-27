<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2"><?=ucfirst($page);?> Page</h1>
  <p>This is the <?=ucfirst($page);?> page</p>
</div>
  
<div class="row">
  <div class="col">
    <section class="card">
      <header class="card-header">
        <h2 class="card-title"><?=isset($url_client_NAME) ? ucwords($url_client_NAME).'&apos;s '.ucwords($page) : 'All '.ucwords($page)?></h2>
      </header>
      <div class="card-body">

        <?php
          $this->view("admin/includes/quick-links.inc",$data);
          $this->view("admin/includes/error-msg.inc");
          $this->view('admin/page/'.$page.'/'.$page.'-'.$type.'.inc',$data);
        ?>

      </div>
    </section>
  </div>
</div>
