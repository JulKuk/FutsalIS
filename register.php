<?php
   $msg ="";
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
    if(isset($_POST['Submit']))
    {
      $con = new mysqli('localhost','root','','projektas');

      $name = $con->real_escape_string($_POST['name']);
      $email = $con->real_escape_string( $_POST['email']);
      $password = $con->real_escape_string($_POST['password']);
      $password1 = $con->real_escape_string($_POST['password1']);

      if ($name =="" || $email == "" || $password != $password1) {
        $msg = "Patikrink ar teisingai įvedei visus registracijos laukus!";
      }
      else {
          $sql = $con->query("SELECT id FROM vartotojai where username='$name'");
          if($sql->num_rows > 0)
          {
            $msg = "Vartotojo vardas jau yra mūsų duomenų bazėje.";
          }else {
             $token="qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890!@$%^*";
	           $token= str_shuffle($token);
	           $token = substr($token,0,10);

             $hashedpassw = password_hash($password, PASSWORD_BCRYPT);

             $con->query("INSERT INTO vartotojai (username,password,email,confirm,token,taskai)
                VALUES ('$name','$hashedpassw','$email','0','$token','0')
             ");

             include_once "PHPMailer/PHPMailer.php";
             include_once "PHPMailer/SMTP.php";
             include_once "PHPMailer/Exception.php";

             $mail = new PHPMailer();
             $mail->isSMTP();
             $mail->CharSet="UTF-8";
             $mail->SMTPAuth = true;
             $mail->SMTPSecure = 'ssl';
             $mail->SMTPDebug = 0;
             $mail->Host = "smtp.gmail.com";
             $mail->Port = 465;
             $mail->Username = "0wn3das@gmail.com";
             $mail->Password = "spaliukas";
             $mail->setFrom('0wn3das@gmail.com');
             $mail->addAddress($email, $name);
             $mail->Subject = "Please verify email!";
             $mail->isHTML(true);
             $mail->Body = "
                Please click on the link bellow:<br><br>

                <a href='http://127.0.0.1/confirm.php?email=$email&token=$token'>Spausti Čia</a>
             ";

             if($mail->send())
             {
               $msg = " Tu užregistruotas norint prisijungti turi patvirtinti el.pašto adresą";
           }else {
             $msg = "Kažkas nepavyko. Pamėginkite užsiregisturoti dar kartą." . $mail->ErrorInfo;
          }
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
    <title>Registre</title>
  </head>
  <body>

    <?php include("menu.php"); ?>
    <div class="container" style="margin-top: 100px;">
      <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3" align="cemter">
          <?php if ($msg != "") echo $msg . "<br> <br>" ?>

          <form class="post" action="register.php" method="post">
            <input class="form-control" type="text" name="name" placeholder="Name"><br>
            <input class="form-control" type="email" name="email" placeholder="Email"><br>
            <input class="form-control" type="password" name="password" placeholder="Password"><br>
            <input class="form-control" type="password" name="password1" placeholder="Confirm Password"><br>
            <input class="btn btn-primary" type="submit" name="Submit" value="Register"><br>
          </form>

        </div>
      </div>
    </div>
  </body>
</html>
