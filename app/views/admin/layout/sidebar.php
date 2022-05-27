<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <span class="fs-4">Menu</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
		<li class="nav-item">
			<a class="nav-link active" aria-current="page" href="<?=ADMIN;?>">Home</a>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				Manage Inventory
			</a>
			<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
				<li><a class="dropdown-item" href="<?=ADMIN?>inventory/">Inventory</a></li>
				<li><hr class="dropdown-divider"></li>
				<li><a class="dropdown-item" href="<?=ADMIN?>receiving/">Receiving</a></li>
				<li><a class="dropdown-item" href="<?=ADMIN?>shipping/">Shipping</a></li>
			</ul>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?=ADMIN;?>users/">Users</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?=ADMIN;?>account/">Accounts</a>
		</li>
		<li class="nav-item">
		<a class="nav-link" href="<?=ADMIN;?>settings/">Settings</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?=ADMIN;?>logout/">Logout</a>
		</li>
  </ul>
</div>
<div class="b-example-divider"></div>