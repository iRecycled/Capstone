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
<<<<<<< HEAD
=======

  if(($username==NULL)||($email==NULL)||($password==NULL)){
        include 'register.html';
  }
  else{
>>>>>>> 690314d2bccdeb57a2a4872f52cf75a653056be2
        //INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), 'Kevin', 'notmyactualpassword', 'jensenk2136@my.uwstout.edu')
        // 2. Run the Query
        //$query = "INSERT INTO WebUser (UserName, Password, email) VALUES ('$username', '$password', '$email')";
        //$query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId+1,0) FROM WebUser) as tmptable), 'Kevin', 'notmyactualpassword', 'jensenk2136@my.uwstout.edu'";
        $query = "INSERT INTO WebUser VALUES ((SELECT * FROM (SELECT COALESCE(MAX(UserId)+1,0) FROM WebUser) as tmptable), '$username', '$password', '$email')";
	$stmt = simpleQuery($db, $query);
        if($stmt == NULL) {
           include 'register.html';
        }
      	else{
            include 'login.html';
        }
}
<<<<<<< HEAD
=======
}
>>>>>>> 690314d2bccdeb57a2a4872f52cf75a653056be2
?>