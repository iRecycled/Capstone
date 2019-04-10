var instanse = false;
var allusers = [];
var state;
var mes;
var file;
//injects the emote code into the text area
function addEmote(e)
{
    var n = e.innerHTML.lastIndexOf('>')
    var result = e.innerHTML.substring(n + 1)
    chatInputArea.value += result
}
//generates the list for the emote widget
function generateEmoteList(e)
{
    eList = emoteWL.sort()
    //for each emote in whitelist
    for(i = 0; i < eList.length; i++ )
    {
        e.innerHTML+= "<a class='dropdown-item' onclick='addEmote(this)'><img class='emote' src = 'emotes/" + eList[i] + ".png'/> :" +  eList[i] + "</a>"
    }
}
//generates a valid img message and injects into chat
function InsertImage(e)
{
    //sterilizes url
    var url = e.value.trim();
    if(url.substring(0,8).toLowerCase().indexOf("https")>-1)
    {
        url = url.substring(8)
    }
    else if(url.substring(0,8).toLowerCase().indexOf("http")>-1)
    {
        url = url.substring(7)
    }
    //check if url is valid
    if(url.substring(url.length-4).valueOf() == '.jpg' || url.substring(url.length-4).valueOf() == '.png' || url.substring(url.length-4).valueOf() == '.gif'){
        //create and inject img message into chat
        chatInputArea.value += ':img="'+ url + '"'
    }
}
//generates a valid ytb message and injects into chat
function InsertVid()
{
    //get youtube url
    var url = document.getElementById("vidURL").value;
    //sterilize url
    if(url.substring(0,8).toLowerCase().indexOf("https")>-1)
    {
        url = url.substring(8)
    }
    else if(url.substring(0,8).toLowerCase().indexOf("http")>-1)
    {
        url = url.substring(7)
    }
    //generate id
    id = YouTubeGetID(url)
    //ensure id is valid  
    if(id.length == 11){
        //inject valid ytb message
        chatInputArea.value += ':ytb="youtu.be/' +  id + '"'
    }

}

//sets functions when the document loads
document.addEventListener("DOMContentLoaded", function(event) {

    submitButton = document.getElementById("chatTextSubmit")
    chatInputArea = document.getElementById("sendie")
    chatOutputArea = document.getElementById("chatBody")
    chatOutputBox = document.getElementById("chatOutput")
    
    //create emote list for dropdown
    generateEmoteList(document.getElementById("emoteDropdown"))
});

function Chat () {
    if(window.location.href.indexOf('_messages.html') > 0) {
        this.update = updateChatIm;
        this.send = sendChatIm;
        this.getState = getStateOfChatIm;
    } else {
        this.update = updateChat;
        this.send = sendChat;
        this.getState = getStateOfChat;
    }
}

if(window.location.href.indexOf('_messages.html') > 0) {
    //gets the state of the chat
    function getStateOfChatIm(fileID){
        if(!instanse){
            instanse = true;
            $.ajax({
                type: "POST",
                url: "loadIM.php",
                data: {
                    'function': 'getState',
                    'file': fileID
                },
                dataType: "json",

                success: function(data){
                    state = data.state;
                    instanse = false;
                },
            });
        }
    }

    //Updates the chat
    function updateChatIm(fileID){
        if(!instanse){
            instanse = true;
            //console.log("start update");
            $.ajax({
                type: "POST",
                url: "loadIM.php",
                data: {
                        'function': 'update',
                            'state': state,
                            'file': fileID
                            },
                dataType: "json",
                success: function(data){
                    if(data.text){
                            for (var i = 0; i < data.text.length; i++) {
                                //data.text[i] = msgParse(data.text[i]);
                                var parse = new msgParse();
                                var str = data.text[i].split("<");
                                console.log("original string:"+data.text[i]);
                                data.text[i] = parse.parse(str[2]);
                                console.log(data.text[i]);
                                //console.log(generateMsg(data.text[i],"",""));
                                console.log(str[1]);
                                data.text[i] = generateMsg(data.text[i], str[0], str[1]);
                                console.log(data.text[i]);
                                $('#chatBox').append($(data.text[i]));
                                document.getElementById('chatOutput').scrollTop = document.getElementById('chatOutput').scrollHeight;
                            }
                    }

                    instanse = false;
                    state = data.state;
                },
                });
        }
        else {
            setTimeout(updateChat, 1500);
        }
    }
    //send the message
    function sendChatIm(message, nickname, fileID)
    {
        updateChatIm(fileID);
        console.log("sent successfully");
        var today = new Date();
        var tmp = today.getMonth()+1;
        var time = tmp + '-' +  today.getDate() + '-' + today.getFullYear() + ' ' + today.getHours() + ':' + ('0'+today.getMinutes()).slice(-2);
        $.ajax({
            type: "POST",
            url: "loadIM.php",
            data: {
                    'function': 'send',
                        'message': message,
                        'nickname': nickname,
            'time': time,
                        'file': fileID
                    },
            dataType: "json",
            success: function(data){
                updateChatIm(fileID);
            },
            });
    }
} else {
    //gets the state of the chat
    function getStateOfChat(serverID){
        if(!instanse){
            instanse = true;
            $.ajax({
                type: "POST",
                url: "process.php",
                data: {
                            'function': 'getState',
                            'file': serverID
                            },
                dataType: "json",

                success: function(data){
                    state = data.state;
                    instanse = false;
                },
                });
        }
    }

    //Updates the chat
    function updateChat(serverID){
        if(!instanse){
            instanse = true;
            //console.log("start update");
            $.ajax({
                type: "POST",
                url: "process.php",
                data: {
                        'function': 'update',
                            'state': state,
                            'file': serverID
                            },
                dataType: "json",
                success: function(data){
                    if(data.text){
                            for (var i = 0; i < data.text.length; i++) {
                                //data.text[i] = msgParse(data.text[i]);
                                var parse = new msgParse();
                                var str = data.text[i].split("<");
                                console.log("original string:"+data.text[i]);
                                data.text[i] = parse.parse(str[2]);
                                console.log(data.text[i]);
                                //console.log(generateMsg(data.text[i],"",""));
                                console.log(str[1]);
                                data.text[i] = generateMsg(data.text[i], str[0], str[1]);
                                console.log(data.text[i]);
                                $('#chatBox').append($(data.text[i]));
                                document.getElementById('chatOutput').scrollTop = document.getElementById('chatOutput').scrollHeight;
                            }
                    }

                    instanse = false;
                    state = data.state;
                },
                });
        }
        else {
            setTimeout(updateChat, 1500);
        }
    }
    //send the message
    function sendChat(message, nickname, serverID)
    {
        updateChat(serverID);
        console.log("sent successfully");
        var today = new Date();
        var tmp = today.getMonth()+1;
        var time = tmp + '-' +  today.getDate() + '-' + today.getFullYear() + ' ' + today.getHours() + ':' + ('0'+today.getMinutes()).slice(-2);
        $.ajax({
            type: "POST",
            url: "process.php",
            data: {
                    'function': 'send',
                        'message': message,
                        'nickname': nickname,
            'time': time,
                        'file': serverID
                    },
            dataType: "json",
            success: function(data){
                updateChat(serverID);
            },
            });
    }
}
//changes local storage value for viewname
function setViewName(name){
    localStorage.setItem("viewInfo", name);
}

//takes message data and generates the table rows in the document
function generateMsg(text, sender, time)
{
    var avatar = ""
    var username = sender;
    $.ajax({
        type: "post",
        url: "getUserAvatar.php",
        data: {username: username},
        async: false,
        success: function(data) {
            obj = JSON.parse(data);
            avatar = obj[0].Avatar;
        },
        error: function(data) {
            console.log("fail");
        }
    })
    //creates html code
    msg = "\
    <tr id = 'singleMessage'>\
        <td style='vertical-align: top;'>\
            <div class='message'>\
             <p class ='msgUname'>\
             <img class='avatar' src='"+avatar+"'/>\
             <a id='unameLink' href='profile_page.html' onclick=setViewName('" + username + "')>"
                 + username
                 + "</a>\
                 <span class='msgDate'>"
                     + time + '</span>'
             + "</p>"
            + text + "\
            </div>\
        </td>\
    </tr>"
    return msg
}
//white list for all emote tags
var emoteWL = [
    "jordan",
    "howdy",
    "pogchamp",
    "beaker",
    "kappa",
    "squiddab",
    "terry",
    "bob",
    "hoops",
    "rip",
    "zoboomafoo",
    "manningface",
    "codered",
    "tiger",
    "triforce"
]
//inputs a url and returns youtube id
function YouTubeGetID(url){
    var ID = '';
    url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    if(url[2] !== undefined) {
      ID = url[2].split(/[^0-9a-z_\-]/i);
      ID = ID[0];
    }
    else {
      ID = url;
    }
      return ID;
  }

//parses messages for emotes/html tags
function msgParse(){
    this.parse = function(text){
        console.log("calls")
        //strip html tags
        var safe = text.replace(/</g, '&lt;')
        var safe = safe.replace(/>/g, '&gt;')
        var words = safe.split(" ")
        var parse = ""
        for(var i = 0; i < words.length; i+=1){
            //if word has emote tag
            if(words[i].charAt(0) == ':')
            {
                console.log(words[i])
                //get phrase from tag
                phrase = words[i].substring(1).trim()
                //check if phrase is valid
                var imgExists = this.imgExists(phrase.toLowerCase())
                //check if phrase is img tag
                if (phrase.substring(0,3).valueOf()=="img")
                {
                    //remove tag
                    imgUrl = phrase.substring(4)
                    //remove quotes
                    imgUrl = imgUrl.replace(/&quot;/g, '')
                    //check if img is valid
                    endTag = imgUrl.substring(imgUrl.length-4)
                    if(endTag.valueOf() == '.jpg' || endTag.valueOf() == '.png' || endTag.valueOf() == '.gif')
                    {
                        //inject image object with source
                        parse += ("<img src='https://" + imgUrl + "' alt='userimg' class='msgImg'/>")
                    }
                }
                //check if phrase is ytb tag
                else if (phrase.substring(0,3) == "ytb")
                {
                    //remove tag
                    imgUrl = phrase.substring(4)
                    //remove quotes
                    imgUrl = imgUrl.replace(/&quot;/g, '')
                    //get youtube id
                    id = YouTubeGetID(imgUrl)
                    //if id is valid
                    if(id.length == 11)
                    {
                        //inject youtube embed
                        parse += '<iframe class="msgImg" width="560" height="350" src="https://www.youtube.com/embed/' + id + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    }
                }
                else if(imgExists){
                    //inject code
                    parse += ("<img class='emote' src='emotes/" + phrase.trim().toLowerCase() +  ".png' alt='" + phrase.trim().toLowerCase() + "' /> ")
                }
                else{
                    //else keep phrase but do not inject code
                    parse += (words[i] + " ")
                }
            }

            else
            {
                parse += (words[i] + " ")
            }
        }
        return parse;

    }

    this.imgExists = function(img)
    {
        //ensure whitespace/newlines arent present
        imgTrim = img.toString().trim()
        //check if phrase is in whitelist
        if((emoteWL.indexOf(imgTrim.toString()) > -1)){
            //check if file is in directory
            var http = new XMLHttpRequest();
            http.open('HEAD', "emotes/" + imgTrim +  ".png", false);
            http.send();
            console.log('true');
            return http.status!=404;

        }
        else{
	    console.log('false');
            return false;
        }
    }
}
//change youtube preview window
function UpdatePreview(){
    url = ""
    url += document.getElementById("vidURL").value;
    //get id from url
    id = YouTubeGetID(url)
    //if id is valid
    if(id.length==11)
    {
        //add embed
        document.getElementById("videoPreview").innerHTML = ""
        document.getElementById("videoPreview").innerHTML += "ID: " + id ;
        document.getElementById("videoPreview").innerHTML += '<div><iframe width="300" height="200" src="https://www.youtube.com/embed/' + id + '"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"  allowfullscreen></iframe></div>';
    }
    else
    {
        //do not add embed
        document.getElementById("videoPreview").innerHTML = ""
        document.getElementById("videoPreview").innerHTML += "ID: ";
    }
}


