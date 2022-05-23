<div class="container">
  <div class="col">
    <div class="row m-4 text-center">
      <h1>Login Page</h1>
    </div>
    
		<form method="post" id="form" novalidate>
		
			<input type="hidden" value="<?=createToken();?>" name="csrf_token">
			<?php if(isset($errors)):?>
				<div class="sect">
					<p class="error"><?php check_error();?></p>
				</div>
			<?php endif;?>

			<input type="email" name="email" id="email" placeholder="Email Address" autocomplete="off" autofocus required pattern="(.+)@(.+){1,}\.(.+){2,}"/>

			<input type="password" name="password" placeholder="Password" id="password" autocomplete="off" required pattern="^(?=.*[A-Z\u00C0-\u00DF].*)(?=.*[0-9].*)(?=.*[a-z\u00E0-\u00FF].*).{8,}$"/>

			<button type="submit" class="red">Submit</button>
			<button disabled>Submit</button>        

		</form>
  </div>
</div>