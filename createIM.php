<?php
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
        }
        $username = $_POST['username'];
        $friendUsername = $_POST['friendName'];
        // Selects the max ID + 1
        $query = "SELECT * FROM (SELECT COALESCE(MAX(FileName)+1,0) FROM InstantMessage) as tmptable";
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($fileID);
        $stmt->fetch();
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
        //User1ID, User2ID, FileName(ID)
        $query = "INSERT INTO InstantMessage VALUES ('$firstUserID', '$otherUserID','$fileID')";
        $stmt = simpleQuery($db, $query);
        
        //Create chatroom text file_exists\
        $filename = "chat/private/im$fileID.txt";
        //error_log($filename);
        // fopen("chat.txt","w");
        // fclose("chat.txt");
        $openfile = fopen($filename,"w") or die("can't open file");
        //fwrite($openfile,"");
        fclose($openfile);
        echo $fileID;
?>