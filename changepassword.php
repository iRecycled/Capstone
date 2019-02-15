<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(600);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $username = $_POST['username']; 
  $password = $_POST['password'];
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];

        $query = "SELECT Password FROM logins WHERE username = '$username';"
        $stmt = simpleQuery($db, $query);

            if($stmt == NULL) {
                  
                  $error = "this other error"
            }
 	      else{
      		$stmt->bind_result($currentPassword);
                  $stmt->fetch();
  			if(strcmp($currentPassword, $password)==0){
                        if(strcmp($newPassword,$confirmPassword)==0){
                              $query2 = "UPDATE WebUser SET Password='$newPassword' WHERE UserName = '$username';";
                              $stmt2 = simpleQuery($db, $query2);
                              if($stmt2 == NULL) {
                                    $error = "this error"
                              }
                              else{

                                    $error = "that error"
                              }
                        }
   			}
                  else{
                        
                        $error = "other error"
                        include "register.html";
                  }
            }
  }
  else {
    include "login.html";
  }
  echo json_encode($error);
?>
