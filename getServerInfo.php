<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            //connects to database
        $serverID = $_POST['serverID']; 
        $query = "SELECT ServerName FROM Server s WHERE ServerID = '$serverID';";
        //runs the query
        $result = $db->query($query);
        $response = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $response[] = $row;
        }
        echo json_encode($response);
        
?>