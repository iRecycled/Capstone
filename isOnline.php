<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            $serverID = $_POST['serverID'];
            //returns serverID of online users
            $query = "SELECT UserName FROM WebUser JOIN Online ON Online.UserID = WebUser.UserID WHERE isOnline = true AND ServerID = '$serverID' AND TIMESTAMPDIFF(MINUTE, timeStamp, NOW()) < 10;";
            //returns array of users that are on that server and are online
            $result = $db->query($query);
            //output query result to json array
            $response = array();
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $response[] = $row;
            }
            echo json_encode($response);
?>
