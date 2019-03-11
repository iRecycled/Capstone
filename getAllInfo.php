<?php
		include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        //connects to database
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $username = $_POST['username']; 
  
  $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE UserName = '$username';";
  //runs query
        $stmt = simpleQuery($db, $query);
  //binds results of query to the database
      	$stmt->bind_result($userID, $username1, $password, $email, $SessionID);
        $stmt->fetch();

        $query = "SELECT s.ServerName, s.ServerID FROM Server s JOIN ServerMember sm ON s.ServerId = sm.ServerId JOIN WebUser wu ON wu.UserId = sm.UserId WHERE wu.UserName <> '$username';";
        //runs the query
        $result = $db->query($query);
        //output query result to json array
        $response = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $response[] = $row;
        }

        $obj = (object) [
            'username' => $username1,
            'userID' => $userID,
            'password' => $password,
            'email' => $email,
            'sessionID' => $SessionID,
            'serverList' => $response
        ];
    //sends the information from the database back as a json object to the ajax call
echo json_encode($obj);
?>