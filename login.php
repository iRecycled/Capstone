<?php
header("index.php");
        
        abstract class DBDeets {
          const DB_NAME = 'cs458sp19Team1';
          const DB_USER = 'cs458sp19Team1';
          const DB_PW = 'Wutm2ft?';
        }
        
        function connectToDatabase($databaseName) {
          $db = new mysqli('localhost', DBDeets::DB_USER, DBDeets::DB_PW, $databaseName);
          if ($db->connect_errno) {
              die('<p>Failed to connect to database: ' . $db->connect_error . '</p></body></html>');
          }
          return $db;
        }
        
        function simpleQuery($db, $query) {
          // Prepare the query
          if(!($stmt = $db->prepare($query))) {
            echo "<!-- Query Prepare failed: (" . $db->errno . ") " . $db->error . "-->\n";
            return null;
          }
          // Execute query
          if(!$stmt->execute()) {
            //echo "<!-- Query Execute failed: (" . $stmt->errno . ") " . $stmt->error . "-->\n";
            return null;
          }
          // Store the results and return the statement object
          if(strpos($query, 'SELECT') !== false) { $stmt->store_result(); }
          return $stmt;
        }
        function simpleQueryPassword($db, $query) {
            $result = mysqli_query($db,$query);
        
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  
                  //password_verify($_POST['pass'],$row['Password'])
                    if(strlen($row['Password'])==60){
                        return true;
                    }
                }
                return false;
             } else {
                return false;
             }
             //mysqli_close($db);
        
        
          }
        
        function simpleQueryParam($db, $query, $ptype, &$param) {
          // Prepare the query
          if(!($stmt = $db->prepare($query))) {
            echo "<!-- Query Prepare failed: (" . $db->errno . ") " . $db->error . "-->\n";
            return null;
          }
          // Bind input param
          if(!($stmt->bind_param($ptype, $param))) {
            echo "<!-- Query Param Binding Failed: (" . $stmt->errno . ") " . $stmt->error . "-->\n";
            return null;
          }
          // Execute query
          if(!$stmt->execute()) {
            echo "<!-- Query Execute failed: (" . $stmt->errno . ") " . $stmt->error . "-->\n";
            return null;
          }
          // Store the results and return the statement object
          if(strpos($query, 'SELECT') !== false) { $stmt->store_result(); }
          return $stmt;
        }






        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }

  $name = strip_tags($_POST['user']);
  //$pass = strip_tags($_POST['pass']);

  $query = "SELECT Password FROM WebUser WHERE UserName = '$name';";
  $stmt2 = simpleQueryPassword($db, $query);
  


        $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE UserName = '$name';";
        $stmt = simpleQuery($db, $query);
  //ALTER TABLE YourTable ALTER COLUMN YourColumn VARCHAR (500) NOT NULL;
      	$stmt->bind_result($userID, $username, $password, $email, $sessionID);
        $stmt->fetch();

        //$query = "SELECT Password FROM WebUser WHERE UserName = '$name';";
        //$stmt2 = simpleQueryPassword($db, $query);
        
        $bool1 = strcmp($name,$username)==0;
        //$bool2 = strcmp($pass,$password)==0;
  			if($stmt2){
          $rand=rand(1, 50000);
          $query = "UPDATE WebUser SET SessionID=$rand WHERE UserName = '$username';";
          $stmt = simpleQuery($db, $query);

          $query = "SELECT UserID, UserName, Password, email, SessionID FROM WebUser WHERE UserName = '$name';";
          $stmt = simpleQuery($db, $query);
          $stmt->bind_result($userID, $username, $password, $email, $sessionID);
          $stmt->fetch();

          $data=$sessionID;
  		    //success, loads chat
   			 }
           else{
            $data=-10;
             //edit html element to show error
   
           }
  echo json_encode($data);
?>