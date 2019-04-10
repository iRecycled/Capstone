<html>

<body>
  <h1 id="tok"> </h1>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $.ajax({
      url: 'TokenGen.php',
      method: 'POST',
      dataType: 'json',
      data: {username: localStorage.getItem('username')},
      success: function(token) {
        document.getElementById("tok").innerHTML = token;
        console.log(token);
        document.getElementById("APItoken").value = token;
      }
  });
</script>
</html>
