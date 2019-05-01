<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }

            $data = json_decode(file_get_contents("php://input"));
            $user1Name = $data->user1Name;
            $user2Name = $data->user2Name;
            $boardState = $data->boardState;
            $query = "SELECT UserID FROM WebUser WHERE UserName = '$user1Name';";
                $stmt = simpleQuery($db, $query);
                $stmt->bind_result($user1Id);
                $stmt->fetch();
            $query = "SELECT UserID FROM WebUser WHERE UserName = '$user2Name';";
                $stmt = simpleQuery($db, $query);
                $stmt->bind_result($user2Id);
                $stmt->fetch();

            $query = "UPDATE TicTacToe SET boardState = '$boardState' WHERE (User1ID = '$user1Id' AND User2ID = '$user2Id') OR (User1ID = '$user2Id' AND User2ID = '$user1Id')";
            $stmt = simpleQuery($db, $query); 

        mysql_close($db);
?>