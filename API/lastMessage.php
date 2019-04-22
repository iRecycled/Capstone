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


$continue = false;
//$query = "SELECT Permission FROM WebUser wu JOIN ServerMember sm ON wu.UserID = sm.UserID JOIN Server s ON s.ServerID = sm.ServerID WHERE wu.UserName = '$nickname' AND s.serverID = '$ServerID';";
$query = "SELECT ServerID FROM ServerMember WHERE ServerID=$ServerID AND UserID=$userId;";
      $stmt = simpleQuery($db, $query);
      $stmt->bind_result($tmp);
      $stmt->fetch();
      
      
if($tmp != NULL)
{
  $continue = true;
}
if($continue){
  $serverName = $data->servername;

  $query = "SELECT ServerID FROM Server WHERE ServerName = '$serverName';";
  //runs query
        $stmt = simpleQuery($db, $query);
  //binds results of query to the database
    $stmt->bind_result($server);
    $stmt->fetch();


$privateserver = "../chat/private/".$server.".txt";
$exists = file_exists($privateserver);

$lines = file($privateserver);
$log= count($lines);


$file = file_get_contents($privateserver);
$array = explode("\n",$file);
  echo json_encode($array);
            }
            else{
              http_response_code(500);
              die('{ "errMessage": "Permission not found" }');
            }
          }
?>