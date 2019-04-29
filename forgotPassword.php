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
    $status = 0;

    $url = "http://144.13.22.48/CS458SP19/Team1/Capstone/passwordReset.html?name=";
 
    //checks to see if user is logged in
    if($username === "") {
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
                $url .= urlencode($username);

                $msg = "Hi " . $username . ",\n\n Follow this link to reset your password.\n\n" .
                    $url . "\n\nIf you did not request a password reset ignore this email and DO NOT follow the link.";
                $subject = "TerryChat Password Reset";
                //send email to the user with the new password
                mail($email,$subject,$msg);
                // sends back 1 if email sent
                $status = 1;
                break;
            }
            else {
                // sends back 0 if no match found
                $status = 0;
            }
        }
    }
    else {
        //query to grab the email
        $query = "SELECT email FROM WebUser WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($email);
        $stmt->fetch();
        
        $url.= urlencode($username);

        $msg = "Hi " . $username . ",\n\n Follow this link to reset your password.\n\n" . 
            $url . "\n\nIf you did not request a password reset ignore this email and DO NOT follow the link.";

        $subject = "TerryChat Password Reset";
        //send email to the user with the new password
        mail($email,$subject,$msg);
        $status = 1;
    }
    echo json_encode($status);
?>