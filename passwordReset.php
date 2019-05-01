<?php
    include "database.php";
    $db = connectToDatabase(DBDeets::DB_NAME);
    //connects to the database
    if ($db->connect_error) {
        http_response_code(500);
        die('{ "errMessage": "Failed to Connect to DB." }');
    }
    //randomly set password for the user to change
    $length = 8;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $password = '';
    // randomly selects 8 characters for the new password
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }
    // grabs data from url
    if(isset($_GET["name"])){
        $username = $_GET["name"];
    } else {
        $username = "fail";
    }
    $query = "SELECT email FROM WebUser WHERE UserName = '$username';";
    $stmt = simpleQuery($db, $query);
    $stmt->bind_result($email);
    $stmt->fetch();

    //query that updates the password
    $passwordHash=password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE WebUser SET Password='$passwordHash' WHERE UserName = '$username';";
    $stmt = simpleQuery($db, $query);
    $msg = "Hi " . $username . ",\n\n Here is your reset password code:\n\n" . $password . 
        "\n\nUse this code as your old password to finish your password reset.";
    //send email to the user with the new password
    mail($email,$subject,$msg);
    //$db->close();
    echo $username;
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Terry Password Reset</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <!-- Font Awesome JS,  -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="registerStyle.css">
    <script src="script.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            alert("You have received an email with your password code")
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/passwordReset.html';
        })
    </script>
</head>
<body>
    <div class="text-center" id="registerBox">
        <form class="form-signin">
               <h1 class="h3 mb-3 font-weight-normal" id="wordReg">Reset Password</h1>
            <div class = Login>
               <p> &nbsp </p> <!-- adds white space between password input and Sign in button -->
               <button class="btn btn-lg btn-primary btn-block" id="resetPasswordBtn">Reset Password</button>
               <p class="mt-5 bm-3 text-muted">Terrychat</p>
            </div>
        </form>
    </div>
  </body>
</html>