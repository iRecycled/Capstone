<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $name = $_POST['username']; 
  $oldpass = $_POST['oldPass'];
  $newpass = $_POST['newPass'];
  $checkpass = $_POST['confirmNewPass'];
        // 2. Run the Query
  //SELECT username, password, money FROM logins WHERE username = '$username';
        $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$name';";
        $stmt = simpleQuery($db, $query);
  
        if($stmt == NULL) {

        				  }
 		 else{
      		$stmt->bind_result($userID, $username, $password, $email);
        $stmt->fetch();
  			if(strcmp($oldpass,$password)==0){
              if(strcmp($newpass,$checkpass)==0){
                $query2 = "UPDATE WebUser SET Password='$newpass' WHERE UserName = '$username';";
                $stmt2 = simpleQuery($db, $query2);
                if($stmt2 == NULL) {
                    
                                  }
                  else{
                      
                  }
              }
   			 }
           else{
             include "register.html";
           }
         }
  }
  else {
    include "login.html";
  }
?>
