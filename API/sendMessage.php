<?php
include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        //connects to database
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  //$username = $_POST['username']; 
  $data = json_decode(file_get_contents("php://input"));
  $serverName = $data->servername;
  $message = $data->message;
  $nickname = $data->username;
  $time = $data->time;
  $query = "SELECT ServerID FROM Server WHERE ServerName = '$serverName';";
  //runs query
        $stmt = simpleQuery($db, $query);
  //binds results of query to the database
    $stmt->bind_result($server);
    $stmt->fetch();
    
    $privateserver = "../chat/private/".$server.".txt";

/*
	     $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	     if (($message) != "\n") {
	       if (preg_match($reg_exUrl, $message, $url)) {
	          $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
	       }
	          fwrite(fopen($privateserver, 'a'), $nickname."<".$time."<".$message = str_replace("\n", " ", $message) . "\n");
	     }
*/

	     if (($message) != "\n") {
	       
	          fwrite(fopen($privateserver, 'a'), $message . "\n");
	     }


?>