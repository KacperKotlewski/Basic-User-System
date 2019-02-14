<?php
  session_start(); // dodawanie sesji (forma metody POST)

  if(isset($_SESSION['logined']) && $_SESSION['logined']==true)
  {
    header('Location: info.php');
    exit(); //dzięki temu reszta linijek kodu sie nie wykona
  }

?>
<!DOCUMENT html>
<html>
<head>
  <meta lang="en">
  <title>o ja</title>
</head>
<body>
  <form action="login.php" method="post">
    login:
    <br> <input type="text" name="login"/> <br>
    password:
    <br> <input type="password" name="password" id="pass"/> <br>
    <input type="submit" value="Login"/> or
    <input type="submit" value="Register" formaction="register.php"/>
  </form>
<?php

  if(isset($_SESSION['LoginError']))
    echo $_SESSION['LoginError'];

?>
</body>
</html>
