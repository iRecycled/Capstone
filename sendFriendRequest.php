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
        $friendname = $_POST['friend'];
        // 2. Run the Query
        $query = "SELECT UserID FROM WebUser WHERE username = '$username';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userIDFrom);
        $stmt->fetch();


        $query = "SELECT UserID FROM WebUser WHERE username = '$friendname';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userIDTo);
        $stmt->fetch();

        $query = "SELECT * FROM FriendRequest WHERE FromID = '$userIDFrom' AND ToID =  '$userIDTo';";
        
        $result = $db->query($query);
        $response = array();
        $alreadyExists = 0;
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $alreadyExists = 1;
        }

        /*if($alreadyExists == 0) {
                echo($userIDFrom, $userIDTo);
                $query = "INSERT INTO FriendRequest VALUES ('$userIDFrom', '$userIDTo');";
                $stmt = simpleQuery($db, $query);
        }*/
?>