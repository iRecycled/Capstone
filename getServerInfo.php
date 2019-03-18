<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            //connects to database
        $serverID = $_POST['serverID']; 
        $query = "SELECT ServerName FROM Server WHERE ServerID = '$serverID';";
        //runs the query

        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($serverName);
        $stmt->fetch();
        echo json_encode($serverName);
?>