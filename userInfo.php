<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    if ($db->connect_error) {
          http_response_code(500);
          die('{ "errMessage": "Failed to Connect to DB." }');
    }

    $name = $_POST['username']; 
    $query = "SELECT UserName, email FROM WebUser WHERE UserName = '$name';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($username, $email);
    $stmt->fetch();
    //SELECT ServerName FROM Server s JOIN ServerMember sm ON s.ServerId = sm.ServerId JOIN WebUser wu ON wu.UserId = sm.UserId WHERE wu.UserName = '$username';";
    $query = "SELECT COUNT(*) FROM ServerMember sm JOIN WebUser wu ON wu.UserId = sm.UserId WHERE UserName = '$name';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($chatCount);
    $stmt->fetch();

    $query = "SELECT COUNT(*) FROM Server s JOIN ServerMember sm ON s.ServerId = sm.ServerId JOIN WebUser wu ON wu.UserId = sm.UserId WHERE wu.UserName = '$name';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($privateCount);
    $stmt->fetch();

    echo json_encode ();
?>
