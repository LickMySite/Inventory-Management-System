<?php

if(isset($errors)): echo
  '<div class="status alert alert-danger" >'
  .check_error().
  '</div>';

elseif(isset($_SESSION['msg'])): echo
  '<div class="status alert alert-info" ><p>hello'
  .check_msg().
  '</p></div>';

endif;
