      //code to check if the local storage information is correct
      $.ajax({
        method:'post',
        dataType: "json",
        url: 'checkID.php',
       data: {username: localStorage.getItem('username')},
       success: function(data) {
       if(data==localStorage.getItem("sessionID")){
         if(localStorage.getItem('username').length==0){
          localStorage.clear();
           window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/index.html';
         }
         else{
           //login is correct upon loading of this webpage and automatically goes to the home page
         //window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/chat.html';
         username=localStorage.getItem('username');
         }
       }
       else{
        localStorage.clear();
           window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/index.html';
       }
     }

      });
      $.ajax({
        method:'post',
        dataType: "json",
        url: 'getAllInfo.php',
       data: {username: localStorage.getItem('username')},
       success: function(data) {
       console.log(data)
     }
      });
      function Logout(){
        localStorage.clear();
        window.location.href = 'http://144.13.22.61/CS458SP19/Team1/Capstone/index.html';
      }