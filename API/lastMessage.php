<?php
$data = json_decode(file_get_contents("php://input"));
$auth = $data->auth;
$serverName = $data->servername;

include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
                http_response_code(500);
                die('{ "errMessage": "Failed to Connect to DB." }');
            }

            $query = "SELECT ServerID FROM Server WHERE ServerName='$serverName'";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($serverId);
            $stmt->fetch();

$privateserver = "chat/private/".$serverId.".txt";

if(file_exists($privateserver)){
    $lines = file($privateserver);
  }
  else{
    $lines = "Failure"  
  }
  mysql_close($db);
  echo json_encode($lines);
?>