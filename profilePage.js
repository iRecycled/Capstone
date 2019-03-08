if(localStorage.getItem('viewInfo')=='' || !localStorage.getItem('viewInfo'))
{
    console.log("empty")
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
            if(result == 0){
                alert("Password failed to change.");
            }
            else{
                alert("Password changed successfully!");
            }
        },
        error: function(result) {
            //If not successful, return to the profile page
            window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/profile_page.html';
            alert("Password failed to change.");
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
            if(result == 0) {
                alert("Email does not match an account in the Database.");
            }
            else{
                //logs out the user
                localStorage.setItem("username", "logout");
                alert("You received an email with your new password!");
            }
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
function AddFriendButton(e){
    friendName = localStorage.getItem('viewInfo')
    if((localStorage.getItem('username') != friendName) && CheckFriend(friendName))
    {
        console.log("Calls");
        document.getElementById(e).innerHTML += "<h4><a><u>Add Friend</u></a></h4>";
        document.getElementById(e).onclick = function(){ SendFriendRequest()};
    }
}

function SendFriendRequest()
{
    user = localStorage.getItem('username');
    friend = localStorage.getItem('viewInfo');
    return $.ajax({
        type: "post",
        url: "sendFriendRequest.php",
        data: {user: user, friend: friend},
        success: function(data) {
            alert(data);
        },
        error: function(data) {
            alert("fail");
        }
    })
}

function CheckFriend(name){
    //get list of user's friends
    console.log(localStorage.getItem('username'))
    return $.ajax({
        type: "post",
        url: "getFriendsList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            names = []
            for(i = 0; i < obj.length; i++){
                names.push(obj[i].UserName)
            }
            names.sort()
            if(names.indexOf(name) > -1)
            {
                console.log("already friends")
                return false;
            }
            else
            {
                console.log("not friends")
                return true;
            }
        },
        error: function(data) {
            console.log("fail");
            return false;
        }
    })
}

document.addEventListener("DOMContentLoaded", function(event) {
    AddFriendButton('friendZone')
})