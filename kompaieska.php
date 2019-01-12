<?php
session_start();
$con = new mysqli('localhost','root','','projektas');
$dabartinisUser = $_SESSION['userid'];
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Komandos paieska</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php
    include("menu.php");
    if (isset($_POST['ieskoti'])) {
       $kompav = $con->real_escape_string($_POST['name']);
       ?>

      <div class="container" >
        <div class="jumbotron">
          <div class="col-md-9">
           <?php  echo "<b>Ivesk komandos pavadinimą</b>" ?>
          <form class="post" action="kompaieska.php" method="post">
            <input class="form-control" type="text" name="name" placeholder="Komandos pavadinimas"><br>
            <input class="btn btn-primary" type="submit" name="ieskoti" value="Sukurti"><br>
          </form>
        </div>
        <br>

               <?php
               $sql= $con->query("SELECT userid,name from komanda Where name ='$kompav'");
               if($sql->num_rows > 0)
               {
                ?>
                <center><h2>Surastos Komandos:</h2></center>
                <table class='table table-striped'>
                <thead>
                  <tr>
                    <th scope='col'>#</th>
                       <th scope='col'>Pavadinimas</th>
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
                  echo "<td><a href='vartotojas.php?id={$value['userid']}'>".$value['name']."</a></td>";
                  echo "</tr>";
               }
             }else {
               echo "tokios komandos nėra duomenų bazėje.";
             }
                ?>

             </tbody>
           </table>
        </div>
      </div>
<?php } else{ ?>
  <div class="container" >
    <div class="jumbotron">
      <div class="col-md-9">
       <?php  echo "<b>Ivesk komandos pavadinimą</b>" ?>
      <form class="post" action="kompaieska.php" method="post">
        <input class="form-control" type="text" name="name" placeholder="Komandos pavadinimas"><br>
        <input class="btn btn-primary" type="submit" name="ieskoti" value="Sukurti"><br>
      </form>
    </div>

    </div>
  </div>
 <?php } ?>


  </body>
</html>
