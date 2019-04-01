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
            $alreadyExists = false;
            //   while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            //      $alreadyExists = True;
                 //return $alreadyExists;
                //  echo("Why tho?");
                //  return;
             //}
            
            
            //if the user is not already seen as online, set value to 1 to set online
            if($alreadyExists == false){
                $query = "INSERT INTO Online VALUES ($userID, $serverID, 1);";
                $stmt = simpleQuery($db,$query);
            }
            //if user IS online update the database for user to 1
            else{
                $query = "UPDATE Online SET isOnline = 1 WHERE UserID = $userID AND ServerID = $serverID;";
                $stmt = simpleQuery($db,$query);
            }
?>
