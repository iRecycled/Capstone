<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
        $username = $_POST['username'];
        $servername = $_POST['servername'];
        if($servername == NULL){
            include 'profile_page.html';
        } else {
            //gets the highest server ID + 1
            $query = "SELECT * FROM (SELECT COALESCE(MAX(ServerID)+1,0) FROM Server) as tmptable";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($serverId);
            $stmt->fetch();
            //Creates the server in the database
            $query = "INSERT INTO Server VALUES ('$serverId', '$servername')";
            $stmt = simpleQuery($db, $query);
            //Fetches the userId for the user that's logged in
            $query = "SELECT UserId FROM WebUser WHERE UserName = '$username'";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($userId);
            $stmt->fetch();
            //Assigns the user to the leader of the server
            $query = "INSERT INTO ServerMember VALUES ('$serverId', '$userId', 3)";
            $stmt = simpleQuery($db, $query);

            //Create chatroom text file_exists\
            $filename = "chat/private/$serverId.txt";
            //error_log($filename);
            // fopen("chat.txt","w");
            // fclose("chat.txt");
            $openfile = fopen($filename,"w") or die("can't open file");
            //fwrite($openfile,"");
            fclose($openfile);
        }
?>
