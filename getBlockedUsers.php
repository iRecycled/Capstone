<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            //connects to database
        $serverID = $_POST['serverID']; 
        //sql query code where username belongs to server
        $query = "SELECT wu.UserName, wu.UserID FROM Server s JOIN BlockedUser bu ON s.ServerId = bu.ServerId JOIN WebUser wu ON wu.UserId = bu.UserId WHERE s.ServerID = '$serverID';";
        //runs the query
        $result = $db->query($query);
        //output query result to json array
        $response = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $response[] = $row;
        }
        echo json_encode($response);
        
?>