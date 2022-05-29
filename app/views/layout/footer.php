<footer class="footer mt-auto py-3 text-light">
  <div class="container-fluid">
    <div class="row bg-dark pb-2">
      <div class="col-lg-3 col-md-6 mt-2">
        <h4>What we do</h3>
        <p><?=Settings::website_description()?></p>
      </div>
      <div class="col-lg-3 col-md-6 mt-2">
        <h4>Quick Links</h4>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?=ROOT;?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=ROOT;?>about/">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=ROOT;?>contact/">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=ROOT;?>signup/">Signup</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=ROOT;?>login/">Login</a>
          </li>
        </ul>

      </div>
      <div class="col-lg-3 col-md-6 mt-2">
        <h4>Social</h4>
        <ul class="">
          <li><a href="https://www.youtube.com/<?=Settings::YouTube()?>" target="_blank" title="YouTube"><i class="fab fa-youtube text-2"></i></a></li>
          <li><a href="https://www.twitter.com/<?=Settings::Twitter()?>" target="_blank" title="Twitter"><i class="fab fa-twitter text-2"></i></a></li>
          <li><a href="https://www.linkedin.com/<?=Settings::linkedin()?>" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 mt-2">
        <h4>Contact</h4>
        <p><?=Settings::address()?></p>
        <p><?=Settings::email()?></p>
        <p><?=Settings::phone()?></p>
      </div>
    </div>
    <div class="row bg-primary">
      <span class="text-light"><?=Settings::copyright()?></span>
    </div>
  </div>
</footer>