<link rel="stylesheet" href="./css/enterprise_teacher.css">
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!--div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div-->
    <ul class="nav navbar-nav">
      <li <?php if($page=='index') echo 'class="active"' ?>><a href="signin1.php">Home</a></li>
      <li <?php if($page=='profile') echo 'class="active"' ?>><a href="profile.php">Profile</a></li>
      <li <?php if($page=='idcard') echo 'class="active"' ?>><a href="frm_idcard.php">ID</a></li>
      	 	<?php if(isset($_SESSION['user_id'])){

						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<li style='text-align:right;'><a href='logout.php'>Logout " . "&nbsp;&nbsp;" . "<span style='color:#FFF'>" . $_SESSION["user_name"] . "</span>" . "</a></li>";

						}else{

						if($page=='idcard') echo '<li><a href="login.php">login</a></li>';

						}


			?></div>
    </ul>
  </div>
</nav>
<div>