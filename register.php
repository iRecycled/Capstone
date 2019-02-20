<?php
	
header("index.php");
if ( isset( $_POST['submit'] ) ) {
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $username = $_POST['username']; 
  $email = $_POST['email'];
  $password = $_POST['password'];
        // 2. Run the Query
        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$username', '$password', '$email')";
	$stmt = simpleQuery($db, $query);
        if($stmt == NULL) {
           //if statment fails reload page
           include 'register.html';
        }
      	else{
            //if statment succeeds go to login page
            include 'login.html';
        }
}
?>