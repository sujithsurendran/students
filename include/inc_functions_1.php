<?php

function authenticate_password($admission_no, $password){
// used in signin 2	

	
$valid_user = false;

global $db, $str_privileges, $arr_alert;

// start
	$sql = $db->prepare("SELECT count(id) FROM users where password = :password and internal_id = :admission_no");
	$sql->execute(array(	':password' => md5($password), 
								':admission_no' => $admission_no
								));
	

		if ($sql->fetchColumn() == 1) {	
			//if(!isset($_SESSION['user_id'])) {
				$_SESSION['user_id'] = get_value_from_table("users", "id", "internal_id", $admission_no);
				$user_type_id = get_value_from_table("users", "user_type_id", "id", $_SESSION['user_id']);
				$user_type = get_value_from_table("user_types", "name", "id", $user_type_id);
				$_SESSION['user_type_id'] = $user_type_id;
				$_SESSION['user_type'] = $user_type;
				if(USER_TYPE_ADMIN == $user_type_id){
					$_SESSION['str_privileges'] = "";
					$_SESSION['user_type_id'] = USER_TYPE_ADMIN;
				}else {
					$_SESSION['str_privileges'] = " disabled = 'disabled' ";
					}
				
			//}
			$valid_user = true;
			return($valid_user);
		}else {
			
			$_SESSION['signin_attempt'] = $_SESSION['signin_attempt'] + 1;			
			echo $_SESSION['signin_attempt'];
			if($_SESSION['signin_attempt']<3) {
			redirect("signin2.php");
			}else {
				redirect("index.php");
				}


			}
	

	/*
	// It is not proper to write this code here! Redirection should be from Calling function
	if(!$valid_user){
		array_push($arr_alert, "<span style='color:red;'>Sorry, Invalid details</span>");
		session_destroy();
		redirect('signin1.php');
	}*/
}


function authenticate($email, $password){
$valid_user = false;

global $db, $arr_alert;

// start
	$sql = $db->prepare("SELECT count(id) FROM users where email = :email and password = :password");
	$sql->execute(array( ':email' => $email, ':password' => md5($password)));
	

		if ($sql->fetchColumn() == 1) {	
			//if(!isset($_SESSION['user_id'])) {
				$_SESSION['user_id'] = get_value_from_table("users", "id", "email", $email);
			//}
			$valid_user = true;
			return($valid_user);
		}

	if(!$valid_user){
		array_push($arr_alert, "<span style='color:red;'>Sorry, Invalid details</span>");
		//session_destroy();
		redirect('signin1.php');
	}
}

function is_registered_user($admission_no){
// Allows only users with Admission Number available in Db to enter
// Admission Number is entered at the time of admission or initial Import after admissions

global $db, $arr_alert, $a;
$is_registered_user = false;
$result = 0;

// start
	$sql = $db->prepare("SELECT count(id) FROM users where internal_id = :admission_no");
	$sql->execute(array( ':admission_no' => $admission_no));
	

	$result = $sql->fetchColumn();

		if ($result == 1) {	
		
		
				
			//if(!isset($_SESSION['user_id'])) {
				/*$_SESSION['user_id'] = get_value_from_table("users", "id", "internal_id", $admission_no);
				$_SESSION['password'] = get_value_from_table("users", "password", "internal_id", $admission_no);
				$_SESSION['admission_no'] = $admission_no;
				$_SESSION['user_name'] = get_value_from_table("users", "name", "id", $_SESSION['user_id']);*/

				$sql = $db->prepare("SELECT id, password, internal_id, name FROM users where internal_id = :admission_no");
				
				
				$sql->execute(array( ':admission_no' => $admission_no));
				$user = $sql->fetch(PDO::FETCH_ASSOC);
				
				//$_SESSION['user_id'] = $user['id'];				// UserID should be stored in Session only after signin2 
				$_SESSION['password'] = $user['password'];
				$_SESSION['admission_no'] = $user['internal_id'];
				$_SESSION['user_name'] = $user['name'];
				
				

				if ($_SESSION['password'] == ''){

					$_SESSION['user_id'] = $user['id'];				// UserID should be stored only i password is NULL i.e new User 
					$is_registered_user = false;
					setcookie('user_id', $user['id'], time() + (60 * 5), "/"); // 86400 = 1 day
					
				
				}else{
					
					//$_SESSION['user_id'] = $user['id'];				// UserID should be stored in Session only after signin2 
					$is_registered_user = true;
					$_SESSION['password'] = NULL;
				
				}
			//}
			
		}elseif($result == 0) {
	
			$is_registered_user = NULL;
			
		}else{
		
				//multiple records error
				die("Error. Multiple records. Please contact system administrator");				
		
		}


	
		return($is_registered_user);


}

function write_log($text, $log_file = "tmp/log.txt"){
global $enable_log;

if(!$enable_log) return;

$fp = fopen($log_file, 'a');
fwrite($fp, $text . "\n");
fclose($fp);


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
function 	check_authority($user_type_id){
	
if(isset($_SESSION['user_type_id'])) {
		if($_SESSION['user_type_id'] != $user_type_id) {
			header('Location:index.php');	
			}
}else {
		header('Location:index.php');
}
	
}	
	
function add_to_error_messages($msg) {	
	$_SESSION['error_messages'] = $_SESSION['error_messages'] . "<br />" . $msg;

	}

function update_field_value($table, $field,$set_value,$condition_field, $condition_value){
global $db;
	
	//$field . "," . $set_value . "," . $condition_field . "," .  $condition_value);	
	$sql_string =  "UPDATE " . $table . " SET " . $field . " = :set_value where " . $condition_field . " = :condition_value";
	//$sql_string = "UPDATE " . $table . " SET " . $field . " = '" . $set_value . "' where " . $condition_field . " = " . $condition_value;
	//write_log($sql_string);

	$sql = $db->prepare($sql_string);
	//$sql->execute();
	$sql->execute(array(
	':set_value'=>$set_value,
	':condition_value'=>$condition_value,
	));







}	

?php>