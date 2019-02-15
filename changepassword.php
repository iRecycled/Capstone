<?php
      include "database.php";
      $db = connectToDatabase(DBDeets::DB_NAME);
      if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
      }
      $username = $_POST['username']; 
      $password = $_POST['password'];
      $newPassword = $_POST['newPassword'];
      $confirmNewPassword = $_POST['confirmNewPassword'];

      $query = "SELECT Password FROM WebUser WHERE UserName = '$username';";
      $stmt = simpleQuery($db, $query);
  
      if($stmt != NULL) {
      	$stmt->bind_result($currentPassword);
            $stmt->fetch();
  		if(strcmp($password,$currentPassword)==0){
                  if(strcmp($newPassword,$confirmNewPassword)==0){
                        $query2 = "UPDATE WebUser SET Password='$newPassword' WHERE UserName = '$username';";
                        $stmt2 = simpleQuery($db, $query2);
                  }
   		}
            else{
                  include "register.html";
            }
      }
      else {
            include "login.html";
      }
?>
