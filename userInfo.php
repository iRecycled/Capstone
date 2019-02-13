<?php
    //----TODO-------
    //create queries to pull user's info (username, email, # of servers owned, # of chats participated in)
    //display the info in the correct location in the table
    //populate the sidebar with server names
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    if ($db->connect_error) {
        http_response_code(500);
        die('{ "errMessage": "Failed to Connect to DB." }');
    }
    //the name of the user logged in
    $name = "";
    //query for basic user info
    $queryInfo = "SELECT UserID, UserName, email FROM WebUser WHERE UserName = '$name';";
    $stmtInfo = simpleQuery($db, $queryInfo);
    
    $stmtInfo->bind_result($id, $username, $email);
    $stmtInfo->fetch();
    //query for number of private servers owned
    $queryPrivateCount = "SELECT COUNT(*), ServerName FROM Server WHERE UserID ='$id';";//doesnt match table right now
    $stmtPrivateCount = simpleQuery($db, $queryPrivateCount);
    $stmtPrivateCount->bind_result($privateServerCount, $serverNames);
    //needs to be in a loop
    $stmtPrivateCount->fetch();
    //query for total number of chats participated in
    $queryCount = "SELECT COUNT(*) FROM ServerMember WHERE UserID = '$id';";
    $stmtCount = simpleQuery($db, $queryCount);
    $stmtCount->bind_result($totalChatCount);
    $stmtCount->fetch();
    //fill table with information
    $privateServerCount = 0;
    $totalChatCount = 0;

?>
