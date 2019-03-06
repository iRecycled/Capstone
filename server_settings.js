$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "getServerList.php", //"userInfo.php", 
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            document.getElementById("servername").innerHTML = obj[0].ServerName;
            
            for( var x in obj) {
                let memberList = document.getElementById("UserList");
                let scrollbarDiv = document.createElement("div");
                let list = document.createElement("ul");
                let text = document.createTextNode(obj[x].user);
                

                // <div id="ScrollbarRow">
                // <ul>user1</ul>
                // <ul>user2</ul>
                // <ul>user3</ul>
                list.appendChild(text);
                scrollbarDiv.appendChild(list);
                memberList.appendChild(scrollbarDiv);
            }
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
            //createAllServerTable(obj, "allServersBody")
        },
        error: function(data) {
            console.log("fail");
        }
    })
})