<?php
session_start();
function redirect(){
  header('Location: index.php');
  exit();
}
   $msg ="";
    if(isset($_POST['Submit']))
    {
      $con = new mysqli('localhost','root','','projektas');

      $name = $con->real_escape_string($_POST['name']);
      $password = $con->real_escape_string($_POST['password']);

      if ($name =="" || $password == "") {
        $msg = "Neteisingas prisijungimo vardas ar slaptažodis!";
      }
      else {
          $sql = $con->query("SELECT * FROM vartotojai where username='$name'");
          if($sql->num_rows > 0)
          {
            $data = $sql->fetch_array();
            if(password_verify($password, $data['password']))
            {
              if($data['confirm'] == 0)
              {
                $msg = "Patvirtink savo el.pašto adresą norint prisijungti!";
              }else {
                $_SESSION['username'] = $data['username'];
                $_SESSION['userid'] = $data['id'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['utaskai'] = $data['taskai'];
                $_SESSION['arAdmin'] = $data['Admin'];
                redirect();
              }
            }else {
              $msg = "Neteisingas prisijungimo vardas ar slaptažodis!";
            }
          }else {
            $msg = "Neteisingas prisijungimo vardas ar slaptažodis!";
          }
      }
    }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>Login</title>
  </head>
  <body>
    <?php include("menu.php"); ?>
    <div class="container" style="margin-top: 100px;">
      <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3" align="cemter">
          <?php if ($msg != "") echo $msg . "<br> <br>" ?>

          <form class="post" action="login.php" method="post">
            <input class="form-control" type="text" name="name" placeholder="Name"><br>
            <input class="form-control" type="password" name="password" placeholder="Password"><br>
            <input class="btn btn-primary" type="submit" name="Submit" value="Log In"><br>
          </form>

        </div>
      </div>
    </div>
  </body>
</html>
