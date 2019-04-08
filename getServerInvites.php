<?php
        //Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $username = $_POST['username']; 
       
        //Gets the id for the current user
        $query = "SELECT UserID FROM WebUser WHERE username = '$username';";
        $stmt = simpleQuery($db, $query);
   
        $stmt->bind_result($userID);
        $stmt->fetch();

        //retrieves server names of all current invitations
        $query = "SELECT s.ServerName FROM Server s JOIN ServerInvite si on s.ServerID = si.ServerID where si.UserID = '$userID';";
        
        $result = $db->query($query);
        $response = array();
        
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $response[] = $row;
        }

        echo json_encode($response);
?>