$(document).ready(function(){
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
    $.ajax({
        type: "post",
        url: "getAllServerList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            console.log(obj)
            createServerTable(obj, "allServersBody")
        },
        error: function(data) {
            console.log("fail");
        }
    })
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

function createFriendsList(d, targetID){
    names = []
    for(i = 0; i < d.length; i++){
        names.push(d[i].UserName)
    }
    names.sort()
    text = "";
    for(i = 0; i < names.length; i++)
    {
        text +="<tr>\
                    <td class = 'serverEntry'>\
                        " + names[i] + "\
                    </td>\
                </tr>";
    }
    document.getElementById(targetID).innerHTML += text;
}

function createServerTable(d, targetID){
    text = "";
    for(i = 0; i < d.length; i++)
    {
        text +="<tr>\
                    <td class = 'serverEntry'>\
                        " + d[i].ServerName + "\
                    </td>\
                </tr>";
    }
    document.getElementById(targetID).innerHTML += text;
}
