<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $username = $_POST['username']; 
  $email = $_POST['email'];
  $password = $_POST['password'];
        // 2. Run the Query
        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$username', '$password', '$email')";
	$stmt = simpleQuery($db, $query);
        if($stmt != NULL) {
                //added success
                $data=-1;
        }
      	else{
                //failure in insertion
                $data=-10;
        }
echo json_encode($data);
?>