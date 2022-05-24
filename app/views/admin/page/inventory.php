<?php
$this->view("admin/includes/quick-links.inc",$data);
$this->view("admin/includes/error-msg.inc");
?>
<div class="row">
  <div class="col">
    <section class="card">
      <header class="card-header">
        <h2 class="card-title"><?=isset($company_info) ? ucwords($company_info->client_name).'&apos;s '.ucwords($page) : 'All '.ucwords($page)?></h2>
      </header>
      <div class="card-body">
        <?php
        isset($type) ? $this->view('admin/page/'.$page.'/'.$page.'-'.$type.'.inc',$data) : "";
        ?>

      </div>
    </section>
  </div>
</div>

