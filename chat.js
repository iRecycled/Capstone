function submitText(){

    text = chatInputArea.value
    chatInputArea.value = ''
    text = parseText(text)
    text = generateMsg(text, "", "")
    chatOutputArea.innerHTML += text
    resetScroll();
}

function UrlExists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}

function parseText(text){
    var safe = text.replace(/</g, '&lt;')
    var safe = safe.replace(/>/g, '&gt;')
    var words = safe.split(" ")
    var parse = ""
    for(var i = 0; i < words.length; i+=1){
        if(words[i].charAt(0) == ':')
        {
            var imgExists = UrlExists("emotes/" + words[i].substring(1) +  ".png")
            if(imgExists){
                parse += ("<img class='emote' src=emotes/" + words[i].substring(1) +  ".png alt='" + words[i].substring(1) + "' /> ")
            }
            else{
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

function generateMsg(text, sender, time)
{
    var username = "Username"
    var today = new Date();
    msg = "\
    <tr>\
        <td style='vertical-align: top;'>\
            <div class='message'>\
            <p class ='msgUname'>"
                + username
                + "<span class='msgDate'>"
                    + today.getMonth() + '-' +  today.getDay() + '-' + today.getFullYear() + ' ' + today.getHours() + ':' + ('0'+today.getMinutes()).slice(-2) + '</span>'
            + "</p>"  
            + text + "\
            </div>\
        </td>\
    </tr>"
    return msg
}

function resetScroll(){
    chatOutputBox.scrollTop =  chatOutputBox.scrollHeight - chatOutputBox.clientHeight;
} 

document.addEventListener("DOMContentLoaded", function(event) { 
    
    submitButton = document.getElementById("chatTextSubmit")
    chatInputArea = document.getElementById("chatTextArea")
    chatOutputArea = document.getElementById("chatBody")
    chatOutputBox = document.getElementById("chatOutput")

    
    submitButton.addEventListener("click", submitText)

});