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
        $emailCheck = "SELECT * FROM WebUser WHERE username='$username'";
        $mailResult = simpleQuery($db,$emailCheck);

        $usernameCheck = "SELECT * FROM WebUser WHERE password='$password'";
        $userResult = simpleQuery($db,$emailCheck);

        if($mailResult == NULL){
                $data = -2; //email already in use
        }
        else if($userResult == NULL)
        {
                $data = -3;//username already in use      
        }
        else { //if username and password dont exist then create user
                $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$username', '$password', '$email')";
	        $stmt = simpleQuery($db, $query);
        }

        

        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$username', '$password', '$email')";
	$stmt = simpleQuery($db, $query);
        if($stmt != NULL) {
                //added success
                $data=-1;
        }
      	else{
                //Advanced rest client (ARC)
                //failure in insertion
                $data=-10;
        }
echo json_encode($data);
?>