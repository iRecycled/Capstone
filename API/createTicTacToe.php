<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }

            $data = json_decode(file_get_contents("php://input"));
            $user1Name = $data->user1Name;
            $user2Name = $data->user2Name;
            $query = "SELECT UserID FROM WebUser WHERE UserName = '$user1Name';";
                $stmt = simpleQuery($db, $query);
                $stmt->bind_result($user1Id);
                $stmt->fetch();
            $query = "SELECT UserID FROM WebUser WHERE UserName = '$user2Name';";
                $stmt = simpleQuery($db, $query);
                $stmt->bind_result($user2Id);
                $stmt->fetch();

            $query = "SELECT * FROM TicTacToe WHERE (User1ID = '$user1Id' AND User2ID = '$user2Id') OR (User1ID = '$user2Id' AND User2ID = '$user1Id')";
                $result = $db->query($query);
                while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        die('{ "errMessage": "Aleady playing a game with this user" }');
                }
if($user1Id == NULL || $user2Id == NULL){
    http_response_code(500);
    die('{ "errMessage": "Bad User Name" }');
}
            //Creates the game in the database
            $query = "INSERT INTO TicTacToe VALUES ('$user1Id', '$user2Id','EEEEEEEEE')";
            $stmt = simpleQuery($db, $query);
            
        echo json_encode("Server Created"); 
        mysql_close($db);
?>