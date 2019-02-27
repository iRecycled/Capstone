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
    $password = "random";

    $query = "SELECT email FROM WebUser WHERE UserName = '$username';";
    $stmt = simpleQuery($db, $query);

    $stmt->bind_result($email);
    $stmt->fetch();
    
    $query = "UPDATE WebUser SET Password='$password' WHERE UserName = '$username';";
    //runs query on the database
    $stmt = simpleQuery($db, $query);

    $msg = "Hi " . $username . ",\n\n Here is your new password:\n\n" . $password . 
        "\nPlease login and change your password to something you will remember immediately.";
    $subject = "TerryChat Password Reset"
    //send email to the user with the new password
    //mail('eamil','subject','message')
    mail($email,$subject,$msg);
    echo json_encode($email);
    //alert box to be created and displayed
    //<div class="alert alert-info alert-dismissible">
        //<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            //text
    //</div>    
?>