$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "getServerList.php", //"userInfo.php", 
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            //document.getElementById("servername").appendChild(obj[0].ServerName); //.innerHTML = obj[0].ServerName;
            let servername = document.getElementsByClassName("servername");

           

            servername.foreach(function(element) {
                console.log(element);
                element.appendChild(obj[0].ServerName);
            });
            
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
        
            createSidebarChats(obj, "chatSidebar");
            getServerInfo(obj, "ServerInfo");
        },
        error: function(data) {
            console.log("fail");
        }
    })
});

function createUL(obj, id) {
    for(let x in obj) {
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
    for(let x in obj) {
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

    let serverName = document.createTextNode(localStorage.getItem('servername'));
    let serverID = document.createTextNode(localStorage.getItem('serverID'));
    //let memberList = document.getElementById(id);
    let servername = document.getElementById('serverInfoServerName');
    let serverid = document.getElementById('serverInfoServerID');

    // obj = [{
    //     ServerName: localStorage.getItem('servername'), 
    //     ServerID: localStorage.getItem('serverID')
    // }]
    
    servername.appendChild(serverName);
    serverid.appendChild(serverID);
        
}