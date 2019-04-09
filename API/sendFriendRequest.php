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

    $query = "SELECT * FROM FriendRequest WHERE FromID = '$userId' AND ToID =  '$userID';";
        
    $result = $db->query($query);
    $alreadyExists = false;
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $alreadyExists = true;
    }
    $query = "SELECT Friend1ID FROM Friend WHERE Friend1ID = '$userId' and Friend2ID = '$userID';";
  //runs query
        $stmt = simpleQuery($db, $query);
        $stmt->bind_result($tmp);
        $stmt->fetch();

    if($alreadyExists==true || $tmp>=0){
        echo json_encode($alreadyExists);
    }
    else{
    $query = "INSERT INTO FriendRequest VALUES ('$userId', '$userID');";
  //runs query
        $stmt = simpleQuery($db, $query);
            echo json_encode("Friend Request Sent");
        
    }
  //binds results of query to the database
    //sends the information from the database back as a json object to the ajax call
//echo json_encode($username);

}
mysql_close($db);
?>