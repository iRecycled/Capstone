<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }

            $data = json_decode(file_get_contents("php://input"));
            $data = json_decode(file_get_contents("php://input"));

  $auth = $data->auth;
  $query = "SELECT UserID, UserName FROM WebUser WHERE Token = '$auth';";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($userId,$username);
            $stmt->fetch();
            if($userId==NULL){
              http_response_code(500);
              die('{ "errMessage": "Bad Auth Token" }');
            }
else{

            $query = "SELECT FromID FROM FriendRequest WHERE ToID = $userId";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($requesters);
            $stmt->fetch();

            if($requesters==0){
                echo "Completed";
            }
            else{
            $query = "INSERT INTO Friend VALUES ($requesters,$userId)";
            $stmt = simpleQuery($db, $query);
            $query = "DELETE FROM FriendRequest WHERE FromID=$requesters and ToID=$userId";
            $stmt = simpleQuery($db, $query);
            echo $requesters;
            }
        }
        mysql_close($db);
?>