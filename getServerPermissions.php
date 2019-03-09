<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $username = $_POST['username'];
        $serverID = $_POST['serverID'];
        // 2. Run the Query
        $query = "SELECT Permission FROM WebUser wu JOIN ServerMember sm ON wu.UserID = sm.UserID JOIN Server s ON s.ServerID = sm.ServerID WHERE wu.UserName = '$username' AND s.serverID = '$serverID';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($permission);
        $stmt->fetch();

        echo($permission);
?>