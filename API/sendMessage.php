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
  $ServerName=$data->servername;
  echo json_encode($ServerName);
  /*
  $auth = $data->auth;
  $query = "SELECT UserID, UserName FROM WebUser WHERE Token = '$auth';";
            $stmt = simpleQuery($db, $query);
            $stmt->bind_result($userId,$nickname);
            $stmt->fetch();
  
  if($userId==NULL){
    http_response_code(500);
    die('{ "errMessage": "Bad Auth Token" }');
  }
  else{
    $query = "SELECT ServerID FROM Server WHERE ServerName = '$ServerName';";
      $stmt = simpleQuery($db, $query);
      $stmt->bind_result($ServerID);
      $stmt->fetch();
      echo json_encode($ServerName);

      
    $continue = false;
    $query = "SELECT Permission FROM ServerMember WHERE ServerID =".$ServerID." AND UserID =".$userId.";";
      $stmt = simpleQuery($db, $query);
      $stmt->bind_result($tmp)
      $stmt->fetch();
      
    if($tmp != NULL)
    {
      $continue = true;
    }
    if($continue){
      $serverName = $data->servername;
      $message = $data->message;
      $time = $data->time;
      $query = "SELECT ServerID FROM Server WHERE ServerName = '$serverName';";
      //runs query
            $stmt = simpleQuery($db, $query);
      //binds results of query to the database
        $stmt->bind_result($server);
        $stmt->fetch();

        $privateserver = "../chat/private/".$server.".txt";

    	     $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    	     if (($message) != "\n") {
    	       if (preg_match($reg_exUrl, $message, $url)) {
    	         // $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
                 }
                      //fwrite(fopen($privateserver, 'a'), $nickname."<".$time."<".$message = str_replace("\n", " ", $message) . "\n");
    	          fwrite(fopen($privateserver, 'a'), $nickname."<".$time."<".$message. "\n");
    	     }

        }
        else{
          http_response_code(500);
          die('{ "errMessage": "Permission not found" }');
        }

        
    }
*/

?>
