<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    //connects to the database
    if ($db->connect_error) {
          http_response_code(500);
          die('{ "errMessage": "Failed to Connect to DB." }');
    }
    $username = $_POST['username']; 

    //randomly set password for the user to change
    $length = 8;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }

    //checks to see if user is logged in
    if($username == "oheystopmesingaround") {
        // if not logged in must check to see if email input macthes an account in the DB
        $emailInput = $_POST['email'];

        $query = "SELECT UserName, email FROM WebUser;";
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($usernameList, $email);
        while($stmt->fetch()) {
            if($emailInput == $email) {
                $username = $usernameList;
                //query that updates the password
                $query = "UPDATE WebUser SET Password='$password' WHERE UserName = '$username';";
                $stmt = simpleQuery($db, $query);

                $msg = "Hi " . $username . ",\n\n Here is your new password:\n\n" . $password . 
                    "\n\nPlease login and change your password to something you will remember immediately.";
                $subject = "TerryChat Password Reset";
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
        $query = "UPDATE WebUser SET Password='$password' WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);

        $msg = "Hi " . $username . ",\n\n Here is your new password:\n\n" . $password . 
            "\n\nPlease login and change your password to something you will remember immediately.";
        $subject = "TerryChat Password Reset";
        //send email to the user with the new password
        mail($email,$subject,$msg);
    }
?>