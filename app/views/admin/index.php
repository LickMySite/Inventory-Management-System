<main class="col-md-9 ms-sm-auto col-lg-10 p-2 px-md-4">

  <?php
    $page?
    $this->view($type?'admin/page' : "admin/page/$page",$data):
    $this->view(404);
  ?>
  
</main>