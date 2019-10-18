<?php session_start();
$page="contact";
$page_name="Contact";
global $arr_alert;


include 'include/inc_constants.php';
include 'include/secure/inc_constants.php';
include 'include/inc_functions.php';
include 'include/db_connection.php';
include 'include/error_messages.php';
include 'include/inc_js_and_css.php';
include 'include/inc_site-header.php';
include 'include/page-header-and-menu.php';?>



<div class="container" id="body-contents">
  <div class="row">
    <div class="col-sm-12">
			<?php print_alerts(); ?>
			<?php if(isset($msg)){ echo $msg;	} ?>




      

  <div class="row">
    				<div class="col-sm-3"></div>
    				<div class="col-sm-6">

		
		

	
								 

<p>
The Principal<br />
Model Engineering College<br />
Thrikkakara, Kochi<br />
Kerala. PIN: 682021<br />
Contact Id: principal@mec.ac.in<br />
Phone/Fax:+91-484-2577379 <br />
</p>














								<br />

   					</div><!--div class="col-sm-6"-->
   					<div class="col-sm-3"></div>
 </div><!--div class="row"-->
 
    






<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<?php include 'include/footer.php';
// DB Connection -------------------------------------- CLOSE
$conn = null; ?>








