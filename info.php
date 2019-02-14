<?php
  session_start(); // dodawanie sesji (forma metody POST)

  if(!isset($_SESSION['logined']))
  {
    header('Location: index.php');
    exit();
  }

?>

<!DOCUMENT html>
<html>
<head>
  <meta lang="en">
  <title>o ja</title>
</head>
<body>

<?php

  echo "<p>Witaj ".$_SESSION['user']."!</p>";
  echo "<p><strong>Drewno</strong> ".$_SESSION['wood'];
  echo " | <strong>Kamień</strong> ".$_SESSION['rock'];
  echo " | <strong>Zborze</strong> ".$_SESSION['wheat']."</p>";
  echo "<p><strong>email</strong> ".$_SESSION['email']."</p>";
  echo "<p><strong>dni premium</strong> ".$_SESSION['premium']."!</p>";

?>
  <form action="logout.php">
    <input type="submit" value="Logout"/>
  </form>

</body>
</html>
