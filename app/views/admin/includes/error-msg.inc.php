<?php

if(!empty($_SESSION['error'])):
  echo '<div class="status alert alert-danger"><p>';
  check_error();
  echo '</p></div>';

elseif(!empty($_SESSION['msg'])): 
  echo '<div class="status alert alert-info" ><p>';
  check_msg();
  echo '</p></div>';
endif;
