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
        $query = "SELECT serverName FROM Server WHERE ServerID = '$serverID';";
        //runs the query
        $result = $db->query($query);
        //output query result to json array
        echo json_encode($response);
        
?>