<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $data = 0;
        $username = strip_tags($_POST['username']); 
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $checkEmail = 0;
        // 2. Run the Query
        $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE email = '$email';";
        $stmt = simpleQuery($db, $query);
  
      	$stmt->bind_result($userIDTest, $usernameTest, $passwordTest, $emailTest);
        $stmt->fetch();

        if($emailTest == $email){
                $data = 0; //email is already taken
                $checkEmail = -2;
        }
        
        $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);
  
      	$stmt->bind_result($userIDTest, $usernameTest, $passwordTest, $emailTest, $SessionIDTest);
        $stmt->fetch();

        if($usernameTest == $username){
                $data = -3; //username is already taken
                if($checkEmail == -2){
                        $data = -5;
                }
        }
        $password=password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$username', '$password', '$email',null)";
	$stmt = simpleQuery($db, $query);
        if($stmt != NULL) {
                //added success
                $data=-1;
        }
echo json_encode($data);
?>