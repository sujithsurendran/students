<?php session_start();
$page="logout";
$page_name="Logged Out";
global $arr_alert;
    $_SESSION = array();
    session_destroy();

include 'include/inc_constants.php';
include 'include/secure/inc_constants.php';
include 'include/inc_functions.php';
include 'include/db_connection.php';
include 'include/error_messages.php';
include 'include/inc_js_and_css.php';
include 'include/inc_site-header.php';
include 'include/page-header-and-menu.php';

add_to_error_messages('Thank you.');
			$_SESSION['logout']=true;
			
?>

      

	
<br /><br />
  <div class="row">
    				<div class="col-sm-3"></div>
    				<div class="col-sm-6">

		
										<div class="alert alert-info">
										  <strong>Thank you.</strong> 
										</div>

   					</div><!--div class="col-sm-6"-->
   					<div class="col-sm-3"></div>
 </div><!--div class="row"-->
 
    






<?php include 'include/footer.php';
// DB Connection -------------------------------------- CLOSE
$conn = null; ?>








