function submitText(){
    text = chatInputArea.value

    text = parseText(text)
    text = generateMsg(text, "", "")
    chatOutputArea.innerHTML += text
}

function parseText(text){
    return text
}

function generateMsg(text, sender, time)
{
    msg = "\
    <tr>\
        <td>" + text + "\
        </td>\
    </tr>"
    return msg
}

document.addEventListener("DOMContentLoaded", function(event) { 
    
    submitButton = document.getElementById("chatTextSubmit")
    chatInputArea = document.getElementById("chatTextArea")
    chatOutputArea = document.getElementById("chatBody")
    

    
    submitButton.addEventListener("click", submitText)

});