    $(document).ready(function(){
        $.ajax({
            type: "post",
            url: "getServerInfo.php", 
            data: { serverID: localStorage.getItem('serverID')
            },
            success: function(data) {
                    obj = JSON.parse(data);
                    console.log(obj);
                    document.getElementById("servername").appendChild(obj[0].ServerName); //.innerHTML = obj[0].ServerName;
                    
                    console.log(data);

                    // Get classes
                    ServerName = document.getElementsByClassName("servername");
                    
                    console.log(ServerName);

                    // Place servername into each class
                    for(let i = 0; i < ServerName.length; i++) {
                        ServerName[i].innerHTML = data;
                    }

                    // create user list
                    /*
                    createUL(obj, "UserList");*/
                
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
                createSidebarChats(obj, "chatSidebar");
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
        // Gets all server lists
        /*$.ajax({
            type: "post",
            url: "getAllServerList.php",
            data: {username: localStorage.getItem('username')},
            success: function(data) {
                obj = JSON.parse(data);
                //console.log(data)
            
                // populate sidebar with chats
                createSidebar(obj, "chatSidebar");
                // populate server info
                getServerInfo(obj, "ServerInfo");
            },
            error: function(data) {
                console.log("fail");
            }
        })*/
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
            let link = document.createElement("a");
            let text = document.createTextNode(obj[x].ServerName);
            link.id = obj[x].ServerID;
            link.onclick = function() {
                localStorage.setItem("serverID", this.id);
                localStorage.setItem("servername", this.ServerName);
                // CHANGE ON CLICK IN CHAT.HTML
                console.log(`obj Server name ${obj[x].ServerName}`);
                console.log(`this Server name ${this.ServerName}`);
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
            let list = document.createElement("li");
            let link = document.createElement("a");
            let text = document.createTextNode(obj[x].UserName);
            //link.id = obj[x].ServerID;
            console.log(`obj name ${obj[x].UserName}`);
            link.onclick = function() {
                localStorage.setItem("viewInfo", obj[x].UserName);
                // CHANGE ON CLICK IN CHAT.HTML
                console.log(`obj name ${obj[x].UserName}`);
                console.log(`this name ${this.UserName}`);
            };

            link.href = "profile_page.html";
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