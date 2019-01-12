<?php
session_start();
$dabartinisUser = $_SESSION['userid'];

$con = new mysqli('localhost','root','','projektas');
$userid = $con->real_escape_string($_GET['id']);
if(isset($_POST['Submit']))
{
  $name = $con->real_escape_string($_POST['name']);
  $userid = $con->real_escape_string($_GET['id']);
  if($name == "")
  {
    echo "Neivestas komandos pavadinimas.";
  }else {
    $con->query("INSERT INTO komanda (name,taskai,userid)
       VALUES ('$name','10000','$userid') ");
       $sql = $con->query("SELECT id FROM komanda WHERE userid='$userid'");
       $data = $sql->fetch_array();
       $komid = $data['id'];
       $_SESSION['komid'] = $komid;

       $i=0;
       while($i < 20)
       {
         $rand = rand(1,100);
         $sql = $con->query("SELECT * FROM zaidejai where id='$rand' and komid is NULL");
         if($sql->num_rows > 0)
         {
           $data = $sql->fetch_array();
           if($data['komid'] == NULL)
           {
             $con->query("UPDATE zaidejai SET komid='$komid' WHERE id='$rand'");
             $i++;
           }
         }

       }
  }
}

if(isset($_POST['vertinti']))
{
  $reitingas = $con->real_escape_string($_POST['reitingas']);
  $data = [];
  $data = $con->query("SELECT id from komanda where userid = $userid")->fetch_array();
  $komid = $data['id'];
  $dbTaskai = array();
  $dbTaskai = $con->query("Select vartotojai.taskai as vTask, komanda.taskai as kTask FROM vartotojai LEFT JOIN komanda ON komanda.userid = $userid")->fetch_array();
  $komT = 0;
  $userT = 0;
  $con->query("INSERT INTO reitingai (komid,userid,reitingas) VALUES('$komid','$dabartinisUser','$reitingas')");
  if($reitingas == 10)
  {
    $komT = $dbTaskai['kTask'] + 1000;
    $userT = $dbTaskai['vTask'] + 100;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 9)
  {
    $komT = $dbTaskai['kTask'] + 900;
    $userT = $dbTaskai['vTask'] + 90;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 8)
  {
    $komT = $dbTaskai['kTask'] + 800;
    $userT = $dbTaskai['vTask'] + 80;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 7)
  {
    $komT = $dbTaskai['kTask'] + 700;
    $userT = $dbTaskai['vTask'] + 70;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 6)
  {
    $komT = $dbTaskai['kTask'] + 600;
    $userT = $dbTaskai['vTask'] + 60;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 5)
  {
    $komT = $dbTaskai['kTask'] + 500;
    $userT = $dbTaskai['vTask'] + 50;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 4)
  {
    $komT = $dbTaskai['kTask'] + 400;
    $userT = $dbTaskai['vTask'] + 40;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 3)
  {
    $komT = $dbTaskai['kTask'] + 300;
    $userT = $dbTaskai['vTask'] + 30;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 2)
  {
    $komT = $dbTaskai['kTask'] + 200;
    $userT = $dbTaskai['vTask'] + 20;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }
  if($reitingas == 1)
  {
    $komT = $dbTaskai['kTask'] + 100;
    $userT = $dbTaskai['vTask'] + 10;
    $con->query("Update komanda set taskai=$komT where id = $komid");
    $con->query("Update vartotojai set taskai=$userT where id = $userid");
  }

}
//Komentaru apdorojimas ir idejimas i duombaze
if(isset($_POST['komentuoti']))
{
  $komentaras = $con->real_escape_string($_POST['komentaras']);
  $username = $con->real_escape_string($_SESSION['username']);
  $data = $con->real_escape_string(date("Y-m-d h:i:sa"));
  $data1 = [];
  $data1 = $con->query("SELECT id from komanda where userid = $userid")->fetch_array();
  $komid = $data1['id'];
  $con->query("INSERT into komandoskomentarai (komid, kasparase, data, komentaras) VALUES ('$komid','$username','$data','$komentaras')");

}

if(isset($_POST['patinka']))
{
  $komid = $con->real_escape_string($_POST['komid']);
  $useris = $con->real_escape_string($_SESSION['userid']);

  $con->query("INSERT into megstamiausios (komid, userid) VALUES ('$komid','$useris')");
}

if(isset($_POST['nepatinka']))
{
  $komid = $con->real_escape_string($_POST['komid']);
  $useris = $con->real_escape_string($_SESSION['userid']);

  $con->query("DELETE FROM megstamiausios where komid='$komid' AND userid='$useris'");
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
    <title>Komanda</title>
  </head>
  <body>
    <?php
    include("menu.php");
    if (!isset($_GET['id'])) {
      echo "Ivestas blogas user id.";
    }
    else {
      $con = new mysqli('localhost','root','','projektas');
      $id = intval($_GET['id']);

      $sql = $con->query("SELECT * FROM komanda WHERE userid='$id'");
      if($sql->num_rows > 0)
      {
        $data = $sql->fetch_array();
        $komid= $data['id'];
        $_SESSION['komid'] = $komid;
        if($id == $data['userid'])
        {
          $_SESSION['kompav'] = $data['name'];

    ?>
      <div class="container">
        <div class="jumbotron">
          <center>
          <h2><b>Komandos bendra informacija:</b></h2>
          </center>

          <center><b>Komandos Pavadinimas:</b> <?php echo $data['name']; ?><br>
          <b>Komandos Taskai:</b> <?php echo $data['taskai']; ?></center><br>
          <?php
          if($id == $_SESSION['userid'])
          {
          ?>
          <a href='komandared.php?id=<?php echo $_SESSION['userid'];?>'><button type="button" class="btn btn-primary">Redaguoti Komanda</button></a>
        <?php
        }
        ?>
        <?php
          if($con->query("SELECT * from megstamiausios Where komid='$komid' AND userid='$dabartinisUser'")->num_rows > 0)
          {
        ?>
        <form class="post" action="komanda.php?id=<?php echo $id;?>" method="post">
          <input class="btn btn-primary" type="hidden" name="komid" value="<?php echo $komid;?>">
          <input class="btn btn-primary" type="submit" name="nepatinka" value="Nepatinka" ><br><br>
        </form>
        <?php
      }else{
        ?>
        <form class="post" action="komanda.php?id=<?php echo $id;?>" method="post">
          <input class="btn btn-primary" type="hidden" name="komid" value="<?php echo $komid;?>">
          <input class="btn btn-primary" type="submit" name="patinka" value="Patinka" ><br><br>
        </form>
      <?php } ?>

          <h3><center><b> Komandos startinio penketuko informacija. </b></center></h3>
          <table class='table table-striped'>
          <thead>
            <tr>
              <th scope='col'>#</th>
                 <th scope='col'>Vardas Pavarde</th>
                 <th scope='col'>Reitingas</th>
               <th scope='col'>Pozicija</th>
               </tr>
               </thead>
               <tbody>
              <?php
              $sql1 = $con->query("SELECT nr,zaidejai.vardas,zaidejai.pavarde,zaidejai.reitingas,zaidejai.Pozicijos from startinis Left JOIN zaidejai ON startinis.komid = $komid AND startinis.zaidid = zaidejai.id");
              if($sql1->num_rows > 0)
              {
                $startinis = array();
                while($row = mysqli_fetch_assoc($sql1))
                {
                  $startinis[] = $row;
                }
                $vid = 0;
                //Formuojam lentele
                foreach ($startinis as $key => $value) {
                  if($value['vardas'] != NULL && $value['pavarde'] != NULL && $value['reitingas'] != NULL && $value['Pozicijos'] != NULL)
                  {
                  $vid = $vid + $value['reitingas'];
                 echo "<tr>";
                 echo "<th scope='row'>".$value['nr']."</th>";
                 echo "<td>".$value['vardas']." ".$value['pavarde']."</td>";
                 echo "<td>".$value['reitingas']."</td>";
                 echo "<td>".$value['Pozicijos']."</td>";
                 echo "</tr>";
               }
                }
                $vid = $vid / 5;
                $con->query("UPDATE komanda SET vid=$vid Where id=$komid");
              }
              ?>
            </tbody>
          </table>
          <center><b> Bendras komandos vidurkis: <?php echo $vid; ?></b></center><br><br>
          <?php
          if($_SESSION['userid'] != $id)
          {
            $tikrinimui = $con->query("Select userid from reitingai where userid=$dabartinisUser")->fetch_object();
            if($tikrinimui)
            {
              echo "<center>Tu jau ivertinęs šitą komandą.</center>";
            }else{

          ?>
          <center><b>Įvertink šįą komandą:</b>
            <form class="post" action="komanda.php?id=<?php echo $id; ?>" method="post">
            <select id="reitingas" name="reitingas">
              <?php
              foreach (range(1,10) as $value){
                  echo "<option value='{$value}'>  {$value} </option>";
              }

                ?>
            </select>
            <input class="btn btn-primary" type="submit" name="vertinti" value="vertinti"><br>
            </form><br><center>
            <?php
          }

            ?>

          <?php }
          $data1 = [];
          $data1 = $con->query("Select AVG(reitingas) as rating from reitingai where komid=$komid")->fetch_array();
          if($data1['rating'] != NULL)
          {
          $vidurkisR = $data1['rating'];
          }else {
          $vidurkisR = 0.00;
          }
          ?>
          <center><b>Komandos reitingas:<?php echo number_format($vidurkisR,2); ?>/10</b><center><br><br>
         <h3><center><b> Visa komandos sudetis:</b></center></h3>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Vardas Pavarde</th>
                <th scope="col">Reitingas</th>
                <th scope="col">Pozicija</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $komandosId = $data['id'];
              $sql1 = $con->query("SELECT * from zaidejai WHERE komid = $komandosId");
              if($sql1->num_rows > 0)
              {
                $startinis = array();
                while($row = mysqli_fetch_assoc($sql1))
                {
                  $startinis[] = $row;
                }
                $i = 1;
                //Formuojam lentele
                foreach ($startinis as $key => $value) {
                  $vid = $vid + $value['reitingas'];
                 echo "<tr>";
                 echo "<th scope='row'>".$i++."</th>";
                 echo "<td>".$value['vardas']." ".$value['pavarde']."</td>";
                 echo "<td>".$value['reitingas']."</td>";
                 echo "<td>".$value['Pozicijos']."</td>";
                 echo "</tr>";
                }
              }
              ?>
            </tbody>
          </table>

        </div>
      </div>
      <?php // Komentaras kad prasideda komentaru pridejimo metodas?>
      <div class="container">
        <div class="jumbotron">
          <center><h3>Komentarai:</h3></center>
          <?php
            $data = [];
            $sql=$con->query("Select * from komandoskomentarai where komid=$komid");
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
          <form class="post" action="komanda.php?id=<?php echo $userid;?>" method="post">
            <textarea name="komentaras" rows="4" cols="80" placeholder="rašyti čia"></textarea><br><br>
            <input class="btn btn-primary" type="submit" name="komentuoti" value="komentuoti">
          </form></center>

        </div>

      </div>
      <?php
        }
      }else {
       ?>
       <div class="container" >
         <div class="jumbotron">
           <div class="col-md-9">
            <?php  echo "<b>Dar neesate susikures komandos. Prasome sugalvoti komandos pavadinimą.</b>" ?>
           <form class="post" action="komanda.php?id=<?php echo $_SESSION['userid'] ?>" method="post">
             <input class="form-control" type="text" name="name" placeholder="Komandos pavadinimas"><br>
             <input class="btn btn-primary" type="submit" name="Submit" value="Sukurti"><br>
           </form>
         </div>
         </div>

       </div>


       <?php
     }
 }
        ?>
  </body>
</html>
