      //code to check if the local storage information is correct
            $.ajax({
               method:'post',
               dataType: "json",
               url: 'checkID.php',
              data: {username: localStorage.getItem('username')},
              success: function(data) {
              if(data==localStorage.getItem("sessionID")){
                if(localStorage.getItem('username').length==0){
                  localStorage.setItem("username","oheystopmesingaround")
                  localStorage.setItem("sessionID","-1")
                 
                }
                else{
                  //login is correct upon loading of this webpage and automatically goes to the home page
                window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/chat.html';
                }
              }
              else{
                
                if(localStorage.getItem('username').length==0){
                  localStorage.setItem("username","oheystopmesingaround")
                  localStorage.setItem("sessionID","-1")
                
                }
                else{
                  localStorage.setItem("username","oheystopmesingaround")
                  localStorage.setItem("sessionID","-1")
                  
                }

              }
            }
             });
username=localStorage.getItem('username');