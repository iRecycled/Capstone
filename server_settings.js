$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "getServerList.php", //"userInfo.php", 
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            document.getElementById("servername").innerHTML = obj[0].ServerName;
            
            createUL(obj, "UserList");
            
        },
        error: function() {
            console.log("fail");
        }
    })

    $.ajax({
        type: "post",
        url: "getAllServerList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)

            createSidebarChats(obj, "chatSidebar");
            getServerInfo(obj, "ServerInfo");
        },
        error: function(data) {
            console.log("fail");
        }
    })
});

function createUL(obj, id) {
    for( var x in obj) {
        let memberList = document.getElementById(id);
        let scrollbarDiv = document.createElement("div");
        let list = document.createElement("ul");
        let text = document.createTextNode(obj[x].username);
        
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
    for( var x in obj) {
        let memberList = document.getElementById(id);
        let list = document.createElement("li");
        let link = document.createElement("a")
        let text = document.createTextNode(obj[x].ServerName);
        link.id = obj[x].ServerID;
        link.onclick = function() {
            localStorage.setItem("serverID", this.id);
        };

        link.href = "chat.html";
        link.appendChild(text);
        list.appendChild(link);
        memberList.appendChild(list);
    }
}

function getServerInfo(obj, id) {

    let serverName = document.createTextNode(obj[0].ServerName);
    let serverID = document.createTextNode(obj[0].ServerID);
    let memberList = document.getElementById(id);
    let list = document.createElement("li");
    

    list.appendChild(serverName);
    list.appendChild(serverID);

    // link.appendChild(text);
    // list.appendChild(link);
    memberList.appendChild(list);
    
}