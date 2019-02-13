<?php
		include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $username = $_POST['username']; 
  
  $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);
  
      	$stmt->bind_result($userID, $username1, $password, $email);
    $stmt->fetch();
echo json_encode($userID);
?>