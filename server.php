<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
        $username = $_POST['username'];
        $servername = $_POST['servername']; 
        if($servername == NULL){
            include 'register.html';
        }
        else {
            $query = "SELECT * FROM (SELECT COALESCE(MAX(ServerID)+1,0) FROM Server) as tmptable";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($serverId);
            $stmt->fetch();
            $query = "INSERT INTO Server VALUES ('$serverId', '$servername')";
            $stmt = simpleQuery($db, $query);
            $query = "SELECT UserId FROM WebUser WHERE userName = '$username'";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($userId);
            $stmt->fetch();
            $query = "INSERT INTO ServerMember VALUES ('$serverId', '$userId')";
            $stmt = simpleQuery($db, $query);
        }
?>