<?php

  session_start(); // dodawanie sesji (forma metody POST)

  if(!isset($_POST['login']) || !isset($_POST['password']))
  {
        $_SESSION['LoginError'] = '<span style="color: red;">Nie podano loginu lub hasła</span>';
        header('Location: index.php');
        exit();
  }

  require_once "connectSQL.php";

  $connect = @new mysqli($host, $DB_user, $DB_password, $DB_name);

  if ($connect->connect_errno!=0)
  {
    echo "Error".$connect->connect_errno;
    if ($_DEVMODE==true) {
      echo " : ".$connect->connect_error;
    }
  }
  else {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");

    //--$password = password_hash($password, PASSWORD_DEFAULT);

    $sqlQuery = "SELECT * FROM userdate WHERE login='$login'";

    if($result = @$connect->query($sqlQuery)) { //sprawdzanie czy zapytanie(query) zostało wykonane
      if(($result->num_rows) == 1) {

        $record = $result->fetch_assoc(); //apotruj zawartość rekordu

        if(password_verify($password, $record['pass']))
        {
          $user = $record['login'];
          $_SESSION['user'] = $user;
          $_SESSION['id'] = $record['ID'];
          $_SESSION['email'] = $record['email'];
          $_SESSION['wood'] = $record['wood'];
          $_SESSION['rock'] = $record['rock'];
          $_SESSION['wheat'] = $record['wheat'];
          $_SESSION['premium'] = $record['premium'];

          $_SESSION['logined'] = true;

          unset($_SESSION['LoginError']);

          $result->free_result(); //można użyć ->free() lub ->close() również (czyści ram) ale tak jest najlepiej

          header('Location: info.php');
        } else {
          $_SESSION['LoginError'] = '<span style="color: red;">Błędny login lub hasło</span>';
          header('Location: index.php');
        }
      }
      else {
        $_SESSION['LoginError'] = '<span style="color: red;">Błędny login lub hasło</span>';
        header('Location: index.php');
      }
    }


    $connect->close();
    exit();
  }

    $_SESSION['LoginError'] = '<span style="color: red;">Problem z serwerem</span>';
    header('Location: index.php');
?>
