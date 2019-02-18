<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
        $username = $_POST['username']; 
        $query = "SELECT ServerName FROM Server";
        $result = $db->query($query);

        //$row = $result->fetch_array(MYSQLI_ASSOC);
        echo json_encode($result);
        // s INNER JOIN ServerMember sm ON s.ServerId = sm.ServerId INNER JOIN WebUser wu ON wu.UserId = sm.UserId WHERE wu.UserName = '$username'
?>