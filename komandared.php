<?php
session_start();
$komid = $_SESSION['komid'];
$userid = $_SESSION['userid'];
//Susidedu visus komandos narius
$con = new mysqli('localhost','root','','projektas');
$sql1 = $con->query("SELECT * FROM zaidejai Where komid='$komid'");
while($row = mysqli_fetch_assoc($sql1))
{
  $Komanda[] = $row;
}

if(isset($_POST['issaugoti']))
{
  $vartininkas = $con->real_escape_string($_POST['vartininkas']);
  $gynejas = $con->real_escape_string($_POST['gynejas']);
  $puolejas = $con->real_escape_string($_POST['puolejas']);
  $saugas = $con->real_escape_string($_POST['saugas']);
  $zaidejas = $con->real_escape_string($_POST['puolejas1']);
  $kompav = $con->real_escape_string($_POST['kompav']);
  $salinti = $con->real_escape_string($_POST['salinti']);

  if($vartininkas != -1)
  {
    $sql = $con->query("Select nr FROM startinis where komid=$komid AND nr=1");
    if($sql->num_rows > 0)
    {
      $con->query("UPDATE startinis SET zaidid=$vartininkas WHERE komid=$komid AND nr=1");
    }else {
      $con->query("INSERT INTO startinis (komid,zaidid,nr) VALUES ('$komid','$vartininkas','1')");
    }
  }
  if($gynejas != -1)
  {
    $sql = $con->query("Select nr FROM startinis where komid=$komid AND nr=2");
    if($sql->num_rows > 0)
    {
      $con->query("UPDATE startinis SET zaidid=$gynejas WHERE komid=$komid AND nr=2");
    }else {
      $con->query("INSERT INTO startinis (komid,zaidid,nr) VALUES ('$komid','$gynejas','2')");
    }
  }
  if($puolejas != -1)
  {
    $sql = $con->query("Select nr FROM startinis where komid=$komid AND nr=3");
    if($sql->num_rows > 0)
    {
      $con->query("UPDATE startinis SET zaidid=$puolejas WHERE komid=$komid AND nr=3");
    }else {
      $con->query("INSERT INTO startinis (komid,zaidid,nr) VALUES ('$komid','$puolejas','3')");
    }
  }
  if($saugas != -1)
  {
    $sql = $con->query("Select nr FROM startinis where komid=$komid AND nr=4");
    if($sql->num_rows > 0)
    {
      $con->query("UPDATE startinis SET zaidid=$saugas WHERE komid=$komid AND nr=4");
    }else {
      $con->query("INSERT INTO startinis (komid,zaidid,nr) VALUES ('$komid','$saugas','4')");
    }
  }
  if($zaidejas != -1)
  {
    $sql = $con->query("Select nr FROM startinis where komid=$komid AND nr='5'");
    if($sql->num_rows > 0)
    {
      $con->query("UPDATE startinis SET zaidid=$zaidejas WHERE komid=$komid AND nr='5'");
    }else {
      $con->query("INSERT INTO startinis (komid,zaidid,nr) VALUES ('$komid','$zaidejas','5')");
    }
  }
  if($kompav != $_SESSION['kompav'])
  {
    $sql = $con->query("Select id FROM komanda where id=$komid ");
    if($sql->num_rows > 0)
    {
      $con->query("UPDATE komanda SET name='$kompav' WHERE id='$komid'");
    }
  }
  if($salinti != -1)
  {
    $sql = $con->query("Select id FROM zaidejai where id=$salinti");
    if($sql->num_rows > 0)
    {
      $con->query("UPDATE zaidejai SET komid=NULL WHERE id=$salinti");
    }
  }

  header('Location:komanda.php?id='.$userid);
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
      $id = intval($_GET['id']);

      $sql = $con->query("SELECT * FROM komanda WHERE userid='$id'");
      if($sql->num_rows > 0)
      {
        $data = $sql->fetch_array();
        if($id == $data['userid'])
        {

    ?>
      <div class="container">
        <div class="jumbotron">
          <form class="post" action="komandared.php?id=<?php echo $id; ?>" method="post">
            <b>Komandos Pavadinimo Keitimas</b><input class="form-control" type="text" name="kompav" value="<?php echo $data['name']; ?>"><br>
            <center><b>Startinio 5 redagavimas</b></center>
            <b>Vartininkas:</b>
            <select id="vartininkas" name="vartininkas">
              <option value="-1">---------------</option>

            <?php
            foreach ($Komanda as $key => $value) {
              if($value['Pozicijos'] == 'Vartininkas')
              {
                echo "<option value='{$value['id']}'>{$value['vardas']} {$value['pavarde']} {$value['reitingas']} </option>";
              }
            }
             ?>
           </select><br>

          <b>Žaidėjas 1:</b>
          <select id="gynejas" name="gynejas">
            <option value="-1">---------------</option>
          <?php
          foreach ($Komanda as $key => $value) {
            if($value['Pozicijos'] != "Vartininkas")
            {
              echo "<option value='{$value['id']}'>{$value['vardas']} {$value['pavarde']} {$value['reitingas']} </option>";
            }
          }
           ?>
         </select><br>

         <b>Žaidėjas 2:</b>
         <select id="saugas" name="saugas">
           <option value="-1">---------------</option>

         <?php
         foreach ($Komanda as $key => $value) {
           if($value['Pozicijos'] != "Vartininkas")
           {
             echo "<option value='{$value['id']}'>{$value['vardas']} {$value['pavarde']} {$value['reitingas']} </option>";
           }
         }
          ?>
        </select><br>

        <b>Žaidėjas 3:</b>
        <select id="puolejas" name="puolejas">
          <option value="-1">---------------</option>
        <?php
        foreach ($Komanda as $key => $value) {
          if($value['Pozicijos'] != "Vartininkas")
          {
            echo "<option value='{$value['id']}'>{$value['vardas']} {$value['pavarde']} {$value['reitingas']} </option>";
          }
        }
         ?>
       </select><br>

       <b>Žaidėjas 4:</b>
       <select id="puolejas1" name="puolejas1">
         <option value="-1">---------------</option>
       <?php
       foreach ($Komanda as $key => $value) {
         if($value['Pozicijos'] != "Vartininkas")
         {
           echo "<option value='{$value['id']}'>{$value['vardas']} {$value['pavarde']} {$value['reitingas']} </option>";
         }
       }
        ?>
      </select><br>

      <center><b> Žaidėjo pašalinimas iš Komandos</b></center><br><br>
      <b> Kuri žaidėją norite šalinti? </b>
      <select id="salinti" name="salinti">
        <option value="-1">---------------</option>
      <?php
      foreach ($Komanda as $key => $value) {
          echo "<option value='{$value['id']}'>{$value['vardas']} {$value['pavarde']} {$value['reitingas']} </option>";
      }
       ?>
     </select><br>

            <input class="btn btn-primary" type="submit" name="issaugoti" value="issaugoti"><br>
          </form>
        </div>
      </div>
      <?php
        }
      }
     }
        ?>
  </body>
</html>
