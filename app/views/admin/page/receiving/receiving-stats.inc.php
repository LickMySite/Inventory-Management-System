<?php if($master === true):?>
  <a class="btn btn-dark btn-md font-weight-semibold btn-py-2 px-4 mb-4" href="<?=ADMIN.$page.'/add/';?>">Create <?=ucwords($page);?></a>
<?php endif;?>


  <?php if(isset($table)):?>
    <?=$table;?>
  <?php endif;?>

