<?php 


global $arr_alert;
$err_email = $err_name = $err_password = $err_captcha = "";
$password="";


// Kick out unAuthorised users who have come here other than through sign-in-1
//
if(!$_SESSION['LEVEL_1_CLEAR'] && !$_SESSION['LEVEL_1_CLEAR'] == true) {
	redirect('sign-in-1.php');	
}


// -------------------
if(isset($_SESSION['user_id'])) {
	redirect('profile.php');
	
}


//-------------------
if($_SERVER['REQUEST_METHOD'] == "POST") {
	
	if(validate_fields()) {
		
		
		if($_SESSION['user_entered_login']==$_SESSION['login'] && md5($password) == $_SESSION['password']) {
			$_SESSION['user_id'] = get_value_from_table("users", "id", "login", $_SESSION['user_entered_login']);
			add_to_error_messages($_SESSION['user_name'] . ", Welcome on board.");
			//update_field_value("users","last_login",date("Y-m-d H:i:s"),"user_id ", intval($_SESSION['user_id']));	
			redirect('profile.php');

		}else{

			add_to_error_messages("Invalid Credentials");

			session_write_close();
			session_regenerate_id(true);
			redirect('sign-in-1.php');
			exit();
			die();
			
		
		}
	}
}
generate_captcha();














function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}



function validate_fields() {


global $err_email,$err_password,$err_name, $arr_alert, $err_captcha;
global $email, $password, $name, $valid_data;
$valid_data=true;



	//   password
  	if(empty(trim($_POST['password']))) {
  		$err_password = "Password cannot be empty";
  		$valid_data=false;
  	} else {
		$password = test_input($_POST["password"]);
	}


	//   captcha
	
  	if(empty(trim($_POST['captcha']))) {
  		$err_captcha = "Please enter Captcha";
  		$valid_data=false;
  	} elseif($_POST['captcha'] != $_SESSION['val_cap']){
  		$err_captcha = "Please enter Captcha properly";
  		$valid_data=false;
	} else {
		$cap = test_input($_POST["captcha"]);
	}
	
	


	//   ------------- Validation of fields -END-
	if(!$valid_data){
		$alert_string="Sorry, unable to register, Invalid data!";
		//array_push($arr_alert, "Sorry, Invalid email!");
		//$there_are_alerts=true;
	}

	return $valid_data;

}?>
