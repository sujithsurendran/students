<?php session_start();

$page="sign-in-1";
$page_name="Authentication Level 1 of 2";
global $arr_alert;


include 'include/inc_constants.php';
include 'include/secure/inc_constants.php';
include 'include/inc_functions.php';
include 'include/db_connection.php';
include 'include/error_messages.php';
include 'include/inc_js_and_css.php';
include 'include/inc_site-header.php';
include 'include/page-header-and-menu.php';
include 'include/inc_sign-in-1.php';
?>

<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">      

			<!--  Login/Admission Number -->
			<div class="form-group">
							<div class="row">
								<div class="col-sm-1"></div>
							
										<label class="control-label col-sm-3" for login>Login</label>
										<input class="col-sm-4" type="text" name="login" class="form-control" id="login" autofocus />
										<span class="text-danger col-sm-3"> <?php echo $err_login;?></span>
							
								<div class="col-sm-1"></div>
							</div>
			</div>

			<!--  Captcha -->
			<div class="form-group">
							<div class="row">
								<div class="col-sm-1"></div>
							
										<label class="control-label col-sm-3" for admission_no>Enter displayed text</label>
										<div class="col-sm-2">
												<img src='./tmp/captcha.jpg' />
												<input type='text' name='captcha' placeholder = 'Type the above Text' class="form-control"/>
												
										</div>
										<div class="col-sm-2"></div>
										
										<span class="text-danger col-sm-3"><?php echo $err_captcha;?></span>
							
								<div class="col-sm-1"></div>
							</div>
			</div>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-6">
		<button type="submit" class="btn btn-primary right"  onclick="return validate();">Enter</button>
	</div>
	<div class="col-sm-5"></div>
</div>
				

</form>












<?php include 'include/footer.php';
// DB Connection -------------------------------------- CLOSE
$conn = null; ?>








