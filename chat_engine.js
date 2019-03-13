var instanse = false;
var allusers = ["ETHANTESTWITHFILLED"];
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
//DELETE THIS IF STILL NOT WORKING
function userList(newuser, users){
  add = true;
  for(i = 0; i < users.length; i++){
    if(newuser == users[i]){
      add = false;
    }
  }
  return add;
}
//Updates the chat
function updateChat(serverID){
	 if(!instanse){
		 instanse = true;
		 console.log("start update");
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
                            //DELETE THIS IF NOT WORKING
                            // if(userList(str[0], allusers)){
                            //   newstr = "<tr><td>"+str[0]+"</td></tr>";
                            //   allusers.push(str[0]);
                            //   $('#userTable').append($(newstr));
                            // }
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
                //get phrase from tag
                phrase = words[i].substring(1).toLowerCase()
                //check if phrase is valid
                var imgExists = this.imgExists(phrase)
                if(imgExists){
                    //inject code
                    parse += ("<img class='emote' src='emotes/" + phrase.trim() +  ".png' alt='" + phrase.trim() + "' /> ")
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
