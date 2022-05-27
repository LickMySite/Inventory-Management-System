<!-- <body class="d-flex flex-column h-100">
<main role="main" class="flex-shrink-0"> -->
  <?php //$this->view("admin/layout/sidebar");?>
  <!-- <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 580px;"> -->
  <!-- </div>
</main> -->



<?php $this->view("admin/layout/header");?>

<div class="container-fluid">
  <div class="row">

    <?php $this->view("admin/layout/sidebar",$data);?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <?php $this->view($page? "admin/page/$page" :404,$data);?>


    </main>
  </div>
</div>
