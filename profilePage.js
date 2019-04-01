
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
    //window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/chat.html';
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
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/home.html';
        },
        error: function(result) {
            //If not successful, return to the profile page
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/profile_page.html';
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
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/home.html';
            if(result == 0){
                alert("Password failed to change.");
            }
            else{
                alert("Password changed successfully!");
            }
        },
        error: function(result) {
            //If not successful, return to the profile page
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/profile_page.html';
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
            if(result == 1) {
                //logs out the user
                localStorage.setItem("username", "logout");
                alert("You received an email with your new password!");
            }
            else{
                alert("Email does not match an account in the Database.");
            }
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/index.html';
        },
        error: function(result) {
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/profile_page.html';
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
    // populates friend list on sidebar
    $.ajax({
        type: "post",
        url: "getFriendsList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj);
            let username = localStorage.getItem('username');
            for( var x in obj) {
                let friendsList = document.getElementById("sidebarFriends");
                let listItem = document.createElement("li");
                let link = document.createElement("a");
                let text = document.createTextNode(obj[x].UserName);
                listItem.style.color = "white";
                link.id = obj[x].UserName;
                // if instant message file exists direct user to im file
                if( checkImExists(username, obj[x].UserName)) {
                    link.href = "instant_messages.html"; 
                }
                else {
                    // if instant message file does not exist
                    link.onclick = function() {
                        localStorage.setItem("viewInfo", this.id);
                    };
                    link.href = "profile_page.html";
                }
                link.appendChild(text);
                listItem.appendChild(link);
                friendsList.appendChild(listItem);
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
            document.getElementById("profilePic").innerHTML = '<img class="profilePicture" src="'+obj.avatar+'"/>'
            document.getElementById("userName").innerHTML = obj.name;
            if(localStorage.getItem('viewInfo') === localStorage.getItem('username')){
                document.getElementById("email").innerHTML = obj.email;
            } else {
                document.getElementById("email").innerHTML = "hidden";
            }
            document.getElementById("chatCount").innerHTML = obj.chatCount;
            document.getElementById("privateCount").innerHTML = obj.privateCount;
            document.getElementById("friendsCount").innerHTML = obj.friendsCount;
            document.getElementById("otherData").innerHTML = "nothing right now";
        },
        error: function(data) {
            console.log("fail");
        }
    })
})
//adds friend request if valid user
var isNotFriend = false;
function AddFriendButton(e){
    friendName = localStorage.getItem('viewInfo')
    $.when(CheckFriend(friendName)).done(function(a1){
        console.log(isNotFriend)
        if((localStorage.getItem('username') != friendName) && isNotFriend)
        {
            console.log("Calls");
            document.getElementById(e).innerHTML += "<h4><a><u>Add Friend</u></a></h4>";
            document.getElementById(e).onclick = function(){ SendFriendRequest()};
        }
    });

}
//sends friend request to server
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
//add Instant Message if no message created
let isImCreated = false;
function addIM(e) {
    friendName = localStorage.getItem('viewInfo')
    $.when(CheckFriend(friendName)).done(function(a1){
        isImCreated = checkImExists(friendName)
        console.log(isImCreated)
        if((localStorage.getItem('username') != friendName) && !isNotFriend && !isImCreated)
        {
            console.log("Calls");
            document.getElementById(e).innerHTML += "<h4><a><u>Instant Message</u></a></h4>";
           // document.getElementById(e).onclick = function(){ createImFile()};
        }
    });
}
function createImFile() {
    $.ajax({
        type: "post",
        url: "createIM.php",
        data: {username: localStorage.getItem('username'), friendName: localStorage.getItem('viewInfo')},
        success: function(result) {
            //If successful, go to the instant_messages page
            localStorage.setItem('imName', result); // needs to return ID that was created
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/instant_messages.html';
        },
        error: function(result) {
            //If not successful, return to the profile page
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/profile_page.html';
        }
    })
}
function checkImExists(name1, name2) {
    // might be broken
    $.ajax({
        type: "post",
        url: "getIMList.php",
        data: {loggedInUser: name1, otherUser: name2},
        success: function(data) {
            if(data !== -1) {
                localStorage.setItem('imName', data);
                return true;
            } else {
                return false;
            }
        },
        error: function(data) {
            return false;
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
            console.log(names)
            names.sort()
            if(names.indexOf(name) > -1)
            {
                console.log("already friends")
                isNotFriend = false
            }
            else
            {
                console.log("not friends")
                isNotFriend = true
            }
        },
        error: function(data) {
            console.log("fail");
            isNotFriend = false
        }
    })
}
document.addEventListener("DOMContentLoaded", function(event) {
    AddFriendButton('friendZone')
    addIM('imTag')
})