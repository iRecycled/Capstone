$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "getServerList.php", //"userInfo.php", 
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            document.getElementById("servername").innerHTML = obj[0].ServerName;
        },
        error: function() {
            console.log("fail");
        }
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
                let memberList = document.getElementById("UserList");
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
        },
        error: function(data) {
            console.log("fail");
        }
    })
})