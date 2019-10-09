


<div class="menu" >

		<div class="row">
	
					<div class="col-sm-3"></div>		
					<div class="col-sm-1"><a href="index.php">Home</a></div>		
					<div class="col-sm-1"><a href="news.php">News</a></div>		
					<div class="col-sm-1"><a href="contact.php">Contact</a></div>	
					<div class="col-sm-1"><a href="users.php">Users</a></div>	
						

								<?php if(isset($_SESSION['user_id'])) { ?>
								<div class="col-sm-2"><a href="logout.php">Logout&nbsp; <img src="images/logout.png" alt="" width="20px"></a>&nbsp; <a href="include/inc_select_profile.php"> <?php echo get_value_from_table("users", "name", "id", $_SESSION['user_id']); ?> <img src="images/profile.png" alt="Profile" width="20px"></a></div>		
								<div class="col-sm-1">
									<button class = "sticky-button" id = "sticky-button" type="submit" onclick="return validate();"   name="btn_update_profile"> Update </button>
														
								</div>
								<?php } else { ?>
								<div class="col-sm-1"><a href="signin1.php">Login</a></div>		
								<?php } ?>
					
					<div class="col-sm-2"></div>		
					
							
		</div>	
<div class="horizontal-line"></div>	

</div>

