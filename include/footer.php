

    </div>
  </div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<div style="position:absolute;x:0;y:0;"><?php if(isset($_SESSION['user_id'])) echo  $_SESSION['user_id']; ?></div>


				<script type="text/javascript" >
									// When the user scrolls the page, execute myFunction
									window.onscroll = function() {myFunction()};
									
									// Get the header
									var header = document.getElementById("page-header");
									
									// Get the offset position of the navbar
									var sticky = header.offsetTop + header.offsetHeight;
									
									// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
									function myFunction() {
									  if (window.pageYOffset > sticky-85) {
									    header.classList.add("sticky");
									  } else {
									    header.classList.remove("sticky");
									  }
									}
				</script>


</body>
<footer class="navbar-default navbar-fixed-bottom">
<div style="width:100%;text-align: center;">
<?php
if(isset($pagination_bar)){
		
	echo "&lt;&lt;Total Records = " . $pagination_bar;
}
?>

</div>
  <div class="container-fluid">
    <span><?php if(isset($msg_db_connection)){echo $msg_db_connection;} ?></span>
  </div>

	
</footer>
<div id="mec-logo" class="mec-logo"></div>


</html>
<?php
			if(isset($_SESSION['logout']) && $_SESSION['logout']==true)
			{
				session_write_close();
				session_regenerate_id(true);
	
				exit();
				die();
			}
?>

