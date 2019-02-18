<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    if ($db->connect_error) {
          http_response_code(500);
          die('{ "errMessage": "Failed to Connect to DB." }');
    }

    $name = $_POST['username']; 
    $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$name';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($userID, $username, $password, $email);
    $stmt->fetch();

    echo json_encode ($stmt);
?>
