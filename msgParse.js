
var emoteWL = [
    "jordan",
    "howdy",
    "pogchamp",
    "beaker",
    "kappa",
    "squiddab"
]

function msgParse(){
    this.parse = function(text){
        console.log("calls")
        var safe = text.replace(/</g, '&lt;')
        var safe = safe.replace(/>/g, '&gt;')
        var words = safe.split(" ")
        var parse = ""
        for(var i = 0; i < words.length; i+=1){
            if(words[i].charAt(0) == ':')
            {
                phrase = words[i].substring(1).toLowerCase()
                var imgExists = this.imgExists(phrase)
                if(imgExists){
                    parse += ("<img class='emote' src=emotes/" + phrase +  ".png alt='" + phrase + "' /> ")
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
    this.imgExists = function(img)
    {
        if((emoteWL.indexOf(img) > -1)){
            var http = new XMLHttpRequest();
            http.open('HEAD', "emotes/" + img +  ".png", false);
            http.send();
            return http.status!=404;
        }
        else{
            return false;
        }
    }
}