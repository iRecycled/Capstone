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
        $serverID = $_POST['serverID'];
        // 2. Run the Query
        $query = "SELECT UserID FROM WebUser WHERE username = '$username';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userID);
        $stmt->fetch();

        $query = "SELECT * FROM ServerInvite WHERE serverID = '$serverID' AND UserID =  '$userID';";
        
        $result = $db->query($query);
        $response = array();
        $alreadyExists = false;
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $alreadyExists = true;
        }
        $query = "SELECT * FROM ServerMember WHERE UserID = $userID AND ServerID = $serverID;";
        
        $result = $db->query($query);
        $response = array();
        $alreadyInServer = false;
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $alreadyInServer = true;
        }

        if($alreadyInServer == true) {
                echo("Friend is already a member of this server.");
                return;
        }

        if ($alreadyExists == false) {
                $query = "INSERT INTO ServerInvite VALUES ('$serverID', '$userID');";
                $stmt = simpleQuery($db, $query);
                echo("Server invite sent!");
        }
        else {
                echo("Already sent server invite to this user (" + $username + ").");
        }
?>