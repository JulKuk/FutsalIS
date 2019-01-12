<?php
session_start();
$con = new mysqli('localhost','root','','projektas');
$dabartinisUser = $_SESSION['userid'];
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>Visu komandu sąrašas</title>
  </head>
  <body>
    <?php include("menu.php"); ?>
    <div class="container">
      <div class="jumbotron">
      <center>  <h1>Visų komandų sąrašas:</h1> </center>
        <table class='table table-striped'>
        <thead>
          <tr>
            <th scope='col'>#</th>
               <th scope='col'>Kam priklauso</th>
               <th scope='col'>Komandos pavadinimas</th>
             </tr>
             </thead>
             <tbody>
               <?php
               $sql= $con->query("SELECT vartotojai.id,komanda.id as komid, komanda.name, vartotojai.username FROM vartotojai,komanda Where komanda.userid = vartotojai.id");
               while($row = mysqli_fetch_assoc($sql))
               {
                 $TOP[] = $row;
               }
               $i = 1;
               foreach ($TOP as $key => $value) {
                  echo "<tr>";
                  echo "<th scope='row'>".$i++."</th>";
                  echo "<td><a href='vartotojas.php?id={$value['id']}'>".$value['username']."</a></td>";
                  echo "<td><a href='komanda.php?id={$value['id']}'>".$value['name']."</a></td>";
                  echo "</tr>";
               }
                ?>

             </tbody>
           </table>
      </div>
    </div>

  </body>
</html>
