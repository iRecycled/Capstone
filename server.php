<?php
	
header("index.php");
if ( isset( $_POST['submit'] ) ) {
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        
  $servername = $_POST['servername']; 
        $query = "INSERT INTO Server VALUES ((SELECT * FROM (SELECT COALESCE(MAX(ServerId)+1,0) FROM Server) as tmptable), '$servername')";
	$stmt = simpleQuery($db, $query);
        if($stmt == NULL) {
           include 'test.html';
        }
      	else{
           include 'login.html';
        }
}
?>