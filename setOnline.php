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
            $result = $db->query($query);
            $response = array();
            $alreadyExists = false;
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $alreadyExists = true;
            }
            echo("Hello");
            return;
            if($alreadyExists == false){
                $query = "INSERT INTO Online VALUES ($UserID, $serverID, 1);";
                $stmt = simpleQuery($db,$query);
            }
            else{
                $query = "UPDATE Online SET isOnline = 1 WHERE UserID = $userID AND ServerID = $serverID;";
                $stmt = simpleQuery($db,$query);
            }
?>
