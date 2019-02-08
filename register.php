<?php
	
header("index.php");
if ( isset( $_POST['submit'] ) ) {
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        
//$query = "INSERT INTO logins (id, username, password) 
 //       VALUES ('0','$_POST['username']', '$_POST['password']')";
  $username = $_POST['username']; 
  $email = $_POST['email'];
  $password = $_POST['password'];
  
        // 2. Run the Query
        //$query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId+1,0) FROM WebUser) as tmptable), 'Kevin', 'notmyactualpassword', 'jensenk2136@my.uwstout.edu'";
        $query = "INSERT INTO WebUser (UserID, UserName, Password, email) VALUES (4, '$username', '$password', '$email')";
	$stmt = simpleQuery($db, $query);
        if($stmt == NULL) {
           include 'home.html';
        }
      	else{
            include 'profile_page.html';
        }
}
?>