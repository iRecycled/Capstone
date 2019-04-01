<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $username = $_POST['username']; 
        // 2. Run the Query
        $query = "SELECT Avatar FROM WebUser WHERE username = '$username';";        
        
        $result = $db->query($query);
        $response = array();
        
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $response[] = $row;
        }

        echo json_encode($response);
?>