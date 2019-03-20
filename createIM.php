<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }
        $username = $_POST['username'];
        $friendUsername = $_POST['friendName'];
        
        // Selects the ID of user logged in
        $query = "SELECT UserId FROM WebUser WHERE UserName = '$username'";
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($firstUserID);
        $stmt->fetch();
        // selects the id of friend's profile page being viewed
        $query = "SELECT UserId FROM WebUser WHERE UserName = '$friendUsername'";
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($otherUserID);
        $stmt->fetch();

        $mesageFileName = $username . "&" . $friendUsername;
        $query = "INSERT INTO InstantMessage VALUES ('$mesageFileName', '$firstUserID', '$otherUserID')";

        
        // TODO create file and store file in database
        //Create chatroom text file_exists\
        $filename = "instantMessage/$mesageFileName.txt";
        //error_log($filename);
        // fopen("chat.txt","w");
        // fclose("chat.txt");
        $openfile = fopen($filename,"w") or die("can't open file");
        //fwrite($openfile,"");
        fclose($openfile);
        
?>