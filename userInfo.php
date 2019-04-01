<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    if ($db->connect_error) {
          http_response_code(500);
          die('{ "errMessage": "Failed to Connect to DB." }');
    }

    $name = $_POST['username']; 
    //Gets information relating to the user
    $query = "SELECT UserID, UserName, email, Avatar FROM WebUser WHERE UserName = '$name';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($userID, $username, $email, $avatar);
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

    //Counts the number of friends the user has
    $query = "SELECT COUNT(*) FROM Friend JOIN WebUser w2 ON Friend.Friend1ID = w2.UserID OR Friend.Friend2ID = w2.UserID WHERE w2.UserID = '$userID';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($friendCount);
    $stmt->fetch();

    echo "{";
    ?>
        "name": <?=json_encode($username)?>,
        "email": <?=json_encode($email)?>,
        "chatCount": <?=json_encode($chatCount)?>,
        "privateCount": <?=json_encode($privateCount)?>,
        "friendsCount": <?=json_encode($friendCount)?>,
        "avatar": <?=json_encode($avatar)?>
    <?php
    echo "}";
?>
