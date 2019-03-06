<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $username = strip_tags($_POST['username']); 
  $email = strip_tags($_POST['email']);
  $password = strip_tags($_POST['password']);

        // 2. Run the Query
        $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE email = '$email';";
        $stmt = simpleQuery($db, $query);
  
      	$stmt->bind_result($userIDTest, $usernameTest, $passwordTest, $emailTest);
        $stmt->fetch();

        if($emailTest == $email){
                $data = -2; //email is already taken
                
        }
        
        $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);
  
      	$stmt->bind_result($userIDTest, $usernameTest, $passwordTest, $emailTest);
        $stmt->fetch();

        if($usernameTest == $username){
                $data = -3; //username is already taken
                
        }

        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$username', '$password', '$email')";
	$stmt = simpleQuery($db, $query);
        if($stmt != NULL) {
                //added success
                $data=-1;
        }
      	
echo json_encode($data);
?>