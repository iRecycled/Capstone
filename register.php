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

        //check if email is used
        $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$RegEmail';";
        $stmt = simpleQuery($db, $query);

        $stmt->bind_result($userIDCheck, $usernameCheck, $passwordCheck, $emailCheck);
        $stmt->fetch();

        if(strcmp($RegEmail,$emailCheck)==0){
                //they emails are the same (fail)
                $data = -5;
        }
        else {
                $data = -69;
        }
  
        //check if username is used
        /*
        $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$username';";
        $stmt->bind_result($userIDCheck, $usernameCheck, $passwordCheck, $emailCheck);
        $stmt->fetch();

        if(strcmp($username,$usernameCheck)==0){
                //they are the same (fail)
                $data = -6; //username value
        }
        */
        // 2. Run the Query
        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$RegUsername', '$RegPassword', '$RegEmail')";
        $stmt = simpleQuery($db, $query);
        
        if($stmt == NULL) {
           //if statment fails reload page
           $data = 0;
        }
      	else{
            //if statment succeeds go to login page
            include "home.php";
        }
echo json_encode($data);
?>