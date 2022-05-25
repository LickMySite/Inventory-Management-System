<body class="d-flex flex-column h-100">
  <!-- Begin page content -->
  <main role="main" class="container">

    <?php

    $this->view($page? "admin/page/$page" :404,$data);

    ?>


  </main>