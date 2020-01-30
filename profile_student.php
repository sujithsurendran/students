<?php 
$page="profile";
$page_name="Profile";

global $arr_alert;
global $name,$date_of_joining_institution,$joining_date,$dob,$email,$branch ,$login;
global $roll_no_pf_no,$mobile,$phone ,$address1,$address2 ,$address3,$pin ,$district, $state,$country, $blood_group,$user_type;
global $err_email,$err_password,$err_password_confirm, $err_name, $arr_alert, $err_captcham, $err_branch, $err_dob;
global $err_date_of_joining_institution, $photo_file_name;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include 'include/inc_profile_student.php';
/*

if(  isset($_SESSION['photo_file_name']) ) {
	
	$photo_file_name = $_SESSION['photo_file_name'];
}
*/

?>




      

  <div class="row">
    				<div class="col-sm-3"></div>
    				<div class="col-sm-6">
    				
<!-- =========== FORM START ================= -->


<?php echo data_entry_helper("login", "Internal id/Admission Number(Login)", $login, $err_login,true);?>
<?php echo data_entry_helper("email", "Email", $email, $err_email);?>
			<div class="row">
				<div class="control-label col-sm-4"><button type="button" class="btn btn-info" data-toggle="collapse" data-target="#change_password">Change Password</button></div>
				<div class="col-sm-8"></div><br />
			</div>	
				

			<div id="change_password" class="collapse">
				<div class="panel panel-default"-->
		  			
		    			
		  

								<div class="row">
									<br />
									<label class="control-label col-sm-6" for password>Password</label>
									<div class="col-sm-6">
										<input type="password" name="password" class="form-control" id="password" value = ""/>
			
									</div>
									
								</div>
								<div class="row">
									<div class=col-sm-12>
										<?php show_error($err_password, "text-danger");?>
									</div>
								</div>								
						
						
								<div class="row">
			
									<label class="control-label col-sm-6" for password_confirm >Confirm Password</label>
									<div class="col-sm-6">
										<input type="password" name="password_confirm" class="form-control" id="password_confirm"  value = "" />
			
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<?php //show_error($err_password_confirm, "text-danger", "password_confirm");?>
									</div>
								</div>			
						
						
			
				</div>
			</div><!-- end of collapse-->
			<?php show_error($err_password_confirm, "text-danger", "password_confirm");?>
			<?php echo data_entry_helper("name", "Name", $name, $err_name) ?>
			<?php echo data_entry_helper("date_of_joining_institution", "Date of joining Institution", $date_of_joining_institution, $err_date_of_joining_institution) ?>
			
			<?php 

			
			// Include this later on for Employees
			//if($_SESSION['user_type_id'] == USER_TYPE_STAFF) {
	
							
					echo data_entry_helper("joining_date", "Date of joining(for Employees)", $joining_date, $err_joining_date) ;
					
			//}
			?>
			
			
			
			<!-- Photo uploadform Start-->
			<div class="row">
				<div class="form-group">
						<label class="control-label col-sm-6" for="Photo">Click to Change Photo ></label>
						<div class="col-sm-6">
								
								<?php include 'js/profile_photo_upload.js'; ?>
								<?php include 'css/profile_photo_upload.css'; ?>
   					
								<div>
									<label class="newbtn">
											<div width="85px;" style="text-align:center;">
												<!--img id="profile_photo" src="<?php echo "uploads/reduced/" . $login . ".jpg" ?>" width="75px;"/-->
												<!-- img id="profile_photo" src="<?php echo "uploads/reduced/" . $photo_file_name; ?>" width="75px;"/-->
												<img id="profile_photo" src="<?php echo $photo_file_name; ?>" width="75px;"/>
												
												

											</div>
											<input id="fileToUpload" class='pis' onchange="readURL(this);" type="file" name="fileToUpload">
									</label>
								</div>         					
						</div><!--div class="col-sm-6"-->

				</div><!--div class="form-group"-->					
			</div>
			<?php //echo show_message("If you do not find the uploaded photo. Please try Refreshing ->Ctr+F5");?>			
			<!-- Photo upload End -->

		<?php //echo data_entry_helper("photo_file_name", "Photo File Name", $photo_file_name, $err_photo_file_name, "false") ?>


			<!-- DOB start-->
			<div class="row">
				<div class="form-group">
					<label class="control-label col-sm-5" for="dob">Date of birth</label>
					<div class="col-sm-7">
	        			<input class="form-control" id="datepicker" name="dob" type="text" value="<?php echo date('Y-m-d', strtotime($dob)); ?>" title = "yyyy-mm-dd"/>
					</div>
				</div>
			</div>

			<?php echo show_message("yyyy-mm-dd");?>
			<div class="row">
				<div class="col-sm-12">
					<?php show_error($err_dob, "text-danger");?>
				</div>
			</div>		

			<!-- DOB End-->

			<!--       Department        -->
			<div class="row">
						<div class="form-group">
							<label class="control-label col-sm-5" for="branch">Department/Branch</label>
							<div class="col-sm-7">
							
										 <div class="dropdown">
										 	<?php echo html_drop_down_selected("branches","name",$branch, 'class="form-control" id="sel1" name="branch"');?>
										</div> 				
			
							</div>
						</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<?php show_error($err_branch, "text-danger");?>
				</div>
			</div>	

			<!-- Roll No -->
			<?php echo data_entry_helper("roll_no_pf_no", "Roll No", $roll_no_pf_no, $roll_no_pf_no)?>


			<!--     Blood Group    Start      -->
			<div class="row">
						<div class="form-group">
							<label class="control-label col-sm-5" for="blood_group">Blood group</label>
							<div class="col-sm-7">
							
										 <div class="dropdown">
			
										   <?php echo html_drop_down_selected("blood_groups","name",$blood_group, 'class="form-control" id="sel1" name="blood_group"');?>
			
										</div> 				
							
							</div>
			
						</div>
			</div>


			<div class="row">
				<div class="col-sm-12">
					<?php show_error($err_blood_group, "text-danger");?>
				</div>
			</div>	
			<!--     Blood Group    End      -->

			<?php echo data_entry_helper("mobile", "Mobile Number", $mobile, $err_mobile) ?>
			<?php echo data_entry_helper("phone", "Phone Number", $phone, $err_phone) ?>
			<?php echo data_entry_helper("address1", "Address Line 1", $address1, $err_address1) ?>
			<?php echo data_entry_helper("address2", "Address Line 2", $address2, $err_address2) ?>
			<?php echo data_entry_helper("address3", "Address Line 3", $address1, $err_address3) ?>
			<?php echo data_entry_helper("pin", "PIN Code", $address1, $err_address3) ?>
			<?php echo data_entry_helper("district", "District", $district, $err_district) ?>
			<?php echo data_entry_helper("state", "State", $state, $err_state) ?>
			<?php echo data_entry_helper("country", "Country", $country, $err_country) ?>

			







							
		<div style="height:300px;width:300px;"></div>


<!--  working above  -->


			<!--               -->


			



    <!--div class="col-sm-2">
    
    				<div data-spy="affix" data-offset-bottom="0">
    
					      <h3>Details</h3>
					      <p>Please keep your profile updated</p>
					      <p>and ensure that all fields are correct</p>
							<button type="submit" class="btn btn-primary btn-lg"  onclick="return validate();"   name="btn_update_profile">Update</button>
							<br /><br />
							<p class="alert alert-info">
								Please do not use all Capital Letters.<br />
								Try to use First Letter Capital.
										
							</p>
					</div>


    </div-->
  </div>
</div>

</form>

<br />

									<!--
									Show Documents to Students '' tried out for Titty
									<div class="pull-right">
										<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
										
											<button type="submit" class="btn btn-primary btn-lg"  onclick="return validate();"   name="btn_get_documents">Get Documents</button>
										
										</form>
										<br /><br />	
									</div>
									-->
									
									<br /><br />		
		

</div>	
	
<!-- =========== FORM END  ================= -->

								<br />

   					</div><!--div class="col-sm-6"-->
   					<div class="col-sm-3"></div>
 </div><!--div class="row"-->
 
    
<script type="text/javascript" >


document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("change_password").click();
});



</script>







<?php include 'include/footer.php';
// DB Connection -------------------------------------- CLOSE
$conn = null; ?>








