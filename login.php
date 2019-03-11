<?php
header("index.php");
        // 1. Connect to the database
        include "databasePass.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $name = strip_tags($_POST['user']);
  $pass = strip_tags($_POST['pass']);
  //if($pass.strlen()==0){
  // $pass='oiergneirogne234ionefwinweof234'
  //}
  
        // 2. Run the Query
  //SELECT username, password, money FROM logins WHERE username = '$username';
        $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE UserName = '$name';";
        $stmt = simpleQuery($db, $query);
  
      	$stmt->bind_result($userID, $username, $password, $email, $sessionID);
        $stmt->fetch();

        $query = "SELECT Password FROM WebUser WHERE UserName = '$name';";
        $stmt2 = simpleQueryPassword($db, $query);
        
        $bool1 = strcmp($name,$username)==0;
        $bool2 = strcmp($pass,$password)==0;
  			if($bool1 && $stmt2){
          $rand=rand(1, 50000);
          $query = "UPDATE WebUser SET SessionID=$rand WHERE UserName = '$username';";
          $stmt = simpleQuery($db, $query);

          $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE UserName = '$name';";
          $stmt = simpleQuery($db, $query);
          $stmt->bind_result($userID, $username, $password, $email, $sessionID);
          $stmt->fetch();

          $data=$sessionID;
  		    //success, loads chat
   			 }
           else{
            $data=-10;
             //edit html element to show error
   
           }
  echo json_encode($data);
?>