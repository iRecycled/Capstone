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

function InsertImage(e)
{
    var url = e.value.trim();
    if(url.substring(0,8).toLowerCase().indexOf("https")>-1)
    {
        url = url.substring(8)
    }
    else if(url.substring(0,8).toLowerCase().indexOf("http")>-1)
    {
        url = url.substring(7)
    }
    if(url.substring(url.length-4).valueOf() == '.jpg' || url.substring(url.length-4).valueOf() == '.png' || url.substring(url.length-4).valueOf() == '.gif'){
        chatInputArea.value += ':img="'+ url + '"'
    }
}

function InsertVid()
{
    var url = document.getElementById("vidURL").value;
    if(url.substring(0,8).toLowerCase().indexOf("https")>-1)
    {
        url = url.substring(8)
    }
    else if(url.substring(0,8).toLowerCase().indexOf("http")>-1)
    {
        url = url.substring(7)
    }
    id = YouTubeGetID(url)    
    if(id.length == 11){
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
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
}

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

function setViewName(name){
    localStorage.setItem("viewInfo", name);
}

//takes message data and generates the table rows in the document
function generateMsg(text, sender, time)
{
    var username = sender;

    //creates html code
    msg = "\
    <tr id = 'singleMessage'>\
        <td style='vertical-align: top;'>\
            <div class='message'>\
             <p class ='msgUname'>\
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
                if (phrase.substring(0,3).valueOf()=="img")
                {
                    imgUrl = phrase.substring(4)
                    imgUrl = imgUrl.replace(/&quot;/g, '')
                    endTag = imgUrl.substring(imgUrl.length-4)
                    if(endTag.valueOf() == '.jpg' || endTag.valueOf() == '.png' || endTag.valueOf() == '.gif')
                    {
                        parse += ("<img src='https://" + imgUrl + "' alt='userimg' class='msgImg'/>")
                    }
                }
                else if (phrase.substring(0,3) == "ytb")
                {
                    imgUrl = phrase.substring(4)
                    imgUrl = imgUrl.replace(/&quot;/g, '')
                    id = YouTubeGetID(imgUrl)
                    if(id.length == 11)
                    {
                        parse += '<iframe class="msgImg" width="560" height="350" src="https://www.youtube.com/embed/' + id + '" frameborder="0" allowfullscreen></iframe>';
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

function UpdatePreview(){
    url = ""
    url += document.getElementById("vidURL").value;
    id = YouTubeGetID(url)
    if(id.length==11)
    {
        document.getElementById("videoPreview").innerHTML = ""
        document.getElementById("videoPreview").innerHTML += "ID: " + id ;
        document.getElementById("videoPreview").innerHTML += '<div><iframe width="300" height="200" src="https://www.youtube.com/embed/' + id + '" frameborder="0" allowfullscreen></iframe></div>';
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


$("#insertContentDialog").on('hidden.bs.modal', function () {
    console.log("hides")
    document.getElementById("inputURL").value = ""
    document.getElementById("vidURL").value = ""
})