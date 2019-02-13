<?php
    header("index.php");
    include "database.php";
    
    if ( isset( $_POST['submit']) && (strlen( $_POST['oldPasswordInput'])!=0) && (strlen( $_POST['newPasswordInput'])!=0) && (strlen($_POST['confirmNewPasswordInput'])!=0) ) {
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
                $query = "UPDATE WebUser SET password='$newPass' WHERE UserName = '$name';";
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
    }
    else{
        //display message in modal
        $error="Ypu must enter something in every cell";
    }   
?>
