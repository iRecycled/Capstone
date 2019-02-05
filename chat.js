function submitText(){
    text = chatInputArea.value

    text = parseText(text)
    text = generateMsg(text, "", "")
    chatOutputArea.innerHTML += text
    resetScroll();
}

function parseText(text){

    return text;
}

function generateMsg(text, sender, time)
{
    var username = "Cool Guy"
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