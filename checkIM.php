<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    if ($db->connect_error) {
        http_response_code(500);
        die('{ "errMessage": "Failed to Connect to DB." }');
    }
    $username = $_POST['username'];
    $friendUsername = $_POST['friendName'];
    // TODO find IM file that matches 2 users given and return the fileId
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

    $query = "SELECT FileId, User1ID, User2ID FROM InstantMessage";
    $stmt = simpleQuery($db, $query);
    //TODO loop through to see if any match both userID's
    // return -1 if it doesn't exist
?>