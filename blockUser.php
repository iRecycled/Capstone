<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $username = $_POST['user']; 
        $serverID = $_POST['serverID'];
        // 2. Run the Query
        $query = "SELECT UserID FROM WebUser WHERE username = '$username';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userID);
        $stmt->fetch();

        $query = "SELECT * FROM BlockedUser WHERE userID = '$userID' AND serverID = $serverID;";
        $result = $db->query($query);

        $alreadyExists = false;
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $alreadyExists = true;
        }

        if($alreadyExists == false) {
            $query = "DELETE FROM ServerMember WHERE serverID = '$serverID' AND UserID = '$userID';";
            $stmt = simpleQuery($db, $query);
            $query = "INSERT INTO BlockedUser VALUES('$serverID', '$userID');";
            $stmt = simpleQuery($db, $query);
        }
?>