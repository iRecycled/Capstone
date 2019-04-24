<?php
      include "database.php";
      $db = connectToDatabase(DBDeets::DB_NAME);
      //connects to the database
      if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
      }
      //gets information from the ajax call
      $username = $_POST['username']; 
      $password = $_POST['password'];
      $newPassword = $_POST['newPassword'];
      $confirmNewPassword = $_POST['confirmNewPassword'];
      
      $query = "SELECT Password FROM WebUser WHERE UserName = '$username';";
      //runs query on the database
      $stmt = simpleQuery($db, $query);
      
      //if statement success
      if($stmt != NULL) {
            //bind query results to variables
            $stmt->bind_result($currentPassword);
            $stmt->fetch();
            //check if passwords match
                  
            if(password_verify($password,$currentPassword)){
                  $bool2=true;
            }
            else{
                  $bool2 = strcmp($password,$currentPassword)==0;
            }
            if($bool2){
                  if($newPassword == $confirmNewPassword){
                        $newPassword=password_hash($newPassword, PASSWORD_DEFAULT);
                        $query2 = "UPDATE WebUser SET Password='$newPassword' WHERE UserName = '$username';";
                        $stmt2 = simpleQuery($db, $query2);
                        $status = 1;
                  }
                  else{
                        $status = 0;
                  }
            }
            else{
                  $status = 0;
            }
      }
      echo json_encode($status);
?>
