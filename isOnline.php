<?php
/*SELECT isOnline FROM Online JOIN WebUser ON Online.UserID = WebUser.UserID WHERE UserName = "Nick"*/
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
            $username = $_POST['username'];
            //returns usernames of online users
            //$query = "SELECT isOnline FROM Online JOIN WebUser ON Online.UserID = WebUser.UserID WHERE UserName = '$username';";
            $query = "SELECT UserName FROM WebUser JOIN Online ON Online.UserID = WebUser.UserID JOIN ServerMember ON ServerMember.UserID = WebUser.UserID WHERE isOnline = true AND ServerID = '$serverID';"
            //returns array of users that are on that server and are online
            $result = $db->query($query);
            //output query result to json array
            $response = array();
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $response[] = $row;
            }
            echo json_encode($response);
?>
