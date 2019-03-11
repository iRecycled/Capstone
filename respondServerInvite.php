<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $data = 0;
        $username = $_POST['user']; 
        $serverID = $_POST['serverID'];
        $accept = $_POST['accept'];
        // 2. Run the Query
        $query = "SELECT UserID FROM WebUser WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userID);
        $stmt->fetch();

        if($accept = "true") {
            $query = "INSERT INTO ServerMember VALUES ('$serverID', '$userID', '1');";
            $stmt = simpleQuery($db, $query);
        }

        $query = "DELETE FROM ServerInvite WHERE UserID = '$userID' AND ServerID =  '$serverID';";
        $stmt = simpleQuery($db, $query);
?>