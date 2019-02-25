<?php
header("index.php");
if ( isset( $_POST['submit']) && (strlen( $_POST['usernameL'])!=0) && (strlen( $_POST['passwordL'])!=0)  ) {//first par
        // 1. Connect to the database
        include "database.php";
        $db = connectToDatabase(DBDeets::DB_NAME);
        if ($db->connect_error) {
            http_response_code(500);
            die('{ "errMessage": "Failed to Connect to DB." }');
        }
  $name = $_POST['usernameL']; 
  $pass = $_POST['passwordL'];
  
        // 2. Run the Query
  //SELECT username, password, money FROM logins WHERE username = '$username';
        $query = "SELECT UserID, UserName, Password, email FROM WebUser WHERE UserName = '$name';";
        $stmt = simpleQuery($db, $query);
  
        if($stmt == NULL) {
            include "regFail.html";
        				  }
 		 else{
      		$stmt->bind_result($userID, $username, $password, $email);
        $stmt->fetch();
  			if(strcmp($pass,$password)==0){
         ?>
         <script> localStorage.setItem("sessionID", "<?php echo $userID; ?>"); </script>
         <?php
  		    include "chat.html"; //success, loads chat
   			 }
           else{
             //edit html element to show error
              echo "<script>
               function mySubmit(){
                  document.getElementById("username").style.borderColor = "red";
                  document.getElementById("password").style.borderColor = "red";
               }
               mySubmit();
               </script>"
               
               //include "login.html";
           }
         }
  }
  else {
    include "login.html";
  }
?>

