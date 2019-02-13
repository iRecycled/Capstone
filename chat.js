function submitText(){
    if (!chatInputArea.value.replace(/\s/g, '').length) {
        return false;
    }
    else{
        
        var parse = new msgParse();
        text = chatInputArea.value
        chatInputArea.value = ''
        text = parse.parse(text)
        text = generateMsg(text, "", "")
        chatOutputArea.innerHTML += text
        resetScroll();
    }
}

function addEmote(e)
{
    var n = e.innerHTML.lastIndexOf('>');
    var result = e.innerHTML.substring(n + 1);
    chatInputArea.value += result
}

function generateEmoteList(e)
{
    eList = emoteWL.sort()
    for(i = 0; i < eList.length; i++ )
    {
        e.innerHTML+= "<a class='dropdown-item' onclick='addEmote(this)'><img class='emote' src = 'emotes/" + eList[i] + ".png'/> :" +  eList[i] + "</a>"
        console.log("fart")
    }
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
                    + today.getMonth() + '-' +  today.getDate() + '-' + today.getFullYear() + ' ' + today.getHours() + ':' + ('0'+today.getMinutes()).slice(-2) + '</span>'
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
    generateEmoteList(document.getElementById("emoteDropdown"))
});