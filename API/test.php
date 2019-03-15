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
  $username=json_decode(file_get_contents("php://input"));



  $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE UserName = '$username';";
  //runs query
        $stmt = simpleQuery($db, $query);
  //binds results of query to the database
      	$stmt->bind_result($userID, $username1, $password, $email, $SessionID);
    $stmt->fetch();
    //sends the information from the database back as a json object to the ajax call
echo json_encode($username);
//echo json_encode($SessionID);
?>