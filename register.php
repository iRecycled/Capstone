<?php
	
header("index.php");

        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $RegUsername = $_POST['RegUsername']; 
  $RegEmail = $_POST['RegEmail'];
  $RegPassword = $_POST['RegPassword'];


        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$RegUsername', '$RegPassword', '$RegEmail')";
        $stmt = simpleQuery($db, $query);
        
        if($stmt == NULL) {
           //if statment fails reload page
           $data = 0;
        }
        else {
        $data = 1;
        }
      	
echo json_encode($data);
?>