<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            //connects to database
        $username = $_POST['username']; 
        //sql query get userid from name
        $query = "SELECT UserID FROM WebUser WHERE UserName = '$username';";
        //runs the query
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($userID);
        $stmt->fetch();
        //queries for getting friends list
        //check if userID is in first column of table
        $query = "SELECT UserName FROM Friend JOIN WebUser w2 ON Friend.Friend2ID = w2.UserID WHERE Friend1ID = '$userID';";
        $result = $db->query($query);
        //add to json array
        $response = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $response[] = $row;
        }
        //check is userID is in second column of table
        $query = "SELECT UserName FROM Friend JOIN WebUser w1 ON Friend.Friend1ID = w1.UserID WHERE Friend2ID = '$userID';";
        $result = $db->query($query);
        //add to json array
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $response[] = $row;
        }
        echo json_encode($response); 
?>