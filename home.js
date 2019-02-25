$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "getServerList.php",
        data: {username: localStorage.getItem('username')},
        success: function(data) {
            obj = JSON.parse(data);
            createServerTable(obj, "userServersBody")
        },
        error: function(data) {
            console.log("fail");
        }
    })
});

function createServerTable(d, targetID){
    text = "";
    for(i = 0; i < d.length(); i++)
    {
        text +="<tr>\
                    <td>\
                        " + d[i].ServerName + "\
                    </td>\
                <tr>";
    }
    document.getElementById(targetID).innerHTML += text;
}
