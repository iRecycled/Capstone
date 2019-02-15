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
            include 'register.html';
        }
        else {
            $query = "SELECT COALESCE(MAX(ServerId),0) FROM Server";
            $serverId = simpleQuery($db, $query);
            //$query = "INSERT INTO Server VALUES ('$serverId', '$servername')";
	      //$stmt = simpleQuery($db, $query);
            //$query = "SELECT UserId FROM WebUser WHERE UserName = '$username'";
            //$userId = simpleQuery($db, $query);
            //$query = "INSERT INTO ServerMember VALUES ('$serverId', '$userId'";
	      //$stmt = simpleQuery($db, $query);
            if($stmt == NULL) {
                  include 'register.html';
            }
      	else{
                  include 'profile_page.html';
            }
        }
?>