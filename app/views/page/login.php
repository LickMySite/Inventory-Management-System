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

	<style>
		html,
		body {
			background:#EBECF0
		}

		body {
			display: flex;
			justify-content: center;  

			align-items: center;
			padding-top: 2em;
			padding-bottom: 40px;
		}

		.form-signin {
			width: 100%;
			max-width: 20em;
			padding: 1em;
			margin: 0 auto;
		}

		.form-signin .form-floating:focus-within {
			z-index: 2;
		}
		
		.form-signin input[type="email"] {
			margin-bottom: -0.5em;
			border-bottom-right-radius: 8em;
			border-bottom-left-radius: 8em;
			
		}

		.form-signin input[type="password"] {
			margin-bottom: 1em;
			border-top-left-radius: 8em;
			border-top-right-radius: 8em;
		}

		body, p, input, button {
			font-family: "Montserrat", sans-serif;
			letter-spacing: -0.2px;

		}

		form *:invalid ~ button {
			pointer-events: none;
		}


		form *:invalid ~ button {
			background: whitesmoke;
			color: #ccc;
			cursor: default;
		}

		div, p {
			color: #cbcbcb;
			text-shadow: 1px 1px 1px #FFF;
		}
		
		button, input {
			border: 0;
			outline: 0;
			font-size: 1em;
			margin-top: 1em;
			border-radius: 20em;
			padding: 1em;
			background: #EBECF0;
			text-shadow: 1px 1px 0 #FFF;
		}

		input {
			box-shadow: inset 2px 2px 5px #BABECC, inset -5px -5px 10px #FFF;
			width: 100%;
			box-sizing: border-box;
			transition: all 0.2s ease-in-out;
			-webkit-appearance: none;
		}

		input:focus {
			box-shadow: inset 1px 1px 2px #BABECC, inset -1px -1px 2px #FFF;
		}

		button {
			color: #BABECC;
			width: 100%;
			font-weight: bold;
			box-shadow: -5px -5px 20px #FFF, 5px 5px 20px #BABECC;
			transition: all 0.2s ease-in-out;
			cursor: pointer;
			font-weight: 600;

		}
		button:hover {
			box-shadow: -2px -2px 5px #FFF, 2px 2px 5px #BABECC;
		}
		button:active {
			box-shadow: inset 1px 1px 2px #BABECC, inset -1px -1px 2px #FFF;
		}
		button.success {
			display: block;
			color:hsl(145, 40%, 50%);
		}

		button[disabled],
		form input:invalid ~ button:not([disabled]) {
			display: none;
		}

		button:not([disabled]),
		form input:invalid ~ button[disabled] {
			display: inline-block;
		}

		.sect {
			text-align: center;
		}

		.err{
			color: #ae1100;
		}

		.disable-select {
			user-select: none; /* supported by Chrome and Opera */
		-webkit-user-select: none; /* Safari */
		-khtml-user-select: none; /* Konqueror HTML */
		-moz-user-select: none; /* Firefox */
		-ms-user-select: none; /* Internet Explorer/Edge */
		}

	</style>



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

