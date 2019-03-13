<?php
header("index.php");
        
  include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }

  $name = mysql_real_escape_string($_POST['user']);
  $pass = mysql_real_escape_string($_POST['pass']);

  //$query = "SELECT Password FROM WebUser WHERE UserName = '$name';";
  //$stmt2 = simpleQueryPassword($db, $query);
  
  //$query = "alter table WebUser modify column Password varchar(500) not null;";
  //$stmt = simpleQuery($db, $query);

        $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE UserName = '$name';";
        $stmt = simpleQuery($db, $query);
  //ALTER TABLE YourTable ALTER COLUMN YourColumn VARCHAR (500) NOT NULL;
      	$stmt->bind_result($userID, $username, $password, $email, $sessionID);
        $stmt->fetch();


        if(password_verify($pass,$password)){
          $bool2=true;
        }
        else{
          $bool2 = strcmp($pass,$password)==0;
        }
        
        $bool1 = strcmp($name,$username)==0;
        //$bool2 = strcmp($pass,$password)==0;
        //$bool1 && $bool2
        //$bool1 && $stmt2
  			if($bool1 && $bool2){
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