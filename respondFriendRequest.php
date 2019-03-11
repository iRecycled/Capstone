<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $data = 0;
        $username = $_POST['user']; 
        $friendname = $_POST['friend'];
        $accept = $_POST['accept'];
        // 2. Run the Query
        $query = "SELECT UserID FROM WebUser WHERE username = '$username';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userIDFrom);
        $stmt->fetch();


        $query = "SELECT UserID FROM WebUser WHERE username = '$friendname';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userIDTo);
        $stmt->fetch();

        if($accept = "true") {
            $query = "INSERT INTO Friend VALUES '$userIDFrom' '$userIDTo';";
            $stmt = simpleQuery($db, $query);
            echo("success");
        }
        else {
            echo("fail");
        }

        $query = "DELETE FROM FriendRequest WHERE FromID = '$userIDFrom' AND ToID =  '$userIDTo';";
        $stmt = simpleQuery($db, $query);
?>