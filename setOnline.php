<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            $serverID = $_POST['serverID'];
            $username = $_POST['username'];
            $query = "SELECT UserID FROM WebUser WHERE username = '$username';"; //grabs UserId from specific user
            $stmt = simpleQuery($db, $query);
    
            $stmt->bind_result($userID);
            $stmt->fetch();
           
            $query = "SELECT * FROM Online WHERE UserID = $userID AND ServerID = $serverID;";//grabs all from online where userID and serverID match logged in user
            $result = $db->query($query);
            $alreadyExists = false;
            //used to check if the user already exists in the database
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $alreadyExists = true;
            }
            //if user already exists then refresh the timer of when the user logged in
            if($alreadyExists == true){
                $query = "UPDATE Online SET isOnline = 1, timeStamp = NOW() WHERE UserID = $userID AND ServerID = $serverID;";
                $stmt = simpleQuery($db,$query);
            }
            //if not logged in then set to online (1) and start a timer of when logged in (now)
            else {
                $query = "INSERT INTO Online VALUES ($userID, $serverID, 1, NOW());";
                $stmt = simpleQuery($db,$query);
            }
?>
