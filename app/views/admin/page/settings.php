<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2"><?=ucfirst($page);?> Page</h1>
  <p>This is the <?=ucfirst($page);?> page</p>
</div>


<?php if(isset($data['saved'])):?>
	<div class="status alert alert-success"><?=$data['saved']?>
	</div>
		<a href="<?=ADMIN;?>settings">
			<input type="button" class="btn btn-outline btn-rounded btn-primary mt-8 text-uppercase font-weight-bold" value="Go Back">
		</a>
<?php endif;?>


<?php if(!isset($data['saved'])):?>
	<form method="post" enctype="multipart/form-data">

		<div class="card mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col">

						<?php if(isset($settings) && is_array($settings)):?>
							<?php foreach($settings as $setting):?>
								<div class="input-group mb-3">
									<span class="input-group-text" id="inputGroup-sizing-default"><?=ucwords(str_replace("_", " ", $setting->setting))?></span>
									<input type="<?=isset($setting->type) ? $setting->type:'text';?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="<?=ucwords(str_replace("_", " ", $setting->setting))?>" name="<?=$setting->setting?>" class="form-control" type="<?=$setting->setting?>" value="<?=$setting->value?>">
								</div>

							<?php endforeach;?>
						<?php endif;?>

						<hr class="solid my-3">
						<input type="submit" value="Save Settings" class="btn btn-outline btn-rounded btn-success mb-2 text-uppercase font-weight-bold" >
						<input type="reset" value="Reset" class="btn btn-outline btn-rounded btn-primary mb-2 text-uppercase" >

					</div>
				</div>
			</div>
		</div>
	</form>
<?php endif;?>
