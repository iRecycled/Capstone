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
        $username = $_POST['username']; 
        $url = $_POST['url'];
        // 2. Run the Query
        $query = "UPDATE WebUser SET Avatar = '$url' where UserName = '$username';";
        $stmt = simpleQuery($db, $query);
?>