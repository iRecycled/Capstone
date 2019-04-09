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
  $username = $data->username;


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


  $query = "SELECT UserID FROM WebUser WHERE UserName = '$username';";
  //runs query
        $stmt = simpleQuery($db, $query);
  //binds results of query to the database
    $stmt->bind_result($userID);
    $stmt->fetch();
    //sends the information from the database back as a json object to the ajax call
//echo json_encode($username);
if($userID==NULL){
    echo json_encode("Exists");
}
else{
    echo json_encode("Does Not Exist"); 
}
}
mysql_close($db);
?>