<?php
session_start();
$dabartinisUser = $_SESSION['userid'];

$con = new mysqli('localhost','root','','projektas');
$userid = $con->real_escape_string($_GET['id']);


if(isset($_POST['komentuoti']))
{
  $komentaras = $con->real_escape_string($_POST['komentaras']);
  $username = $con->real_escape_string($_SESSION['username']);
  $data = $con->real_escape_string(date("Y-m-d h:i:sa"));
  $con->query("INSERT into vartotojukomentarai (userid, kasparase, data, komentaras) VALUES ('$userid','$username','$data','$komentaras')");

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
    <title>Profilis</title>
  </head>
  <body>
    <?php include("menu.php");

    if(isset($_GET['id']) ){
      $sql = $con->query("SELECT * from vartotojai where vartotojai.id ='$userid'");
      if($sql->num_rows >0)
      {
        $sql=$con->query("Select vartotojai.id, vartotojai.username, vartotojai.email, vartotojai.taskai, komanda.name as kompav, komanda.taskai as komtask, komanda.id as komid From vartotojai,komanda where komanda.userid='$userid' AND vartotojai.id='$userid'")->fetch_array();
    ?>
    <div class="container">
      <div class="jumbotron">
        <center> <b><h1>Profilio informacija:</h1></b>
         <b>Prisijungimo vardas: </b> <?php echo $sql['username']; ?> <br>
        <b>Komanda: </b> <a href='komanda.php?id=<?php echo $userid;?>'><?php echo $sql['kompav']; ?></a> <br>
        <b>Vartotojo Taškai: </b><?php echo $sql['taskai']; ?>
        </center>
        <center> <b><h1>Mėgstamų komandų TOP 5:</h1></b>

                 <?php
                 $sql= $con->query("SELECT megstamiausios.komid,megstamiausios.userid, komanda.name from megstamiausios,komanda WHERE megstamiausios.userid = '$userid' AND megstamiausios.komid = komanda.id LIMIT 5");
                 if($sql->num_rows > 0)
                 {
                   ?>
                   <table class='table table-striped'>
                   <thead>
                     <tr>
                       <th scope='col'>#</th>
                         <th scope='col'>Komandos pavadinimas</th>
                        </tr>
                        </thead>
                        <tbody>
                <?php
                 while($row = mysqli_fetch_assoc($sql))
                 {
                   $TOP[] = $row;
                 }
                 $i = 1;
                 foreach ($TOP as $key => $value) {
                    echo "<tr>";
                    echo "<th scope='row'>".$i++."</th>";
                    echo "<td><a href='komanda.php?id={$value['userid']}'>".$value['name']."</a></td>";
                    echo "</tr>";
                 }
               }else {
                 echo "Nera megstamu komandu saraso.";
               }
                  ?>

               </tbody>
             </table>
      </div>
    </div>

    <div class="container">
      <div class="jumbotron">
        <center><h3>Komentarai:</h3></center>
        <?php
          $data = [];
          $sql=$con->query("Select * from vartotojukomentarai where userid=$userid");
        while($row = mysqli_fetch_assoc($sql))
        {
          $data[] = $row;
        }
        if(Count($data) == 0)
        {
          echo "<center><b>Komentaru nera</b></center>";
        }else {
          foreach ($data as $key => $value) {
            echo "<b>Autorius: </b>".$value['kasparase']."<br>";
            echo "<b>Parašymo data:</b>".$value['data']."<br>";
            echo "<b>Komentaras: </b><br>";
            echo $value['komentaras']."<br><br>";
          }
        }


         ?>


        <center><h2>Parasyk komentarą!</h2>
        <form class="post" action="vartotojas.php?id=<?php echo $userid;?>" method="post">
          <textarea name="komentaras" rows="4" cols="80" placeholder="rašyti čia"></textarea><br><br>
          <input class="btn btn-primary" type="submit" name="komentuoti" value="komentuoti">
        </form></center>

      </div>

    </div>

  <?php }
      else {
        echo "Tokio vartotojo nera.";
      }

        ?>
  <?php   }else {
      echo "Neivestas vartotojo id";
    }
 ?>

  </body>
</html>
