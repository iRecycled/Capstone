//on load of page
$(document).ready(function(){
    document.getElementById('searchDropdown').style.display = 'none';
    //adds welcome message to page
    if(welcome.innerHTML.trim() == "")
    {
        //document.getElementById("welcome").innerHTML += "<h1>Welcome back, " + localStorage.getItem('username') + "!</h1>"; 
    }
    //get list of users servers
    $.ajax({
        type: "post",
        url: "getServerList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            createServerTable(obj, "userServersBody")
        },
        error: function(data) {
            console.log("fail");
        }
    })
    //get list of servers user does not belong to
    /**
    $.ajax({
        type: "post",
        url: "getAllServerList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            createAllServerTable(obj, "allServersBody")
        },
        error: function(data) {
            console.log("fail");
        }
    }) */
    //get list of user's friends
    console.log(localStorage.getItem('username'))
    $.ajax({
        type: "post",
        url: "getFriendsList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            createFriendsList(obj, "friendsListBody")
        },
        error: function(data) {
            console.log("fail");
        }
    })
    $.ajax({
        type: "post",
        url: "getFriendRequests.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            createFriendRequestList(obj, "friendRequestsBody")
        },
        error: function(data) {
            console.log("fail");
        }
    })
    $.ajax({
        type: "post",
        url: "getServerInvites.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            createServerRequestList(obj, "serverRequestsBody")
        },
        error: function(data) {
            console.log("fail");
        }
    })
});
//handles when user accepts server invite
function acceptServerRequest(name)
{
    $.ajax({
        type: "post",
        url: "respondServerInvite.php",
        data: {user: localStorage.getItem('username'), serverName: name, accept: "true"},
        success: function(data) {
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/home.html';
        },
        error: function(data) {
            alert("Failed to accept server request.");
        }
    })
}
//handles when user rejects server invite
function rejectServerRequest(name)
{
    $.ajax({
        type: "post",
        url: "respondServerInvite.php",
        data: {user: localStorage.getItem('username'), serverName: name, accept: "false"},
        success: function(data) {
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/home.html';
        },
        error: function(data) {
            alert("Failed to reject server request.");
        }
    })
}
//generates and injects list of server invites
function createServerRequestList(e, id)
{
    document.getElementById(id).innerHTML = "";
    //generates and sorts list of user names 
    names = []
    for(i = 0; i < e.length; i++){
        names.push(e[i].ServerName)
    }
    names.sort()
    text = "";
    //uses name list to inject table rows
    for(i = 0; i < names.length; i++)
    {
        text +="<tr>\
                    <td class = 'serverEntry'>\
                        <a>\
                        <span style='display: block; padding: 15px;'>\
                        " + names[i] + "\
                        <button class = 'btn btn-success' onclick='acceptServerRequest(\"" + names[i] + "\")'>&#10003</button>\
                        <button class = 'btn btn-danger'onclick='rejectServerRequest(\"" + names[i] + "\")'>X</button>\
                        </span>\
                        </a>\
                    </td>\
                </tr>";
    }
    document.getElementById(id).innerHTML += text;
}
//handles when user accepts friend invite
function acceptFriendRequest(name)
{
    $.ajax({
        type: "post",
        url: "respondFriendRequest.php",
        data: {friend: localStorage.getItem('username'), user: name, accept: "true"},
        success: function(data) {
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/home.html';
        },
        error: function(data) {
            alert("Failed to accept friend request.");
        }
    })
}
//handles when user rejects friend invite
function rejectFriendRequest(name)
{
    $.ajax({
        type: "post",
        url: "respondFriendRequest.php",
        data: {friend: localStorage.getItem('username'), user: name, accept: "false"},
        success: function(data) {
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/home.html';
        },
        error: function(data) {
            alert("Failed to reject friend request.");
        }
    })
}
//generates and injects list of friend invites
function createFriendRequestList(e, id)
{
    document.getElementById(id).innerHTML = "";
    //generates and sorts list of user names 
    names = []
    for(i = 0; i < e.length; i++){
        names.push(e[i].UserName)
    }
    names.sort()
    text = "";
    //uses name list to inject table rows
    for(i = 0; i < names.length; i++)
    {
        text +="<tr>\
                    <td class = 'serverEntry'>\
                        <a>\
                        <span style='display: block; padding: 15px;'>\
                        " + names[i] + "\
                        <button class = 'btn btn-success' onclick='acceptFriendRequest(\"" + names[i] + "\")'>&#10003</button>\
                        <button class = 'btn btn-danger' onclick='rejectFriendRequest(\"" + names[i] + "\")'>X</button>\
                        </span>\
                        </a>\
                    </td>\
                </tr>";
    }
    document.getElementById(id).innerHTML += text;
}
//outputs search results to dropdown
function processSearchResults(names)
{
    console.log(names)
    dropdown = document.getElementById('searchDropdown');
    dropdown.innerHTML = ''
    for(i = 0; i < names.length; i++){
        dropdown.innerHTML+= "<a class='dropdown-item' href = 'profile_page.html' onclick = 'setViewInfo(\""+names[i].UserName+"\")'/>" + names[i].UserName + "</a>";
    }
    document.getElementById('searchDropdown').style.display = 'block';
}
//processes user search function
function searchUser(id){
    name = document.getElementById(id).value
    console.log(name)
    $.ajax({
        type: "post",
        url: "searchForUser.php",
        data: {username: name},
        success: function(data) {
            obj = JSON.parse(data);
            if(obj.length>0){
               processSearchResults(obj)
            }
        },
        error: function(data) {
            console.log("fail");
        }
    })
}

//takes friends list data and injects into HTML
function createFriendsList(d, targetID){
    document.getElementById(targetID).innerHTML = "";
    //generates and sorts list of user names 
    names = []
    for(i = 0; i < d.length; i++){
        names.push(d[i].UserName)
    }
    names.sort()
    text = "";
    //uses name list to inject table rows
    for(i = 0; i < names.length; i++)
    {
        text +="<tr>\
                    <td class = 'serverEntry'>\
                        <a href = 'profile_page.html' onclick = 'setViewInfo(\""+names[i]+"\")'>\
                        <span style='display: block; padding: 15px;'>\
                        " + names[i] + "\
                        </span>\
                        </a>\
                    </td>\
                </tr>";
    }
    document.getElementById(targetID).innerHTML += text;
}
//sets value of view profile page
function setViewInfo(name)
{
    console.log("set");
    localStorage.setItem('viewInfo', name);
}
//takes server list data and injects into HTML
function createServerTable(d, targetID){
    text = "";
    document.getElementById(targetID).innerHTML = "";
    //generates table rows from list of server names
    for(i = 0; i < d.length; i++)
    {
        text +="<tr>\
                    <td class = 'serverEntry'>\
                        <a href = 'chat.html' onclick = setServerID(" + d[i].ServerID + ")>\
                        <span style='display: block; padding: 15px;'>\
                        " + d[i].ServerName + "\
                        </span>\
                        </a>\
                    </td>\
                </tr>";
    }
    document.getElementById(targetID).innerHTML += text;
}

//takes server list data and injects into HTML
function createAllServerTable(d, targetID){
    text = "";
    document.getElementById(targetID).innerHTML = "";
    //generates table rows from list of server names
    for(i = 0; i < d.length; i++)
    {
        text +="<tr>\
                    <td class = 'serverEntry' onclick = sendServerRequest(" + d[i].ServerID + ")>\
                        " + d[i].ServerName + "\
                    </td>\
                </tr>";
    }
    document.getElementById(targetID).innerHTML += text;
}
//sets the server id to enter chat
function setServerID(id){
    localStorage.setItem("serverID", id);
}
//sends a request to a new server
function sendServerRequest(id){
    /*
    $.ajax({
        type: "post",
        url: "sendServerRequest.php",
        data: {requestID: id, username: localStorage.getItem('username')},
        success: function(data) {
            document.getElementById("servers").innerHTML += "\
            <div class='alert alert-success'>\
                <strong>Success!</strong> Indicates a successful or positive action.\
            </div>";
        },
        error: function(data) {
            document.getElementById("servers").innerHTML += "\
            <div class='alert alert-info'>\
                <strong>Info!</strong> Indicates a neutral informative change or action.\
            </div>";
        }
    })
    */
}
//hides dropdown if focus lost
$('html').click(function(e) {         
    if(!(e.target.id == 'searchButton') && !(e.target.className == 'btn'))
    {
        document.getElementById('searchDropdown').style.display = 'none';
    }
 }); 
