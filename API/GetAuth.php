<html>

<body>
  <h1 id="token"> </h1>
</body>
<script src="jquery-3.3.1.min.js"></script>
<script>
  var TMP = localStorage.getItem('username');

  $.ajax({
      url: 'TokenGen.php',
      type: 'POST',
      data: TMP.serialize(),
      dataType: 'json',
      success: function( token) {
        document.getElementById("token").innerHTML = token;

      }
  });
</script>
</html>
