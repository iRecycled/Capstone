<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    if ($db->connect_error) {
          http_response_code(500);
          die('{ "errMessage": "Failed to Connect to DB." }');
    }

    $name = $_POST['username']; 
    //Gets information relating to the user
    $query = "SELECT UserName, email FROM WebUser WHERE UserName = '$name';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($username, $email);
    $stmt->fetch();
    //SELECT ServerName FROM Server s JOIN ServerMember sm ON s.ServerId = sm.ServerId JOIN WebUser wu ON wu.UserId = sm.UserId WHERE wu.UserName = '$username';";
    
    //Finds the number of public servers that the user belongs to
    $query = "SELECT COUNT(*) FROM ServerMember sm JOIN WebUser wu ON wu.UserId = sm.UserId WHERE UserName = '$name';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($chatCount);
    $stmt->fetch();

    //Finds the number of private servers that the user belongs to
    $query = "SELECT COUNT(*) FROM Server s JOIN ServerMember sm ON s.ServerId = sm.ServerId JOIN WebUser wu ON wu.UserId = sm.UserId WHERE wu.UserName = '$name';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($privateCount);
    $stmt->fetch();

    echo "{";
    ?>
        "name": <?=json_encode($username)?>,
        "email": <?=json_encode($email)?>,
        "chatCount": <?=json_encode($chatCount)?>,
        "privateCount": <?=json_encode($privateCount)?>
    <?php
    echo "}";
?>
