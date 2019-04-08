<?php
        //Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            $serverID = $_POST['serverID'];
            
            //Remove information relating to the Server
            $query = "DELETE FROM ServerMember WHERE serverId = '$serverID'";
            $stmt = simpleQuery($db, $query);

            $query = "DELETE FROM ServerInvite WHERE serverId = '$serverID'";
            $stmt = simpleQuery($db, $query);

            $query = "DELETE FROM BlockedUser WHERE serverId = '$serverID'";
            $stmt = simpleQuery($db, $query);

            $query = "DELETE FROM Online WHERE serverId = '$serverID'";
            $stmt = simpleQuery($db, $query);

            //Remove the Server
            $query = "DELETE FROM Server WHERE serverId = '$serverID'";
            $stmt = simpleQuery($db, $query);

            $filename = "chat/private/$serverID.txt";
            unlink($filename);
?>
