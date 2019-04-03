<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            $serverID = $_POST['serverID'];
            $username = $_POST['username'];
            $query = "SELECT UserID FROM WebUser WHERE username = '$username';";
            $stmt = simpleQuery($db, $query);
    
            $stmt->bind_result($userID);
            $stmt->fetch();
           
            $query = "SELECT * FROM Online JOIN WebUser ON WebUser.UserID = Online.UserID WHERE username = $username AND serverID = $serverID;";
            $alreadyExists = false;
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                echo("Hello");
                return;
                    $alreadyExists = true;
            }
            if(mysql_num_rows($query) != 0){
                //user already online
                $query = "UPDATE Online SET isOnline = 1 WHERE UserID = $userID AND ServerID = $serverID;";
                $stmt = simpleQuery($db,$query);
            }
            else {
                //user is NOT online
                $query = "INSERT INTO Online VALUES ($userID, $serverID, 1);";
                $stmt = simpleQuery($db,$query);
            }
            //$result = $db->query($query);
?>
