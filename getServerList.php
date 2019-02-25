<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            //connects to database
        $username = $_POST['username']; 
        $query = "SELECT ServerName, ServerID FROM Server s JOIN ServerMember sm ON s.ServerId = sm.ServerId JOIN WebUser wu ON wu.UserId = sm.UserId WHERE wu.UserName = '$username';";
        //runs the query
        $result = $db->query($query);
        $response = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $response[] = $row;
        }
        echo json_encode($response);
        
?>