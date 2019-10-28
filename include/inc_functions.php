<?php 


// for debugging start
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// for debugging end

function redirect($url) {
    ob_start();
    header('Location: ' . $url);
    ob_end_flush();
    die();
}


function generate_captcha() {

	// Create a blank image and add some text
	$im = imagecreatetruecolor(120, 40);

	$text_color = imagecolorallocate($im, 233, 14, 91);
	$val= rand(9,true).rand(9,true).rand(9,true).rand(9,true);
	imagestring($im, 5, 5, 5,  $val , $text_color);

	$color1 = imagecolorallocate($im, 200, 240, 242);
	$color2 = imagecolorallocate($im,220,220,220);
	imagefill($im,0,0,$color1);
	for($i = 0; $i < 120; $i+=2) {
		for($j = 0; $j < 40; $j+=2) {
		    imagesetpixel($im, $i, $j, $color2);
		}
	}

	// Save the image as 'simpletext.jpg'
	imagejpeg($im, './tmp/captcha.jpg',100);

	// Free up memory
	imagedestroy($im);
	$_SESSION['val_cap']=$val;

}


function get_value_from_table($table, $field, $criteria_field, $criteria_value) {
global $db;

global $enable_log;
$enable_log=true;

	$p="SELECT $field FROM $table WHERE $criteria_field = :key_value";
	if(substr($p,1,10)== ":key_value") {
			die(substr($p,1,10));
		return null;
		
		}	
	
	//write_log("SELECT $field FROM $table WHERE $criteria_field = $criteria_value limit 1");
	$sql = $db->prepare("SELECT $field FROM $table WHERE $criteria_field = :key_value limit 1");
	$sql->execute(array( ':key_value' => $criteria_value));
	$row = $sql->fetch(PDO::FETCH_ASSOC);

	return($row[$field]);
}

function fire_query($qry) {
global $db;

global $enable_log;
$enable_log=true;

	
	//write_log("SELECT $field FROM $table WHERE $criteria_field = $criteria_value limit 1");
	$sql = $db->prepare($qry);
	$sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);

	return($row['ret_val']);
}


function is_registered_user($login){
// Allows only users with Login	(Admission Number/PF/Unique_id) available in Db to enter
// Admission Number is entered at the time of admission or initial Import after admissions
// In the case of Employees, PF or Unique_id(for Guest/contract staff) is manually entered

global $db;
$is_registered_user = false;
$result = 0;



// start
	$sql = $db->prepare("SELECT count(id) FROM users where login = :login");
	$sql->execute(array( ':login' => $login));
	
	$result = $sql->fetchColumn();


		if ($result == 1) {	
		
				$sql = $db->prepare("SELECT id, password, login, name, user_type_id FROM users where login = :login");
				
				
				$sql->execute(array( ':login' => $login));
				$user = $sql->fetch(PDO::FETCH_ASSOC);
				$_SESSION['user_id'] = NULL;				// UserID should be stored in Session only after signin2 
				$_SESSION['password'] = $user['password'];
				$_SESSION['login'] = $user['login'];
				$_SESSION['user_name'] = $user['name'];
				$_SESSION['user_type_id'] = $user['user_type_id'];
				$is_registered_user = true;
			
		}elseif($result == 0) {

			$is_registered_user = NULL;
			
		}else{
				//multiple records error
				die("Error. Multiple records. Please contact system administrator");				
		
		}
return $is_registered_user;

}
function add_to_error_messages($msg) {	
	$_SESSION['error_messages'] = $_SESSION['error_messages'] . "<br />" . $msg;

}


function profile() {
	
	switch($_SESSION['user_type_id']) {
		case USER_TYPE_ADMIN:

				include('profile_admin.php');
				break;
				
		case USER_TYPE_STUDENT:
				include('profile_student.php');
				break;
		
		
		case USER_TYPE_STAFF:
				include('profile_staff_in_charge');
				break;
		
		
		/*case USER_TYPE_TEACHER:
				redirect('profile_teacher');
				break;
		
		
		case USER_TYPE_SUPERVISOR:
				redirect('profile_supervisor');
				break;
		
		
		case USER_TYPE_DATA_ENTRY_OPERATOR:
				redirect('profile_data_entry_operator');
				break;
		

		case USER_TYPE_PRINCIPAL:
				redirect('profile_principal');
				break;
				
				*/
		default:
				include('profile_student.php');
				break;
		}	
	
	
	
}




function data_entry_helper($fieldName, $caption, $value, $error, $readOnly=false){

$data_entry_helper_html = '
<div class="row">
						
						<div class="form-group">
								<label class="control-label col-sm-5" for="' . $fieldName . '">' . $caption . '</label>
								<div class="col-sm-7">
				      					<input name="' . $fieldName . '" value = "' .  $value . '" type="text" class="form-control" id="' . $fieldName . '" 
				      					placeholder="' . $fieldName . '" ' .  ($readOnly?'readonly="true"':'') . '>
								</div>
						</div>
</div>
<div class="row"><div class=col-sm-12>' .  show_error($error, "text-danger", $fieldName ) . '</div></div>';
return($data_entry_helper_html);


}

function show_message($message) {
	return '
			<div class="row" style="text-align:right;">
				<div class="col-sm-12 show_message">' . $message . '</span></div>			
			</div>'	;
	
	
	
	
	}
function html_drop_down_selected($tableName, $fieldName, $selection="", $html_string=""){
global $db;


$sql=$db->prepare("SELECT id, " . $fieldName . " FROM " . $tableName );
$sql->execute();
$data = $sql->fetchAll(PDO::FETCH_ASSOC);


$html_drop_down = "<select " . $html_string . ">";
foreach($data as $row)
	 $html_drop_down .= "<option value = " . $row['id'] . " " . ($row['id']==intval($selection)?" selected='SELECTED'":"") . "> " . $row[$fieldName] . "</option>";

$html_drop_down .= "</select>";
return($html_drop_down);
}


?>
