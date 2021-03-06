<?php
        //Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $username = $_POST['user']; 
        $serverName = $_POST['serverName'];
        $accept = $_POST['accept'];
        //Gets the id for the current user
        $query = "SELECT UserID FROM WebUser WHERE UserName = '$username';";
        $stmt = simpleQuery($db, $query);
   
        $stmt->bind_result($userID);
        $stmt->fetch();

        //Gets the id for the Server
        $query = "SELECT ServerID FROM Server WHERE ServerName = '$serverName';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($serverID);
        $stmt->fetch();

        //if the user accepts the request, create a row in ServerMember
        if($accept == "true") {
            $query = "INSERT INTO ServerMember VALUES ('$serverID', '$userID', '1');";
            $stmt = simpleQuery($db, $query);
        }

        $query = "DELETE FROM ServerInvite WHERE UserID = '$userID' AND ServerID =  '$serverID';";
        $stmt = simpleQuery($db, $query);
?>