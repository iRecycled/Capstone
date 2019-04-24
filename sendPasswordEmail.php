<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    //connects to the database
    if ($db->connect_error) {
        http_response_code(500);
        die('{ "errMessage": "Failed to Connect to DB." }');
    }
    //randomly set password for the user to change
    $length = 8;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $password = '';
    // randomly selects 8 characters for the new password
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }

    // grabs data from url
    $username =  $_GET["name"];

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
    //send email to the user with the new password
    mail($email,$subject,$msg);
?>