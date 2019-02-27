<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            //connects to database
        $username = $_POST['username']; 

        $query = "select UserId from WebUser where UserName = '$username'";
        //runs the query
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result)($userID);
        $stmt->fetch()
        $query = "select UserName from Friend join WebUser w2 on Friend.Friend2ID = w2.UserID where Friend1ID = '$userID'";
        $result = $db->query($query);
        $response = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $response[] = $row;
        }
        $query = "select UserName from Friend join WebUser w1 on Friend.Friend1ID = w1.UserID where Friend2ID = '$userID";
        $result = $db->query($query);
        $response = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $response[] = $row;
        }
        echo json_encode($response);
        
?>