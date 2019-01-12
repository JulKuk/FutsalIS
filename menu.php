
<?php
if (isset($_SESSION['username']) == NULL) :
?>
	  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Navigacija</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="login.php">Prisijungimas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Registracija</a>
      </li>
			<li class="nav-item">
				 <a class="nav-link" href="guestTop10.php">Vartotoju TOP 10</a>
			 </li>
			 <li class="nav-item">
				 <a class="nav-link" href="guestTop5.php">Komandu TOP 5</a>
			 </li>
    </ul>
  </div>
</nav>
<?php endif ?>
<!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
		  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Welcome <?php echo $_SESSION['username']?> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home </a>
      </li>
	   <li class="nav-item">
        <a class="nav-link" href="komanda.php?id=<?php echo $_SESSION['userid']; ?>">Mano Komanda</a>
      </li>
			<li class="nav-item">
				 <a class="nav-link" href="vartotojas.php?id=<?php echo $_SESSION['userid']; ?>">Profilis</a>
			 </li>
			 <li class="nav-item">
					<a class="nav-link" href="Top10.php">Vartotoju TOP 10</a>
				</li>
				<li class="nav-item">
 					<a class="nav-link" href="Top5.php">Komandu TOP 5</a>
 				</li>
				<li class="nav-item">
 					<a class="nav-link" href="Komandulist.php">Komandu sąrašas</a>
 				</li>
				<li class="nav-item">
 					<a class="nav-link" href="kompaieska.php">Komandos Paieska</a>
 				</li>
	   <?php if($_SESSION['arAdmin'] == 1) :?>
	  <li class="nav-item">
        <a class="nav-link" href="admin.php">Admin</a>
      </li>
	   <?php endif?>
	   <li class="nav-item">
        <a class="nav-link" href="index.php?logout='1'">Log Out</a>
      </li>
    </ul>
  </div>
</nav>
    <?php endif ?>
