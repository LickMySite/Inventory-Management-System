<body class="d-flex flex-column h-100">
  <div class="row">
    <div class="col-2">
      <?php $this->view("admin/layout/sidebar");?>
    </div>
    <div class="col">
      <?php $this->view($page? "admin/page/$page" :404,$data);?>
    </div>
    <div class="row">
      <?php $this->view("admin/layout/footer");?>
    </div>
  </div>
