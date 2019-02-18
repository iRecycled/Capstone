<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
        $username = $_POST['username']; 
        else {
            $query = "SELECT ServerName FROM Server s INNER JOIN ServerMember sm ON s.ServerId = sm.ServerId INNER JOIN WebUser wu ON wu.UserId = sm.UserId WHERE wu.UserName = '$username'";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($serverList);
            $stmt->fetch();
            echo json_encode($serverList);
        }
?>