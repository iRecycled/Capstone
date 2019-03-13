<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            $serverID = $_POST['serverID'];
            
            $query = "DELETE FROM ServerMember WHERE serverId = '$serverID'";
            $stmt = simpleQuery($db, $query);

            $query = "DELETE FROM ServerInvite WHERE serverId = '$serverID'";
            $stmt = simpleQuery($db, $query);

            $query = "DELETE FROM Server WHERE serverId = '$serverID'";
            $stmt = simpleQuery($db, $query);

            $filename = "chat/private/$serverID.txt";
            unlink($filename);
?>
