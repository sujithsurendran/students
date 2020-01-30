<?php

global $privileges;

$email = $password = $name = $joining_date = $login = $date_of_joining_institution = $branch = $roll_no_pf_no = $blood_group = $mobile = "";
$phone = $address1 = $address2 = $address = $district = $state = $country = $photo_file_name =  ""; 

$err_email = $err_name = $err_dob = $err_password = $err_captcha = $err_password_confirm = $err_login = $err_branch = $err_date_of_joining_institution = $err_joining_date ="";
$err_blood_group = $err_mobile = $err_phone = $err_address1 = $err_pin = $err_district = $err_state = $err_country = "";
$err_address1 = $err_address2 = $err_address3 = $err_roll_no_pf_no = $err_joining_date = $err_user_type =  $err_photo_file_name  = "" ;


$user = fetch_data($_SESSION["user_id"]);

if(is_null($user)) {
	
		$_SESSION["user_id"] = null;
		$_SESSION['LEVEL_1_CLEAR'] = false;
		redirect("sign-in-1.php");
	}else {
		//		
	}


if(!isset($_SESSION['user_id'])) {
	
		redirect('sign-in-1.php');	
	
}





if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btn_update_profile']) ) {
	
	
	
	assign_posted_values($_POST);
	$valid_data = validate_fields();

	if($valid_data) {
			$ret_val = upload_photo($photo_file_name);
			if($ret_val != ""){
					$valid_data = false;
					add_to_error_messages($ret_val);				// display error messages for upload photo	
					redirect('profile.php');
			}
	}

	if($valid_data) {
		

					if(update_or_write()){
						
						add_to_error_messages("Profile Updated.");
						//redirect('profile.php');
						
					}else {
						add_to_error_messages("Sorry, Unable to update.");
			
					}
		
	}else {

				// validation failed
				add_to_error_messages("Invalid data.");
				
	}
	
	
}elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['btn_cancel']) ) {
	$user = fetch_data($_SESSION["user_id"]);
	assign_fetched_values($user);	
	
}


// if control does not come from POSt, load details from db
// if control comes from POST, values are already held in global variables
if( $_SERVER['REQUEST_METHOD'] != "POST" &&  isset($_SESSION['user_id'])) {
	
	

	
	$user = fetch_data($_SESSION["user_id"]);
	assign_fetched_values($user);
	
}elseif(  $_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['user_id'])) {
	
	
	
		
	
		// invoked after update and when there is validation error	
	
		// Do nothing
		// data already loaded from db  Session[UserID] to global variables through assign_posted_values

}




/*		==============================================

			- - - - - -  Functions - - - - - -

			==============================================
*/


function fetch_data($id) {
global $db;
	$sql = $db->prepare("SELECT * FROM users WHERE users.id = :key_value");
	$sql->execute(array( ':key_value' => $id));
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	return($row);

}


function update_or_write()	{
global $password, $db, $branch, $blood_group, $arr_alert,$enable_log;
$ret_val = false;
$enable_log=true;
		

	//	try{
			
			
	//		$db->beginTransaction();
			// Begin transaction
								if(!isset($_SESSION['new_user'])) {
									
									// existing user				
					
										if($password=="") {
											// if user has left password field UnEdited
											// save the encrypted passwd
											$password = get_value_from_table("users", "password", "id", $_SESSION['user_id']);
											// do not md5 this password
											
										}else {
											
											$password = md5($password);
											
										}
					
									// existing user - delete and insert
									
									//$sql = "DELETE FROM `users` WHERE `id` = :id";
									//$query = $db->prepare( $sql );
									//$query->execute( array( ":id" => $_SESSION['user_id'] ) );
									

									$ret_val = update_data();
									
								}else {
									

									// new user. Just write data
									$password = md5($password);				
									$ret_val = write_data();
									
									
								}
								
						
								
								
								
								
	/*	$db->commit();	
		write_log("Commit trans- update_or_write()");
		}catch(PDOException $e){
			
		
			write_log("Exception in function update_or_write at " . time() . $e->getMessage() . "- " . $_SESSION['user_id']);
		
			array_push($arr_alert, $e->getMessage()) ;
			// End transaction
			$db->rollBack();
			
		}	*/


return $ret_val;

} //update_or_write



function write_data(){
	

global $db, $arr_alert;
global $email, $password, $name, $dob, $branch, $login, $mobile, $phone, $date_of_joining_institution;
global $address1, $address2, $address3, $pin, $district, $state, $country, $blood_group, $roll_no_pf_no, $dob, $joining_date;
global $resized_image_file;
global $enable_log;
$enable_log=true;

		
			
		list($dd,$mm,$yy) = explode("/",$dob);
		$dob_db_formatted = $yy . "-" . $mm . "-" . $dd;
		
		
		list($dd,$mm,$yy) = explode("/",$date_of_joining_institution);
		$date_of_joining_institution_db_formatted = $yy . "-" . $mm . "-" . $dd;


		list($dd,$mm,$yy) = explode("/",$joining_date);
		$joining_date_db_formatted = $yy . "-" . $mm . "-" . $dd;



		try {
			
			
			$date = new DateTime();

			$sql = $db->prepare("INSERT INTO users (id, date_of_joining_institution, email, branch, login, name, dob, password, password_hash, 
			mobile, phone, address1, address2, address3, pin, district, state, country, blood_group_id, roll_no_pf_no, joining_date, created_at)
			VALUES(:id, :date_of_joining_institution, :email, :branch, :login, :name, :dob, :password, :password_hash, :mobile, :phone, :address1, :address2, :address3, 
			:pin, :district, :state, :country, :blood_group, :roll_no_pf_no, :joining_date, :created_at)");
			
			
			$id = $_SESSION['user_id'];

			

			$blood_group = get_value_from_table("blood_groups", "name", "name", $blood_group);
			$branch = get_value_from_table("branches", "name", "name", $branch);
			$created_date = $date->format("Y-m-d H:i:s");			
			
			
			$sql->execute(array(
					':id' => $id,
					':date_of_joining_institution' => date("Y-m-d H:i:s", strtotime($date_of_joining_institution)),
					':email'	 => $email, 
					':branch' => $branch, 
					':login' => $login, 
					':name' => $name, 
					':dob' => date("Y-m-d H:i:s", strtotime($dob_db_formatted)),
					':password' => $password, 
					':password_hash' => '', 
					':mobile' => $mobile,
					':phone' => $phone,
					':address1' => $address1,
					':address2' => $address2,
					':address3' => $address3,
					':pin' => $pin,
					':district' => $district,
					':state' => $state,
					':country' => $country,
					':blood_group' => $blood_group,
					':roll_no_pf_no' => $roll_no_pf_no,
					':joining_date' => date("Y-m-d H:i:s", strtotime($joining_date_db_formatted)),			
					':created_at' => $created_date
				    )
			     );
			
					$_SESSION['photo_file_name'] = substr($_SESSION['photo_file_name'],0,strlen($_SESSION['photo_file_name'])-4);

					rename($_SESSION['photo_file_name'] . ".jpg", $_SESSION['photo_file_name'] . "_" . preg_replace('/[^0-9]/', '', $created_at) . ".jpg" );
					// file is changed to solve the issue of image using the cached file if same name is used		
					
		   return true;

		}catch(PDOException $e){

			if($e->getCode() == 23000 ){

				array_push($arr_alert, "<span style='color:red;'>Sorry, unable to save data please contact the Administrator.</span>");
				return false;


			}else {
				//array_push($arr_alert, $sql . "<br>" . $e->getMessage() . " at " . time()) ;
				die($e->getMessage());
				return false;
			}
		}
}

function update_data(){
	

global $db, $arr_alert;
global $email, $password, $name, $dob, $branch, $login, $mobile, $phone, $date_of_joining_institution;
global $address1, $address2, $address3, $pin, $district, $state, $country, $blood_group, $roll_no_pf_no,$joining_date;
$joining_date_db_formatted = $resized_image_file = $photo_file_name = "";

		
			
		list($yy,$mm,$dd) = explode("/",$dob);
		$dob_db_formatted = $yy . "-" . $mm . "-" . $dd;


		

	
		if($joining_date != "" && $joining_date != "1970/01/01"){
			list($yy,$mm,$dd) = explode("/",$joining_date);
			$joining_date_db_formatted = $yy . "-" . $mm . "-" . $dd;
		}else {
			
			$joining_date_db_formatted="";
			
			}


		if($date_of_joining_institution != "" && $date_of_joining_institution != "1970/01/01"){
			list($yy,$mm,$dd) = explode("/",$date_of_joining_institution);
			$date_of_joining_institution_db_formatted = $yy . "-" . $mm . "-" . $dd;
		}else {
			
			$date_of_joining_institution_db_formatted="";
			
			}

		


		try {
			
			
			$date = new DateTime();

			$id = $_SESSION['user_id'];


			$blood_group = get_value_from_table("blood_groups", "id", "id", $blood_group);
			$branch = get_value_from_table("branches", "id", "id", $branch);
			$password_hash = '';
		
			
			
			$created_at=$date->format("Y-m-d H:i:s");
		
			$sql_string="UPDATE users SET 
					date_of_joining_institution = :date_of_joining_institution, 
					email = :email, 
					branch = :branch,  
					login = :login, 
					name = :name, 
					dob = :dob, 
					password = :password, 
					password_hash = :password_hash, 
					mobile = :mobile,
					phone = :phone, 
					address1 = :address1, 
					address2 = :address2, 
					address3 = :address3, 
					pin = :pin, 
					district = :district, 
					state = :state,
					country = :country, 
					blood_group_id = :blood_group, 
					roll_no_pf_no = :roll_no_pf_no, 
					joining_date = :joining_date, 			
					created_at = :created_at WHERE 
					id = :id";
					

					
			$sql = $db->prepare($sql_string);

		
			$retval=$sql->execute(array(
					':date_of_joining_institution' => $date_of_joining_institution_db_formatted,	
					':email'	 => $email, 
					':branch' => $branch, 
					':login' => $login, 
					':name' => $name, 
					':dob' => date("Y-m-d H:i:s", strtotime($dob_db_formatted)),
					':password' => $password, 
					':password_hash' => $password_hash, 
					':mobile' => $mobile,
					':phone' => $phone,
					':address1' => $address1,
					':address2' => $address2,
					':address3' => $address3,
					':pin' => $pin,
					':district' => $district,
					':state' => $state,
					':country' => $country,
					':blood_group' => $blood_group,
					':roll_no_pf_no' => $roll_no_pf_no,
					':joining_date' => date("Y-m-d H:i:s", strtotime($joining_date_db_formatted)),
					':created_at' => $created_at,
					':id' => $id					
				    )
			     );


					//	---------------
					// file is changed to solve the issue of image using the cached file if same name is used		
					//	-----------------

					//strip jpg
					$_SESSION['photo_file_name'] = substr($_SESSION['photo_file_name'],0,strlen($_SESSION['photo_file_name'])-4);
					
					// rename file with date string
					rename($_SESSION['photo_file_name'] . ".jpg", $_SESSION['photo_file_name'] . "_" . preg_replace('/[^0-9]/', '', $created_at) . ".jpg" );
					
					//assign new file name to session
					$_SESSION['photo_file_name'] = $_SESSION['photo_file_name'] . "_" . preg_replace('/[^0-9]/', '', $created_at) . ".jpg";
					
					$photo_file_name = $_SESSION['photo_file_name'];



			$log_file_name = "tmp/" . $date->format("Y_m") . "_user.log";
			
			$logging_info = "Updated by:" . $_SESSION['user_id'] . ", " . $name . "[id=" . $login . "]Profile Update:(" . ($retval==true?"Success":"Failure") . ")" . date("Y-m-d H:i:s", strtotime($dob_db_formatted)); 
			write_log($logging_info ,  $log_file_name);
					
		   return true;

									}catch(PDOException $e){
										if($e->getCode() == 23000 ){
											array_push($arr_alert, $e->getMessage());
											return false;
							
							
										}else {
											array_push($arr_alert, $e->getMessage() . " at " . time()) ;
											return false;

										}
									}

}




function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}



/*		----------------------------

				validate_fields
		------------------------------			

*/


function validate_fields() {

global $err_email,$err_password,$err_password_confirm, $err_name, $arr_alert, $err_captcham, $err_branch, $err_dob, $err_date_of_joining_institution;
global $valid_data;
global $db, $arr_alert;
global $email, $password, $password_confirm, $name, $dob, $branch, $login, $mobile, $phone, $date_of_joining_institution;
global $address1, $address2, $address3, $pin, $district, $state, $country, $blood_group, $roll_no_pf_no, $dob, $joining_date, $date_of_joining_institution;




$valid_data=true;

	//  email
 	if (empty($email)){$err_email = "Please enter email";$valid_data=false;} 
 	else {
 		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 				$err_email = "EmailID is invalid";
 				$valid_data=false;
 		}
 	}

	if($password_confirm == $password){
	
		// password confirm ok		
	
	}else {
		$err_password_confirm = "Password confirmation not matching";
		$valid_data=false;
		
	}

	//   captcha
	/*
  	if(empty(trim($_POST['cap']))) {
  		$err_captcha = "Please enter Captcha";
  		$valid_data=false;
  	} elseif($_POST['cap'] != $_SESSION['val_cap']){
  		$err_captcha = "Please enter Captcha properly";
  		$valid_data=false;
	} else {
		$cap = test_input($_POST["cap"]);
	}
*/
	

	//   name
  	if(empty($name)) {
  		$err_name = "Name cannot be empty";
  		$valid_data=false;
  	}  else {
  		if(!preg_match("/^[a-zA-Z '.]*$/", $name))  {
  			$err_name = "Invalid name! Only letters, White Spaces and '.' is allowed" . "[$name]";
  			$valid_data=false;
  		}
  	}

	//   internal id
	


  	if(empty($login)) {
  		$err_name = "Please enter your Admission Number";
  		$valid_data=false;
  	}


	

	// check dob validity
	$dob = str_replace("-", "/", $dob);
	
	
	// check validity of date_of_joining_institution
	//$date_of_joining_institution = str_replace("-", "/", $date_of_joining_institution);

		

		if(!ValidDate($date_of_joining_institution)){

							$valid_data = false;	
							$err_date_of_joining_institution = "Date of joining is incorrect!";
							add_to_error_messages("Date of joining is incorrect!");
		}else {
				
							list($yy,$mm,$dd)=explode("/", $date_of_joining_institution);
							
								if($yy>date("Y")) {
										$err_date_of_joining_institution = "Joining date cannot be beyond the current date";
										$valid_data = false;
								}
			
		}		//$date_of_joining_institution





	if(!ValidStudentDOB($dob)){

		$valid_data = false;
		$err_dob = "Please enter valid Date of Birth";
	
	}


	//   ------------- Validation of fields -END-
	if(!$valid_data){
		array_push($arr_alert, "Sorry, unable to register, Invalid data!");
	}

	return $valid_data;

}








function ValidStudentDOB($date)
{
	
		if(strlen($date)>10) {
			return false;
			}
				
	
	
    if (!isset($date) || $date=="")
    {
        return false;
    }
    
    list($yy,$mm,$dd)=explode("/",$date);
    

	// POTENTIAL AREA OF ERROR IN FUTURE ... .. BEWARE ...!

	if($yy<(date("Y")-STUDENT_MAX_AGE) || $yy>(date("Y")-STUDENT_MIN_AGE)) {
		return false;
	}

    
    
    if ($dd!="" && $mm!="" && $yy!="")
    {
        return checkdate($mm,$dd,$yy);
    }
    
}

function ValidDate($date)
{
	
		if(strlen($date)!=10) {

			return false;
			
			}
				
	
	
    if (!isset($date) || $date=="")
    {
        return false;
    }
    
    list($yy,$mm,$dd)=explode("/",$date);
    

	// POTENTIAL AREA OF ERROR IN FUTURE ... .. BEWARE ...!

	if($yy < APPLICATION_MIN_YEAR || $yy>APPLICATION_MAX_YEAR) {
		write_log("Date  > APPLICATION_MIN_YEAR  or DOB < APPLICATION_MIN_YEAR is a remote possibility");
		return false;
		
	}

    
    
    if ($dd!="" && $mm!="" && $yy!="")
    {
        
        return checkdate($mm,$dd,$yy);
    }else {
    
    	return false;
    
    }
}






/*
function upload_photo
	returns "" if success 
or error message if failure
*/


function upload_photo($old_photo){

global $resized_image_file, $photo_file_name;

$uploadOk = true;
$return_str="";

	global $login;
	
					if(empty(basename($_FILES["fileToUpload"]["name"])))	 {
						return "";
					}else {
						// do nothing
						$uploadOk=true;
					}				
	
				$target_dir = "uploads";
				$uploaded_file = $target_dir . "/original/" .  basename($_FILES["fileToUpload"]["name"]) ;
				

				$imageFileType = strtolower(pathinfo($uploaded_file,PATHINFO_EXTENSION));
				
				
				// Check if image file is actual image or fake image
				
				if(!empty($_FILES["fileToUpload"]["tmp_name"])){
					$uploadOk=true;
		    	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    }else {
		    	$uploadOk=false;
		    	return "Selected file is not an image. Pls upload a proper photo.";
		    }


		    if($check != false) {
					$uploadOk=true;
				        
			    } else {
						$uploadOk=false;	
		        return "Selected file is not an image. Pls upload a proper photo.";

			    }
		
				// Check file size
				if ($_FILES["fileToUpload"]["size"] > 5000000) {

						$uploadOk=false;
				    return "Sorry, your file is too large.";

				}else {

					$uploadOk=true;
					
					}
				

				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				   return "Sorry, only JPG, JPEG, PNG & GIF files are allowed."; 
				   $uploadOk = false;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == false) {
				    return "Sorry, Photo could not be uploaded.";
				// if everything is ok, try to upload file
				} else {
				    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploaded_file)) {
				    	
				    		$jpg_image = $target_dir . "/original/" . $login . "_.jpg";
				    		convertImage($uploaded_file, $jpg_image , 100);
				    		list($width, $height) = getimagesize($jpg_image);
								$new_height = 150;
								$new_width = ($new_height/$height)*$width;
								
								$resized_image_file = $target_dir . "/reduced/" . $login . ".jpg";
								$image_resource = imagecreatetruecolor($new_width, $new_height);

								$image = imagecreatefromjpeg($jpg_image);
								imagecopyresampled($image_resource, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
								imagejpeg($image_resource, $resized_image_file, 100);
			    			unlink($jpg_image);
				        $_SESSION['photo_file_name'] = $resized_image_file;
				        unlink($old_photo);
				    } else {
				    		$uploadOk=false;
				        $return_str = "Sorry, there was an error uploading your file.";
				        
				    }
				}	
	

	if($uploadOk == true){
		return "";
	}else {
		return $return_str;
		}		



}





function convertImage($originalImage, $outputImage, $quality)
{
    // jpg, png, gif or bmp?
    $exploded = explode('.',$originalImage);
    $ext = $exploded[count($exploded) - 1]; 

    if (preg_match('/jpg|jpeg/i',$ext))
        $imageTmp=imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i',$ext))
        $imageTmp=imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i',$ext))
        $imageTmp=imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i',$ext))
        $imageTmp=imagecreatefrombmp($originalImage);
    else
        return 0;

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}









/* -------------------------- 
Function to assign $_POST values to global variables
-----------------------------*/
function assign_posted_values($posted_data){



global $db, $arr_alert;
global $email, $password, $name, $dob, $branch, $login, $mobile, $phone, $date_of_joining_institution;
global $address1, $address2, $address3, $pin, $district, $state, $country, $blood_group, $roll_no_pf_no;
global $dob, $joining_date, $date_of_joining_institution, $photo_file_name;


	$email = test_input($_POST['email']);
	$password = $_POST['password'];
	$password_confirm = $_POST['password_confirm'];
	$name = format_strings(test_input($_POST['name']));
	$login = $_POST['login'];
	$dob = $_POST["dob"];
	$date_of_joining_institution = $_POST["date_of_joining_institution"];
	$branch = test_input($_POST["branch"]);
	$mobile = test_input($_POST["mobile"]);
	$phone = test_input($_POST["phone"]);
	$address1 = format_strings(test_input($_POST["address1"]));
	$address2 = format_strings(test_input($_POST["address2"]));
	$address3  = format_strings(test_input($_POST["address3"]));
	$pin = test_input($_POST["pin"]);
	$district = format_strings(test_input($_POST["district"]));
	$state = format_strings(test_input($_POST["state"]));
	$country = format_strings(test_input($_POST["country"]));
	$blood_group = test_input($_POST["blood_group"]);
	$roll_no_pf_no = test_input($_POST["roll_no_pf_no"]);
	$password = trim($_POST['password']);
	$joining_date = $_POST['joining_date'];
	
	//$photo_file_name = $login . preg_replace('/[^0-9]/', '', $user['created_at']) . "jpg";
	
 	$photo_file_name = $_SESSION['photo_file_name'];
 	

 	
}


function assign_fetched_values($user) {

global $name,$date_of_joining_institution,$joining_date,$dob,$email,$branch ,$login;
global $roll_no_pf_no,$mobile,$phone ,$address1,$address2 ,$address3,$pin ,$district, $state,$country, $blood_group,$user_type;
global $photo_file_name;



	$name = $user['name'];
	$_SESSION['name'] = $name;
	
	/* $date_of_joining_institution */
	if(!is_null($user['date_of_joining_institution'])){
		list($dd,$mm,$yy)=explode("-",$user['date_of_joining_institution']);
		$date_of_joining_institution = $dd . "/" . $mm . "/" . $yy;
	}else {
		$date_of_joining_institution="";
	}	
	
	

	/* $joining_date  for Employees*/
	if(!is_null($user['joining_date'])){
		list($dd,$mm,$yy)=explode("-",$user['joining_date']);
		$joining_date = $dd . "/" . $mm . "/" . $yy;
	}else {
		$joining_date="";
	}	
	

	$dob = $user['dob'];

	list($dd,$mm,$yy)=explode("-",$dob);
	$dob = $dd . "/" . $mm . "/" . $yy;

	$email = $user['email'];	
	$branch = $user['branch'];
	$login = $user['login'];
	$roll_no_pf_no = $user['roll_no_pf_no'];
	$mobile = $user['mobile'];
	$phone = $user['phone'];
	$address1 = $user['address1'];
	$address2 = $user['address2'];
	$address3 = $user['address3'];
	$pin = $user['pin'];
	$district = $user['district'];
	$state = $user['state'];
	$country = $user['country'];
	$blood_group = $user['blood_group_id'];
	$user_type = get_value_from_table("user_types", "name", "id", $user['user_type_id']);
	$photo_file_name = $login . "_" . preg_replace('/[^0-9]/', '', $user['created_at']) . ".jpg"; 

}




function format_strings($str){


		$str = preg_replace('/\s+/', ' ',$str);

    $result = "";

    $arr = array();
    $pattern = '/([;:,-.\/ X])/';
    $array = preg_split($pattern, $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

    foreach($array as $k => $v)
        $result .= ucwords(strtolower($v));

    //$result = str_replace("Mr.", "", $result); // remove Mr. in a String
    return $result;




	return ucwords($str,"\t\r\n\f\v,.-()@#");

}
?>


    
