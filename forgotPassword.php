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
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }
    
    $query = "SELECT email FROM WebUser WHERE UserName = '$username';";
    $stmt = simpleQuery($db, $query);

    $stmt->bind_result($email);
    $stmt->fetch();
    
    $query = "UPDATE WebUser SET Password='$password' WHERE UserName = '$username';";
    //runs query on the database
    $stmt = simpleQuery($db, $query);


    echo "{";
    ?>
        "name": <?=json_encode($username)?>,
        "email": <?=json_encode($email)?>,
        "newPassword": <?=json_encode($password)?>
    <?php
    echo "}";

    $msg = "Hi " . $username . ",\n\n Here is your new password:\n\n" . $password . 
        "\nPlease login and change your password to something you will remember immediately.";
    $subject = "TerryChat Password Reset"
    //send email to the user with the new password
    //mail('eamil','subject','message')
    mail($email,$subject,$msg);
    
    //alert box to be created and displayed
    //<div class="alert alert-info alert-dismissible">
        //<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            //text
    //</div>    
?>