$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "getServerInfo.php", 
        data: { serverID: localStorage.getItem('serverID')
        },
        success: function(data) {
            obj = JSON.parse(data);
            // Get classes
            ServerName = document.getElementsByClassName("servername");                    

            // Place servername into each class
            for(let i = 0; i < ServerName.length; i++) {
                ServerName[i].innerHTML = obj;
            }
            // place serverID in ServerInfo
            //document.getElementById("serverInfoServerID").createTextNode(serverID);
            
        },
        error: function() {
            console.log("fail");
        }
    })
    //get list of members of current server
    $.ajax({
        type: "post",
        url: "getServerMembers.php", 
        data: { serverID: localStorage.getItem('serverID')
        },
        success: function(data) {
                obj = JSON.parse(data);
                console.log(obj);


                createUL(obj, "UserList");
        },
        error: function() {
            console.log("fail");
        }
    })
    //get list of blocked users of current server
    $.ajax({
        type: "post",
        url: "getBlockedUsers.php", 
        data: { serverID: localStorage.getItem('serverID')
        },
        success: function(data) {
                obj = JSON.parse(data);
                console.log(obj);


                createUL(obj, "BlockList");
        },
        error: function() {
            console.log("fail");
        }
    })
    //get list of users servers
    $.ajax({
        type: "post",
        url: "getServerList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            createSidebarChats(obj, "sidebarServers");
            //createServerTable(obj, "userServersBody")
        },
        error: function(data) {
            console.log("fail");
        }
    })
    //get list of user's friends
    $.ajax({
        type: "post",
        url: "getFriendsList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            createSidebarFriends(obj, "sidebarFriends")
        },
        error: function(data) {
            console.log("fail");
        }
    }) 
    $("#removeUser").click(function(e){
        e.preventDefault();
        $.ajax({
        type: "post",
        url: "removeUser.php",
        data: {serverID: localStorage.getItem("serverID"), username: document.getElementById("userToRemove").value},
        success: function(data) {
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/server_settings.html';
        },
        error: function(data) {
            console.log(data);
        }
    })
})
    $("#unblockUser").click(function(e){
        e.preventDefault();
        $.ajax({
        type: "post",
        url: "unblockUser.php",
        data: {user: document.getElementById("unblockUserTxt").value, serverID: localStorage.getItem("serverID")},
        success: function(data) {
            console.log("success");
        },
        error: function(data) {
            console.log("fail");
        }
    })
})
    $("#blockUserBtn").click(function(e){
        e.preventDefault();
        $.ajax({
        type: "post",
        url: "blockUser.php",
        data: {user: document.getElementById("blockUserTxt").value, serverID: localStorage.getItem("serverID")},
        success: function(result) {
            window.location.href = 'http://144.13.22.48/CS458SP19/Team1/Capstone/server_settings.html';
        },
        error: function(result) {
            console.log("fail");
        }
    })
    })  
});

function createUL(obj, id) {
    for(let x in obj) {
        let memberList = document.getElementById(id);
        let scrollbarDiv = document.createElement("div");
        let list = document.createElement("ul");
        let text = document.createTextNode(obj[x].UserName);
        
        // <div id="ScrollbarRow">
        // <ul>user1</ul>
        // <ul>user2</ul>
        // <ul>user3</ul>

        list.appendChild(text);
        scrollbarDiv.appendChild(list);
        memberList.appendChild(scrollbarDiv);
    }
}

function createSidebarChats(obj, id) {
    for(let x in obj) {
        let memberList = document.getElementById(id);
        let list = document.createElement("li");
        let link = document.createElement("a");
        let text = document.createTextNode(obj[x].ServerName);
        link.id = obj[x].ServerID;
        link.onclick = function() {
            localStorage.setItem("serverID", this.id);
            localStorage.setItem("servername", this.ServerName);
        };

        link.href = "chat.html";
        link.appendChild(text);
        list.appendChild(link);
        memberList.appendChild(list);
    }
}

function createSidebarFriends(obj, id) {
    for(let x in obj) {
        let memberList = document.getElementById(id);
        let list = document.createElement("ul");
        let link = document.createElement("a");
        let text = document.createTextNode(obj[x].UserName);
        //link.id = obj[x].ServerID;
        console.log(`obj name ${obj[x].UserName}`);
        link.onclick = function() {
            localStorage.setItem("viewInfo", obj[x].UserName);
        };

        link.href = "profile_page.html";
        link.appendChild(text);
        list.appendChild(link);
        memberList.appendChild(list);
    }
}