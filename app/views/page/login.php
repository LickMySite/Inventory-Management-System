<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=isset($page) ? $page : 404;?></title>

  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

	<link rel="shortcut icon" href="<?=ASSETS?>img/logo.png" type="image/x-icon" />
  <link rel="apple-touch-icon" href="<?=ASSETS?>img/logo.png">

  <link rel="stylesheet" href="<?=ASSETS?>css/login.css">
  <link rel="stylesheet" href="<?=ASSETS?>css/custom.css">

</head>

<body>

		<main class="form-signin">

			<div class="sect">
				<a  href="<?=ROOT;?>">
					<img class="mb-4" src="<?=ASSETS;?>img/logo.png" alt="" width="64" height="64">
				</a>
				<h1 class="disable-select">LOG IN</h1>
			</div>
			<form method="post" id="form" novalidate>
			
				<input type="hidden" value="<?=createToken();?>" name="csrf_token">
				<?php if(isset($errors)):?>
					<div class="sect">
						<p class="err"><?php check_error();?></p>
					</div>
				<?php endif;?>

				<input type="email" name="email" id="email" placeholder="you@example.com" autocomplete="off" autofocus required pattern="(.+)@(.+){1,}\.(.+){2,}"/>

				<input type="password" name="password" placeholder="Password" id="password" autocomplete="off" required pattern="^(?=.*[A-Z\u00C0-\u00DF].*)(?=.*[0-9].*)(?=.*[a-z\u00E0-\u00FF].*).{8,}$"/>
					<button type="submit" class="success">Submit</button>
					<button disabled>Submit</button>        


			</form>

		</main>
			
  </body>
</html>

