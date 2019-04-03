<?php
  $TOK = password_hash(microtime(),PASSWORD_DEFAULT);
  echo json_encode( $TOK );
 ?>
