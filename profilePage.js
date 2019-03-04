if(localStorage.getItem('viewInfo')=='')
{
    localStorage.setItem('viewInfo', localStorage.getItem('username'));
}
if(localStorage.getItem('username')==localStorage.getItem('viewInfo'))
{
    
}

function loadServer(serverID) {
    localStorage.setItem("serverID", serverID);
    //window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/chat.html';
    console.log("TEST");
}
//Creates a private server and sets the currently logged in user as the leader
$(document).ready(function(){
    $("#createServerBtn").click(function(e){
        e.preventDefault();
        $.ajax({
        type: "post",
        url: "server.php",
        data: {username: localStorage.getItem('username'), servername: document.getElementById("newServerName").value},
        success: function(result) {
            //If successful, go to the home page
            window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/home.html';
        },
        error: function(result) {
            //If not successful, return to the profile page
            window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/profile_page.html';
        }
    })
    })  
})
//Allows the user to change their password if they know their current password
$(document).ready(function(){
    $("#changePasswordBtn").click(function(e){
        e.preventDefault();
        $.ajax({
        type: "post",
        url: "changePassword.php",
        data: {username: localStorage.getItem('username'), password: document.getElementById("oldPass").value, newPassword: document.getElementById("newPass").value, confirmNewPassword: document.getElementById("confirmNewPass").value},
        success: function(result) {
            //If successful, go to the home page
            window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/home.html';
        },
        error: function(result) {
            //If not successful, return to the profile page
            window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/profile_page.html';
            alert("Failed to change password!")
        }
    })
    })
    //Allows the user to change their password if forgotten by sending them an email
    $("#forgotPasswordBtn").click(function(e){
        e.preventDefault();
        $.ajax({
        type: "post",
        url: "forgotPassword.php",
        data: {username: localStorage.getItem('username')},
        success: function(result) {
            //create alert box
            /*let alert = document.createElement("div");
            let close = document.createElement("a");
            alert.class = "alert alert-info alert-dismissible";
            alert.class = "close";*/
            //logs out the user
            alert("You received an email with your new password!");
            localStorage.setItem("username", "logout"); 
            window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/index.html';
        },
        error: function(result) {
            window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/profile_page.html';
            alert("Failed to reset your password.");
        }
    })
    })
})
//gets a list of servers that the user belongs to
//redirects the user to chat.html with localstorage Key serverID set to the server ID
$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "getServerList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj);
            //for all the servers the user belongs to, create an html element and assign the onclick to redirect
            //to chat.html
            for( var x in obj) {
                let privateServerList = document.getElementById("pageSubmenu");
                let listItem = document.createElement("li");
                let link = document.createElement("a");
                let text = document.createTextNode(obj[x].ServerName);
                link.id = obj[x].ServerID;
                link.onclick = function() {
                    localStorage.setItem("serverID", this.id);
                };
                link.href = "chat.html";
                link.appendChild(text);
                listItem.appendChild(link);
                privateServerList.appendChild(listItem);
            }
        },
        error: function(data) {
            console.log("fail");
        }
    })

    //gets information related to the user
    $.ajax({
        type: "post",
        url: "userInfo.php",
        data: {username: localStorage.getItem('viewInfo')},
        success: function(data) {
            console.log(data);
            obj = JSON.parse(data);
            console.log(obj);
            document.getElementById("userName").innerHTML = obj.name;
            document.getElementById("email").innerHTML = obj.email;
            document.getElementById("chatCount").innerHTML = obj.chatCount;
            document.getElementById("privateCount").innerHTML = obj.privateCount;
            document.getElementById("otherData").innerHTML = "nothing right now";
        },
        error: function(data) {
            console.log("fail");
        }
    })
})