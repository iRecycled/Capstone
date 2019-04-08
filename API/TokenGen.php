<?php
include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        //connects to database
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $data = json_decode(file_get_contents("php://input"));
  $user = $data->$username;
  $TOK = password_hash(microtime(),PASSWORD_DEFAULT);
  $query = "UPDATE WebUser SET Token='$TOK' WHERE UserName = '$user'";
  $stmt = simpleQuery($db, $query);
  //Update Token FROM WebUser where UserName == $user
  echo json_encode( $TOK );
 ?>
