<?php
    header("index.php");
    include "database.php";
    
    
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $name = $_POST['username'];//need that value
        $oldPass = $_POST['oldPass']; 
        $newPass = $_POST['newPass'];
        $confirmPass = $_POST['confirmNewPass';]
  
        // 2. Run the Query
        $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$name';";
        $stmt = simpleQuery($db, $query);

    	$stmt->bind_result($userID, $username, $password, $email);
		$stmt->fetch();
  		if(strcmp($oldPass,$password)==0){
  	        if(strcmp($newPass,$confirmPass)==0){
                //insert new password into database with an update
                //Query not set up yet
                $query = "UPDATE WebUser SET Password='$newPass' WHERE UserName = '$name';";
                $stmt = simpleQuery($db, $query);
                if($stmt != NULL){
                    //send alert that the change password was accepted
                }               
            }
            else{
                //display an error message in the modal
                $error = "Your new passord must match";
            }
		}
        else{
            //display an error message in the modal
            $error = "Your old password is incorrect"
        }
    echo json_encode($error);
?>
