<?php // variables ----
$err_login=$err_captcha="";
$login="";
$_SESSION['signin_attempt']=0;

$_SESSION['logout']=false;

if(!isset($_SESSION['already-signed-in'])) {
	$_SESSION['already-signed-in']=false;
}

if($_SESSION['already-signed-in'] == true){
	redirect('profile.php');
}

if($_SERVER['REQUEST_METHOD'] == "POST") {

	if(validate_fields()) {


			if(is_registered_user($login)){
				$_SESSION['LEVEL_1_CLEAR'] = true;
				redirect('sign-in-2.php');
			}else {
				add_to_error_messages("Please contact Office/Administrator for correct Login");
				redirect('sign-in-1.php');				
			}
	}
}


/* functions  */





function validate_fields() {

global $err_login,$err_captcha;
global $login, $captcha;
$err_login=$err_captcha="";

$valid_data=true;

$_SESSION['user_entered_login']=$login=test_input($_POST['login']);
$captcha=test_input($_POST['captcha']);

	$_SESSION['login'] = $login;




	//   captcha
  	if(empty($captcha)) {
  		
		  		$err_captcha = "Please enter Captcha";
		  		$valid_data=false;
  		
  	} elseif($captcha != $_SESSION['val_cap']){

					

		  		$err_captcha = "Please enter Captcha properly";
		  		$valid_data=false;
		
	
		}

		if(empty(($login))) {
			
					$err_login = "Please enter login";
					$valid_data=false;
					
		}
	

	return $valid_data;

}


function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
generate_captcha();

?>
