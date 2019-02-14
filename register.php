<?php
  session_start(); // dodawanie sesji (forma metody POST)

  if(isset($_SESSION['logined']) && $_SESSION['logined']==true)
  {
    header('Location: info.php');
    exit(); //dzięki temu reszta linijek kodu sie nie wykona
  }

  if(isset($_POST['email']))
  {
    $wszystko_OK = true;


    $login = $_POST['login'];
    //sprawdzenie długości loginu
    if(strlen($login)<7 || strlen($login)>33) {
      $wszystko_OK = false;
      $_SESSION['e_login'] = 'login musi posiadać od 7 od 33 znaków';
    }
    if(ctype_alnum($login)==false) {
      $wszystko_OK = false;
      $temp = (isset($_SESSION['e_login'])? $_SESSION['e_login'].'<br>' : '');
      $_SESSION['e_login'] = $temp.'login musi posiadać tylko znaki alfa-numeryczne ("A"-"Z", "a"-"z", 0-9)';
    }

    $email = $_POST['email'];
    if(
      filter_var($email, FILTER_VALIDATE_EMAIL) == false ||
      filter_var($email, FILTER_SANITIZE_EMAIL) != $email
    ) {
      $wszystko_OK = false;
      $_SESSION['e_email'] = 'Nie prawidłowy e-mail';
    }

    $password1 = $_POST['password'];
    $password2 = $_POST['password2'];
    if($password1 == "") {
      $wszystko_OK = false;
      $_SESSION['e_pass'] = 'Nie podano hasła';
    }
    if($password1 != $password2) {
      $wszystko_OK = false;
      $_SESSION['e_pass2'] = 'Nie poprawnie powtórzone hasło';
    }

    if(!isset($_POST['regulamin']) || $_POST['regulamin'] != "1")
    {
      $wszystko_OK = false;
      $_SESSION['e_check'] = 'Nie zaakceptowałeś regulaminu';
    }



    if($wszystko_OK == true)
    {
      $_SESSION['RegisterError'] = '<span style="color: blue;">Prawidłowo wypełniony formularz</span>';
      $password = password_hash($password1, PASSWORD_DEFAULT);
      echo $password;
    } else {
      $_SESSION['RegisterError'] = '<span style="color: red;">Nie prawidłowo wypełniony formularz</span>';
    }
  } else {
    unset($_SESSION['RegisterError']);
  }

?>
<!DOCUMENT html>
<html>
<head>
  <meta lang="en">
  <title>o ja</title>

<script src='https://www.google.com/recaptcha/api.js'></script>
  <script>
  function ShowPass(checkbox)
  {
    if(checkbox.checked == true) {
      document.getElementById("password").type = "text";
      document.getElementById("password2").type = "text";
    } else {
      document.getElementById("password").type = "password";
      document.getElementById("password2").type = "password";
    }
  }
  function checkError(hoveredError, value)
  {
    hoveredError.innerHTML=value;
  }
  </script>

  <style>
    div.error
    {
      color: red;
      position: absolute;
      z-index: 5;
      margin-top: -26px;
      margin-left: 160px;
      width: auto;
      height: auto;
      background-color: #ddd;
      padding: 4px;
      border-radius: 8px;
    }
  </style>

</head>
<body>

  <form method="post">
    <input type="text" name="login" id="login" autofocus="autofocus" placeholder="Login" min="8"/>
    <?php if(isset($_SESSION['e_login'])) echo '<div class="error">'.$_SESSION['e_login'].'</div>'; unset($_SESSION['e_login']); ?>
    <br>
    <input type="text" name="email" id="email" placeholder="E-mail"/>
    <?php if(isset($_SESSION['e_email'])) echo '<div class="error">'.$_SESSION['e_email'].'</div>'; unset($_SESSION['e_email']); ?>
    <br>
    <input type="password" name="password" id="password" placeholder="Password"/>
    <?php if(isset($_SESSION['e_pass'])) echo '<div class="error">'.$_SESSION['e_pass'].'</div>'; unset($_SESSION['e_pass']); ?>
    <br>
    <input type="password" name="password2" id="password2" placeholder="Repeat password"/>
    <?php if(isset($_SESSION['e_pass2'])) echo '<div class="error">'.$_SESSION['e_pass2'].'</div>'; unset($_SESSION['e_pass2']); ?>
    <br>
    <label><input type="checkbox" onchange="ShowPass(this);"/>Show Password</label>
    <br>
    <br> <label><input type="checkbox" name="regulamin" value="1"/>I accept rules</label>
    <?php if(isset($_SESSION['e_check'])) echo '<div class="error">'.$_SESSION['e_check'].'</div>'; unset($_SESSION['e_check']); ?>
    <br>
    <div class="g-recaptcha" data-sitekey="6LeObXEUAAAAACgBiIqFr1DAXGHvO25odEgHqt4M"></div>

    <input type="submit" value="Register" name="register"/>
  </form>
<?php

  echo '<script>';
  if(isset($_POST['login'])) echo 'document.getElementById("login").value = "'.$_POST['login'].'";';
  if(isset($_POST['password'])) echo 'document.getElementById("password").value = "'.$_POST['password'].'";';
  if(isset($_POST['email'])) echo 'document.getElementById("email").value = "'.$_POST['email'].'";';
  echo '</script>';

  if(isset($_SESSION['RegisterError']))
    echo $_SESSION['RegisterError'];

?>
</body>
</html>
