<?php
session_start();
$con = new mysqli('localhost','root','','projektas');
$dabartinisUser = $_SESSION['userid'];
$sql1 = $con->query("SELECT * FROM vartotojai");
while($row = mysqli_fetch_assoc($sql1))
{
  $vartotojai[] = $row;
}
if(isset($_POST['salinti']))
{
   $vartotojoid = $con->real_escape_string($_POST['vartotojas']);
   $data = $con->query("SELECT id from komanda where userid='$vartotojoid'")->fetch_array();
   $komid = $data['id'];

   $con->query("DELETE FROM startinis where komid='$komid' AND zaidid=zaidid");
   $con->query("DELETE FROM vartotojukomentarai where userid ='$vartotojoid'");
   $con->query("UPDATE Zaidejai set komid=NULL where komid='$komid'");
   $con->query("DELETE FROM komandoskomentarai where komid='$komid'");
   $con->query("DELETE FROM megstamiausios where komid='$komid' AND userid='$vartotojoid'");
   $con->query("DELETE FROM reitingai where userid='$vartotojoid'");
   $con->query("DELETE FROM reitingai where komid='$komid'");
   $con->query("DELETE FROM komanda where userid='$vartotojoid'");
   $con->query("DELETE FROM vartotojai Where id='$vartotojoid'");
   header('location:admin.php');
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Vartotojo pašalinimas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>
  <body>
<?php include 'menu.php'; ?>
<div class="container">
  <div class="jumbotron">
    <center><h3> Kurį vartotoją pašalinti?</h3></center>
    <form class="post" action="admin.php" method="post">
      <select id="vartotojas" name="vartotojas">
        <?php
        foreach ($vartotojai as $key => $value) {
            echo "<option value='{$value['id']}'>{$value['username']}</option>";
        }
         ?>
        </select>
        <input class="btn btn-primary" type="submit" name="salinti" value="salinti"><br>
    </form>
  </div>

</div>
  </body>
</html>
