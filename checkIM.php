<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    if ($db->connect_error) {
        http_response_code(500);
        die('{ "errMessage": "Failed to Connect to DB." }');
    }
    $username = $_POST['username'];
    $friendUsername = $_POST['friendName'];

    // Selects the ID of user logged in
    $query = "SELECT UserId FROM WebUser WHERE UserName = '$username'";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($firstUserID);
    $stmt->fetch();
    // Selects the ID of the selected friend
    $query = "SELECT UserId FROM WebUser WHERE UserName = '$friendUsername'";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($secondUserID);
    $stmt->fetch();

    $query = "SELECT * FROM InstantMessage";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($user1, $user2, $fileName)

    while($stmt->fetch()) {
        if(($firstUserID == $user1 || $firstUserID == $user2) && ($secondUserID == $user1 || $secondUserID == $user2)) {
            $status = $fileName;
            break;
        }
        else {
            $status = -1;
        }
    }
    echo json_encode($status);
?>