<?php
      include "database.php";
      $db = connectToDatabase(DBDeets::DB_NAME);
      //connects to the database
      if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
      }
      $username = $_POST['username']; 
      $password = $_POST['password'];
      $newPassword = $_POST['newPassword'];
      $confirmNewPassword = $_POST['confirmNewPassword'];
      //gets information from the ajax call

      $query = "SELECT Password FROM WebUser WHERE UserName = '$username';";
      //runs query on the database
      $stmt = simpleQuery($db, $query);
  
      //if statement success
      if($stmt != NULL) {
            //bind query results to variables
      	$stmt->bind_result($currentPassword);
            $stmt->fetch();
            //check if passwords match
  		if(strcmp($password,$currentPassword)==0){
                  if(strcmp($newPassword,$confirmNewPassword)==0){
                        $query2 = "UPDATE WebUser SET Password='$newPassword' WHERE UserName = '$username';";
                        $stmt2 = simpleQuery($db, $query2);
                        echo '{"msg": "password changed successfully!';
                  }
                  else{
                        echo '{"msg": "failed to change password"}';
                  }
   		}
            else{
                  echo '{"msg": "failed to change password"}';
            }
      }
?>
