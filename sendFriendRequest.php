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
  $username = strip_tags($_POST['user']); 
  $friendname = strip_tages($_POST['friend']);
        // 2. Run the Query
        /*$query = "SELECT UserID FROM WebUser WHERE username = '$username';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userIDFrom);
        $stmt->fetch();*/
/*
        $query = "SELECT UserID FROM WebUser WHERE username = '$friendname';";
        $stmt = simpleQuery($db, $query);
  
        $stmt->bind_result($userIDTo);
        $stmt->fetch();

        $query = "SELECT * FROM FriendRequest VALUES ('$userIDFrom', '$userIDTo');";
        $stmt = simpleQuery($db, $query);

        $stmt->bind_result($alreadyExists);
        $stmt->fetch();

        if($alreadyExists = null) {
                $query = "INSERT IGNORE INTO FriendRequest VALUES ('$userIDFrom', '$userIDTo');";
                $stmt = simpleQuery($db, $query);
        }*/
?>