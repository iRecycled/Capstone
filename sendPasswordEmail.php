<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    //connects to the database
    if ($db->connect_error) {
          http_response_code(500);
          die('{ "errMessage": "Failed to Connect to DB." }');
    }
    // grabs data from user
    $username = $_POST['username'];
    //randomly set password for the user to change
    $length = 8;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $password = '';
    $url = "http://144.13.22.48/CS458SP19/Team1/Capstone/passwordReset.html";
    // randomly selects 8 characters for the new password
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }
    //checks to see if user is logged in
    if($username == "") {
        // grabs data from user input
        $emailInput = $_POST['email'];
        // grabs all usernames and corresponding emails
        $query = "SELECT UserName, email FROM WebUser;";
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($usernameList, $email);
        // if not logged in must check to see if email input macthes an account in the DB
        while($stmt->fetch()) {
            if($emailInput == $email) {
                $username = $usernameList;
                //query that updates the password
                $passwordHash=password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE WebUser SET Password='$passwordHash' WHERE UserName = '$username';";
                $stmt = simpleQuery($db, $query);
                $msg = "Hi " . $username . ",\n\n Here is your reset password code:\n\n" . $password . 
                    "\n\nUse this code as your old password to finish your password reset.";
                //send email to the user with the new password
                mail($email,$subject,$msg);
                break;
            }
        }
    }
    else {
        //query to grab the email
        $query = "SELECT email FROM WebUser WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($email);
        $stmt->fetch();
        
        //query that updates the password
        $passwordHash=password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE WebUser SET Password='$passwordHash' WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);
        $msg = "Hi " . $username . ",\n\n Here is your reset password code:\n\n" . $password . 
            "\n\nUse this code as your old password to finish your password reset.";
        $subject = "TerryChat Password Reset";
        //send email to the user with the new password
        mail($email,$subject,$msg);
    }
?>