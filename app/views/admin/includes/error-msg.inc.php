<?php

if(isset($_SESSION['error'])):
  echo '<div class="status alert alert-danger"><p>';
  echo check_error();
  echo '</p></div>';

elseif(isset($_SESSION['msg'])): 
  echo '<div class="status alert alert-info" ><p>';
  echo check_msg();
  echo '</p></div>';
endif;
