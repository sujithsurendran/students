<?php
profile();
global $privileges;

// variables ---
$email = $password = $name = $joining_date = "";
//$arr_alert=array("");
$err_email = $err_name = $err_dob = $err_password = $err_captcha = $err_password_confirm = $err_internal_id = $err_branch = $err_year_of_admission = "";
$err_blood_group = $err_mobile = $err_phone = $err_address1 = $err_pin = $err_district = $err_state = $err_country = "";
$err_address1 = $err_address2 = $err_address3 = $err_roll_no_pf_no = $err_joining_date = $err_user_type ="" ;
// -----


$user = fetch_data($_SESSION["user_id"]);
if(is_null($user)) {
	$_SESSION["user_id"] = null;
	$_SESSION['LEVEL_1_CLEAR'] = false;
	redirect("signin1.php");
	}else {
		
		}


if($_SERVER['REQUEST_METHOD'] == "POST"  && isset($_POST['btn_get_documents'])  ) {



$admission_number = $user['internal_id'];
	
$filename = "./documents/" . $admission_number . ".png";
write_log($filename);
if(file_exists($filename)){

    //Get file type and set it as Content Type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    header('Content-Type: ' . finfo_file($finfo, $filename));
    finfo_close($finfo);

    //Use Content-Disposition: attachment to specify the filename
    header('Content-Disposition: attachment; filename='.basename($filename));

    //No cache
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    //Define file size
    header('Content-Length: ' . filesize($filename));

    ob_clean();
    flush();
    readfile($filename);
    exit;
}	
	
}



if($_SERVER['REQUEST_METHOD'] == "POST"  && isset($_POST['btn_update_profile'])  ) {


	if(validate_fields()) {
				
					if(photo_uploaded()) {
							// photo upload successfull
						}else {
							array_push($arr_alert,"Error while uploading Photo");
							
					}// file upload End


					if(update_or_write()){
						
						
						array_push($arr_alert, "Profile Updated.");
						//redirect('dashboard.php');
						
					}else {
						array_push($arr_alert,"Error.");
			
					}
		

		
	}else {
				// validation failed
				array_push($arr_alert, "Invalid data.");
	}
	
	
}elseif(isset($_SESSION['user_id'])){


	$user = fetch_data($_SESSION["user_id"]);
	
	
	$name = $user['name'];
	$year_of_admission = $user['year_of_admission'];	
	
	$dob = $user['dob'];
	
	

	list($dd,$mm,$yy)=explode("-",$dob);
	$dob = $dd . "/" . $mm . "/" . $yy;





	if(!is_null($user['joining_date'])){
		list($dd,$mm,$yy)=explode("-",$user['joining_date']);
		$joining_date = $dd . "/" . $mm . "/" . $yy;
	}else {
		$joining_date="";
	}
	


	

	$email = $user['email'];	
	$branch = $user['branch'];
	$internal_id = $user['internal_id'];
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
	$blood_group = $user['blood_group'];
	$joining_date = $user['joining_date'];	
	$user_type = get_value_from_table("user_types", "name", "id", $user['user_type_id']);

	
}else {
redirect('signin1.php');	
	
}

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
		

		try{
			
			
			write_log("begin trans- update_or_write()");
			$db->beginTransaction();
			// Begin transaction
								if(isset($_SESSION['new_user'])) {
									
					
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
								
						
								
								
								
								
		$db->commit();	
		write_log("Commit trans- update_or_write()");
		}catch(PDOException $e){
			
		
			write_log("Exception in function update_or_write at " . time() . $e->getMessage() . "- " . $_SESSION['user_id']);
		
			array_push($arr_alert, $e->getMessage()) ;
			// End transaction
			$db->rollBack();
			
		}	


return $ret_val;

} //update_or_write



function write_data(){
	

global $db, $arr_alert;
global $email, $password, $name, $dob, $branch, $internal_id, $mobile, $phone, $year_of_admission;
global $address1, $address2, $address3, $pin, $district, $state, $country, $blood_group, $roll_no_pf_no, $dob, $joining_date;

global $enable_log;
$enable_log=true;

		
			
		list($dd,$mm,$yy) = explode("/",$dob);
		$dob_db_formatted = $yy . "-" . $mm . "-" . $dd;
		
		
		list($dd,$mm,$yy) = explode("/",$joining_date);
		$joining_date_db_formatted = $yy . "-" . $mm . "-" . $dd;

		try {
			
			
			$date = new DateTime();

			$sql = $db->prepare("INSERT INTO users (id, year_of_admission, email, branch, internal_id, name, dob, password, password_hash, 
			mobile, phone, address1, address2, address3, pin, district, state, country, blood_group, roll_no_pf_no, joining_date, created_at)
			VALUES(:id, :year_of_admission, :email, :branch, :internal_id, :name, :dob, :password, :password_hash, :mobile, :phone, :address1, :address2, :address3, 
			:pin, :district, :state, :country, :blood_group, :roll_no_pf_no, :joining_date, :created_at)");
			
			
			$id = $_SESSION['user_id'];

			

			$blood_group = get_value_from_table("blood_groups", "blood_group_name", "blood_group_name", $blood_group);
			$branch = get_value_from_table("branches", "name", "name", $branch);
			
			$sql->execute(array(
					':id' => $id,
					':year_of_admission' => $year_of_admission,	
					':email'	 => $email, 
					':branch' => $branch, 
					':internal_id' => $internal_id, 
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
					':created_at' => $date->format("Y-m-d H:i:s")
				    )
			     );
			
					
		   return true;

		}catch(PDOException $e){

			if($e->getCode() == 23000 ){

				array_push($arr_alert, "<span style='color:red;'>Sorry, unable to save data please contact the Administrator.</span>");
				return false;


			}else {
				array_push($arr_alert, $sql . "<br>" . $e->getMessage() . " at " . time()) ;
				return false;
			}
		}
}

function update_data(){
	

global $db, $arr_alert;
global $email, $password, $name, $dob, $branch, $internal_id, $mobile, $phone, $year_of_admission, $joining_date;
global $address1, $address2, $address3, $pin, $district, $state, $country, $blood_group, $roll_no_pf_no;
$joining_date_db_formatted="";

		
			
		list($yy,$mm,$dd) = explode("/",$dob);
		$dob_db_formatted = $yy . "-" . $mm . "-" . $dd;


	
		if($joining_date != "" && $joining_date != "1970-01-01"){
			list($yy,$mm,$dd) = explode("-",$joining_date);
			$joining_date_db_formatted = $yy . "-" . $mm . "-" . $dd;
		}else {
			
			$joining_date_db_formatted="";
			
			}

		


		try {
			
			
			$date = new DateTime();

			$id = $_SESSION['user_id'];


			$blood_group = get_value_from_table("blood_groups", "id", "id", $blood_group);
			$branch = get_value_from_table("branches", "id", "id", $branch);
			$password_hash = '';
		
			
			
			$created_at=$date->format("Y-m-d H:i:s");
			
			$sql_string="UPDATE users SET 
					year_of_admission = :year_of_admission, 
					email = :email, 
					branch = :branch,  
					internal_id = :internal_id, 
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
					blood_group = :blood_group, 
					roll_no_pf_no = :roll_no_pf_no, 
					joining_date = :joining_date, 
					created_at = :created_at WHERE 
					id = :id";
					

					
			$sql = $db->prepare($sql_string);

		
			$retval=$sql->execute(array(
					':year_of_admission' => $year_of_admission,	
					':email'	 => $email, 
					':branch' => $branch, 
					':internal_id' => $internal_id, 
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


			//write_log("Profile Update:(" . ($retval==true?"Success":"Failure") . ")" . date("Y-m-d H:i:s", strtotime($dob_db_formatted)) , date("Y-m-", strtotime($dob_db_formatted)) . "user.log");
			$log_file_name = "tmp/" . $date->format("Y-m") . "_user.log";
			
			$logging_info = "Updated by:" . $_SESSION['user_id'] . ", " . $name . "[id=" . $internal_id . "]Profile Update:(" . ($retval==true?"Success":"Failure") . ")" . date("Y-m-d H:i:s", strtotime($dob_db_formatted)); 
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



function validate_fields() {

global $err_email,$err_password,$err_password_confirm, $err_name, $arr_alert, $err_captcham, $err_branch, $err_dob, $err_year_of_admission;
global $valid_data;
global $db, $arr_alert;
global $email, $password, $name, $dob, $branch, $internal_id, $mobile, $phone, $year_of_admission;
global $address1, $address2, $address3, $pin, $district, $state, $country, $blood_group, $roll_no_pf_no, $dob, $joining_date;

$valid_data=true;

	//  email
 	if (empty($_POST['email'])){
 		$err_email = "Please enter email";
 		$valid_data=false;
 	} else {
 		$email = test_input($_POST['email']);
 		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 			$err_email = "EmailID is invalid";
 			$valid_data=false;
 		}elseif($email==$internal_id) {
 			$valid_data=true;
 			}
 	}



	//   password
  	/*if(empty(trim($_POST['password']))) {
  		$err_password = "Password cannot be empty";
  		$valid_data=false;
  	} else {
		$password = test_input($_POST["password"]);
	}*/

	//   password confirm
  	/*if(empty(trim($_POST['password_confirm']))) {
  		$err_password_confirm = "Please confirm the Password by ReEntering";
  		$valid_data=false;
  	} else {
		$password = test_input($_POST["password_confirm"]);
	}*/


	if($_POST['password_confirm']== $_POST['password']){
	
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
  	if(empty($_POST['name'])) {
  		$err_name = "Name cannot be empty";
  		$valid_data=false;
  	}  else {
  		$name = ucwords(test_input($_POST["name"]));
  		if(!preg_match("/^[a-zA-Z ]*$/", $name))  {
  			$err_name = "Invalid name! Only letters, White Spaces and '.' is allowed";
  			$valid_data=false;
  		}
  	}
  	

	//   internal id
  	if(empty($_POST['internal_id'])) {
  		$err_name = "Please enter your Admission Number";
  		$valid_data=false;
  	}  else {
  		$internal_id = test_input($_POST["internal_id"]);

  	}

	// check dob validity
	$dob = trim($_POST["dob"]);
	$dob = str_replace("-", "/", $dob);
	
	
	
	if(!ValidateDate($dob)){
		$valid_data = false;
		$err_dob = "Please enter valid Date of Birth";
		write_log("Invalid DOB " . $dob . ">>" . $valid_data . "<<");
	
	}
	
$year_of_admission = (integer)test_input($_POST['year_of_admission']);	
	if($year_of_admission<2015 || $year_of_admission>date("Y"))  {
		$valid_data = false;
		$err_year_of_admission = "Invalid Year of Admission";
		
	}

$branch = test_input($_POST["branch"]);
$internal_id = test_input($_POST["internal_id"]);
$mobile = test_input($_POST["mobile"]);
$phone = test_input($_POST["phone"]);
$address1 = ucwords(test_input($_POST["address1"]));
$address2 = ucwords(test_input($_POST["address2"]));
$address3  = ucwords(test_input($_POST["address3"]));
$pin = test_input($_POST["pin"]);
$district = ucwords(test_input($_POST["district"]));
$state = ucwords(test_input($_POST["state"]));
$country = ucwords(test_input($_POST["country"]));
$blood_group = test_input($_POST["blood_group"]);
$roll_no_pf_no = test_input($_POST["roll_no_pf_no"]);
$password = trim($_POST['password']);

$joining_date = $_POST['joining_date'];


	//   ------------- Validation of fields -END-
	if(!$valid_data){
		array_push($arr_alert, "Sorry, unable to register, Invalid data!");
	}

	return $valid_data;

}

function ValidateDate($date)
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

	if($yy<1950 || $yy>2010) {
		write_log("Date of Birth > 2010  or DOB<1950 is a remote possibility");
		return false;
		
	}

    
    
    if ($dd!="" && $mm!="" && $yy!="")
    {
        
        return checkdate($mm,$dd,$yy);
    }
    
    return false;
}

function photo_uploaded(){
	global $arr_alert, $internal_id;
	
					if(empty(basename($_FILES["fileToUpload"]["name"])))	 {
						return true;
					}else {
					}				
	
				$target_dir = "uploads";
				$uploaded_file = $target_dir . "/original/" .  basename($_FILES["fileToUpload"]["name"]) ;
				

			


				
				
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($uploaded_file,PATHINFO_EXTENSION));
				

								
				
				
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
				    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				    if($check !== false) {
				        $uploadOk = true;
				        
				    } else {
				        array_push($arr_alert, "File is not an image.");
				        $uploadOk = false;
				        return($uploadOk);
				    }
				}
				
				// Check file size
				if ($_FILES["fileToUpload"]["size"] > 500000) {
				    array_push($arr_alert, "Sorry, your file is too large.");
				    $uploadOk = false;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				    array_push($arr_alert, "Sorry, only JPG, JPEG, PNG & GIF files are allowed."); 
				    $uploadOk = false;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
				    array_push($arr_alert, "Sorry, your file was not uploaded.");
				// if everything is ok, try to upload file
				} else {
				    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploaded_file)) {
				    	
				    		$jpg_image = $target_dir . "/original/" . $internal_id . "_.jpg";
				    		convertImage($uploaded_file, $jpg_image , 100);
				    		list($width, $height) = getimagesize($jpg_image);
								$new_height = 150;
								$new_width = ($new_height/$height)*$width;
								
								$resized_image_file = $target_dir . "/reduced/" . $internal_id . ".jpg";
								$image_resource = imagecreatetruecolor($new_width, $new_height);

								$image = imagecreatefromjpeg($jpg_image);
								imagecopyresampled($image_resource, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
								imagejpeg($image_resource, $resized_image_file, 100);
			    					unlink($jpg_image);

				        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				        
				    } else {
				        array_push($arr_alert, "Sorry, there was an error uploading your file.");
				    }
				}	
	


return $uploadOk;							
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
?>


    
