<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }

            $data = json_decode(file_get_contents("php://input"));
            $username = $data->username;

            //Fetches the userId for the user that's logged in
            $query = "SELECT UserId FROM WebUser WHERE UserName = $username";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($userId);
            $stmt->fetch();

            $requesters = array();
            $query = "SELECT FromID FROM FriendRequest WHERE ToID = $userId";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($requesters);
            $stmt->fetch();

            foreach ($requesters as $requester){
            $query = "INSERT INTO Friend VALUES ($requester,$userId)";
            $stmt = simpleQuery($db, $query);
            $query = "DELETE FROM FriendRequest WHERE FromID=$requester and ToID=$userId";
            $stmt = simpleQuery($db, $query);
            }
        mysql_close($db);
        echo json_encode($userId);
?>