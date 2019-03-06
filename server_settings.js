$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "getServerList.php", //"userInfo.php", // getserverlist.php?
        data: {serverName: localStorage.getItem('servername')},
        success: function(data) {
            console.log(data);
            obj = JSON.parse(data);
            console.log(obj);
            document.getElementById("servername").innerHTML = obj.serverName;
        },
        error: function() {
            console.log("fail");
        }
    })
})