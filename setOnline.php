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
           
            $query = "SELECT * FROM Online WHERE UserID = $userID AND ServerID = $serverID;";
            $result = $db->query($query);
            $alreadyExists = false;
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                // echo("Hello");
                // return;
                $alreadyExists = true;
            }
            if($alreadyExists == true){
                $query = "UPDATE Online SET isOnline = 1 WHERE UserID = $userID AND ServerID = $serverID;";
                $stmt = simpleQuery($db,$query);
                $query = mysql_query("UPDATE Online SET timeStamp = NOW() WHERE UserId = $userID AND ServerID = $serverID;";)
                $stmt = simpleQuery($db, $query);
            }
            else {
                $query = "INSERT INTO Online VALUES ($userID, $serverID, 1, NOW());";
                $stmt = simpleQuery($db,$query);
            }
?>
