<!doctype html>
<html lang="en">

<head>
    <title>Home</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>


    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    
    <script src='chat.js'></script>
    <script src="home.js"></script>
    <script src="script.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">
    <!-- Scrollbar Custom CSS -->

</head>

<body>
 <!-- Nav Bar-->
 <div id="nav-template">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <ul class="navbar-nav mr-auto">
            <a class="nav-item nav-link active" href="home.html">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link active" href="introPage.html">About <span class="sr-only">(current)</span></a>
        </ul>

        <ul class="navbar-nav mr-auto ">
            <a class="navbar-brand mb-0 h1" href="#">TerryChat <span class="sr-only">(current)</span></a>
        </ul>

        <ul class="navbar-nav right">
            <a class="nav-item nav-link active" href="introPage.html">Logout <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link active" href="profile_page.html" id="username">       
                <script>
                    document.getElementById("username").innerHTML = '<i class="fas fa-user-circle" aria-hidden="true" ></i>' + localStorage.getItem("username");
                </script>
            <span class="sr-only">(current)</span></a>
            
        </ul>
    </nav>
</div>

<div class="wrapper">
<!-- Sidebar -->
<nav id="sidebar" class="bg-dark navbar-text text-center">
        <div class="sidebar-header">
            <h4><a href="chat.html"><u>My Chatrooms</u></a></h4>
        </div>

        <ul class="list-unstyled components">
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Public Chatrooms</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="#">Chat 1</a>
                    </li>
                    <li>
                        <a href="#">Chat 2</a>
                    </li>
                    <li>
                        <a href="#">Chat 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Private Chatrooms</a>
                <ul class="collapse list-unstyled" id="pageSubmenu" name="privateServers">
                    
                </ul>
            </li>
        </ul>
        <div class="sidebar-header">
                <h4><a href="Instant_messages.html"><u>Instant Messages</u></a></h4>
        </div>
        <ul class="list-unstyled components">
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Friends</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#">User1</a>
                        </li>
                        <li>
                            <a href="#">User2</a>
                        </li>
                        <li>
                            <a href="#">User3</a>
                        </li>
                    </ul>
            </li> 
        </ul>
        <div class="sidebar-header">
                <h4><u>Features</u></h4>
        </div>
        <ul class="list-instyled components">
            <li>
                <a href="#" id="newServerLink" data-toggle="modal" data-target="#newPrivateServerModal">Add new server</a>
            </li>
            <li>
                <a href="#" data-toggle="modal" data-target="#deletePrivateServerModal">Delete server</a>
            </li>
            <li>
                <a href="#">Invite to server</a>
            </li>
        </ul>
        <ul class="list-unstyled components">    
            <li>
                <a href="#">About</a>
            </li>
            <li>
                <a href="#">Server</a>
            </li>
        </ul> 

    </nav>
    <!-- Page Content -->
    <div id="content">
        <table id = "userServers">
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Register-->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold" id="registerModal">Register</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="form-group mx-3">
                    <div class="md-form">
                        <label for="form1">Username</label>
                        <input type="text" id="form1" class="form-control">
                    </div>

                    <div class="md-form mb-3">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Email:</label>
                        <input type="email" id="defaultForm-email" class="form-control validate">
                    </div>

                    <div class="md-form mb-4">
                        <label data-error="wrong" data-success="right" for="defaultForm-pass">Password:</label>
                        <input type="password" id="defaultForm-pass" class="form-control validate">
                    </div>

                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-success">Login</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                </div>
            </div>
        </div>
</div>

    <!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold" id="loginModal">Log-in</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Email</label>
                        <input type="email" id="defaultForm-email" class="form-control validate">
                    </div>

                    <div class="md-form mb-4">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="defaultForm-pass">Password</label>
                        <input type="password" id="defaultForm-pass" class="form-control validate">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-success">Login</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                </div>
            </div>
        </div>
</div>

</body>
</html>