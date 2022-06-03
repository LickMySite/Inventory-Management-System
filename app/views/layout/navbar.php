
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?=ROOT;?>">IMS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link<?=(isset($page) && $page == "home") ? ' active" aria-current="page"':''; ?>" aria-current="page" href="<?=ROOT;?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?=(isset($page) && $page == "about") ? ' active" aria-current="page"':''; ?>" href="<?=ROOT;?>about/">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?=(isset($page) && $page == "contact") ? ' active" aria-current="page"':''; ?>" href="<?=ROOT;?>contact/">Contact</a>
          </li>
          <?php if(!Auth::logged_in()):?>
            <li class="nav-item">
              <a class="nav-link<?=(isset($page) && $page == "signup") ? ' active" aria-current="page"':''; ?>" href="<?=ROOT;?>signup/">Signup</a>
            </li>
            <li class="nav-item">
              <a class="nav-link<?=(isset($page) && $page == "login") ? ' active" aria-current="page"':''; ?>" href="<?=ROOT;?>login/">Login</a>
            </li>
          <?php else:?>
            <li class="nav-item">
              <a class="nav-link" href="<?=ROOT;?>logout/">Logout</a>
            </li>
          <?php endif;?>

        </ul>
      </div>
    </div>
  </nav> 
</header>
