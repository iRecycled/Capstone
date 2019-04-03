<html>

<body>
  <h1 id="token"> </h1>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  var TMP = localStorage.getItem('username');
  myObj = { username: TMP}
  $.ajax({
      url: 'TokenGen.php',
      type: 'POST',
      data: var JSON.stringify(myObj);,
      dataType: 'json',
      success: function( token) {
        document.getElementById("token").innerHTML = token;

      }
  });
</script>
</html>
