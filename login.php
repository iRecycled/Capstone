<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $name = $_POST['user']; 
  $pass = $_POST['pass'];
  
        // 2. Run the Query
  //SELECT username, password, money FROM logins WHERE username = '$username';
        $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$name';";
        $stmt = simpleQuery($db, $query);
  
        
      		$stmt->bind_result($userID, $username, $password, $email);
        $stmt->fetch();
  			if(strcmp($pass,$password)==0){
          $data=$userID;
          
  		    //success, loads chat
   			 }
           else{
            $data=-10;
             //edit html element to show error
   
           }
  echo json_encode($data);
?>