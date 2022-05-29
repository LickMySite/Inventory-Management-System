<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse nav-main">
	<div class="position-sticky d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link<?=(isset($page) && $page == "home") ? ' active" aria-current="page':''; ?>"  href="<?=ADMIN;?>">
					<i class="fas fa-warehouse" aria-hidden="true"></i>
					<span> Dashboard</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link<?=(isset($page) && $page == "inventory") ? ' active" aria-current="page"':''; ?>" href="<?=ADMIN;?>inventory/">
				<i class="fa fa-clipboard-list" aria-hidden="true"></i>
					<span>Inventory</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link<?=(isset($page) && $page == "receiving") ? ' active" aria-current="page"':''; ?>" href="<?=ADMIN;?>receiving/">
				<i class="fas fa-box-open" aria-hidden="true"></i>
					<span>Receiving</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link<?=(isset($page) && $page == "shipping") ? ' active" aria-current="page"':''; ?>" href="<?=ADMIN;?>shipping/">
				<i class="fas fa-truck" aria-hidden="true"></i>
					<span>Shipping</span>
				</a>
			</li>
		</ul>

		<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
			<span>Saved reports</span>
			<a class="link-secondary" href="#" aria-label="Add a new report">
				<span data-feather="plus-circle"></span>
			</a>
		</h6>
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link<?=(isset($page) && $page == "users") ? ' active" aria-current="page"':''; ?>" href="<?=ADMIN;?>users/">
				<i class="fas fa-users" aria-hidden="true"></i>
					<span>Users</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link<?=(isset($page) && $page == "account") ? ' active" aria-current="page"':''; ?>" href="<?=ADMIN;?>account/">
				<i class="fa fa-id-card" aria-hidden="true"></i>
					<span>Account</span>
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link<?=(isset($page) && $page == "settings") ? ' active" aria-current="page"':''; ?>" href="<?=ADMIN;?>settings/">
				<i class="fa fa-gears" aria-hidden="true"></i>
					<span>Settings</span>
				</a>
			</li>
		</ul>

		<hr>

    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?=ROOT.'uploads/avatar/'.$_SESSION['avatar'];?>" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong><?=$_SESSION['name'];?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        <li><a class="dropdown-item" href="<?=ADMIN;?>profile/"><i class="fa fa-user-circle"></i> Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="<?=ADMIN;?>logout/"><i class="fa fa-power-off"></i>  Sign out</a></li>
      </ul>
    </div>

	</div>
</nav>


