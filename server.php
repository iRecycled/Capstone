<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
  $servername = $_POST['newServerName']; 
  if($servername == NULL){
        include 'register.html';
  }
  else {
        $query = "INSERT INTO Server VALUES ((SELECT * FROM (SELECT COALESCE(MAX(ServerId)+1,0) FROM Server) as tmptable), '$servername')";
	$stmt = simpleQuery($db, $query);
        if($stmt == NULL) {
           include 'register.html';
        }
      	else{
            include 'profile_page.html';
        }
  }
?>