<?php
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        
  $username = $_POST['username']; 
  $email = $_POST['email'];
  $password = $_POST['password'];
  $data=0;
        //INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), 'Kevin', 'notmyactualpassword', 'jensenk2136@my.uwstout.edu')
        // 2. Run the Query
        //$query = "INSERT INTO WebUser (UserName, Password, email) VALUES ('$username', '$password', '$email')";
        //$query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId+1,0) FROM WebUser) as tmptable), 'Kevin', 'notmyactualpassword', 'jensenk2136@my.uwstout.edu'";
        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$username', '$password', '$email')";
	$stmt = simpleQuery($db, $query);
        if($stmt == NULL) {
                $data=0;
        }
      	else{
                $data=1;
        }

?>