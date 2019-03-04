//on load of page
$(document).ready(function(){
    //adds welcome message to page
    if(welcome.innerHTML.trim() == "")
    {
        document.getElementById("welcome").innerHTML += "<h1>Welcome back, " + localStorage.getItem('username') + "!</h1>"; 
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
    })
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
});
//takes friends list data and injects into HTML
function createFriendsList(d, targetID){
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
                    <td class = 'serverEntry' >\
                        " + names[i] + "\
                    </td>\
                </tr>";
    }
    document.getElementById(targetID).innerHTML += text;
}
//takes server list data and injects into HTML
function createServerTable(d, targetID){
    text = "";
    //generates table rows from list of server names
    for(i = 0; i < d.length; i++)
    {
        text +="<tr>\
                    <td class = 'serverEntry' href = 'chat.html' onclick = setServerID(" + d[i].ServerID + ")>\
                        " + d[i].ServerName + "\
                    </td>\
                </tr>";
    }
    document.getElementById(targetID).innerHTML += text;
}

//takes server list data and injects into HTML
function createAllServerTable(d, targetID){
    text = "";
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

function setServerID(id){
    localStorage.setItem("serverID", id);
}

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
