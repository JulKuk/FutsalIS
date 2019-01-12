<?php

  function redirect(){
    header('Location: login.php');
    exit();
  }

  if( !isset($_GET['email']) || !isset($_GET['token']))
  {
    redirect();
  }
  else {
    $con = new mysqli('localhost','root','','projektas');

    $email = $con->real_escape_string($_GET['email']);
    $token = $con->real_escape_string($_GET['token']);

    $sql = $con->query("SELECT id FROM vartotojai WHERE email='$email' AND token='$token' AND confirm=0");

    if($sql->num_rows > 0)
    {
      $con->query("UPDATE vartotojai SET confirm=1, token='' WHERE email='$email'");
      redirect();
    }else {
      redirect();
    }

  }
 ?>
