<?php
header("index.php");
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
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
        $alreadyExists = false;
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $alreadyExists = true;
        }
        $query = "SELECT * FROM Friend WHERE (Friend1ID = '$userIDFrom' AND Friend2ID =  '$userIDTo') OR (Friend1ID = '$userIDTo' AND Friend2ID =  '$userIDFrom');";
        
        $result = $db->query($query);
        $alreadyFriends = false;
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $alreadyFriends = true;
        }

        if($alreadyFriends == true) {
                echo("Already friends with this user.");
                return;
        }

        if($userIDFrom == $userIDTo) {
                echo("You don't need to ask yourself to be your friend.");
                return;
        }

        if ($alreadyExists == false) {
                $query = "INSERT INTO FriendRequest VALUES ('$userIDFrom', '$userIDTo');";
                $stmt = simpleQuery($db, $query);
                echo("Friend request sent!");
        }
        else {
                echo("Already sent friend request to this user.");
        }
?>