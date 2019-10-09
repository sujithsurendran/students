<?php
function print_alerts() {
global $arr_alert;	
	

		if(sizeof($arr_alert) >= 0 && $_SESSION['error_messages'] <> "")  { 	
		echo '<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert">×</button>
			<strong>'. print_array_in_lines($arr_alert) .'</strong> 
		</div>';
		reset($arr_alert);
		$_SESSION['error_messages']="";
		}


}
/* Functions START */
function print_array_in_lines($arr){

	$str_array = "";
	foreach($arr as $value) {
		if(trim($value)==""){
			//
		}else {
			$str_array .= "$value<br />";
		}
	}
	
	// remove last and first <br>
	//return substr($str_array,6,strlen($str_array)-7);
	return $str_array;
	
	
}

function display_error_messages(){
	
global $arr_alert;
		if(isset($_SESSION['error_messages'])) {
			if($_SESSION['error_messages'] != "")
			
				$arr_alert =  explode("<br />", $_SESSION['error_messages']);
				print_alerts();
		}
		$_SESSION['error_messages'] = "";
		
}


function show_error($err_msg, $err_style, $focus_object="") {

		if(strlen(trim($err_msg))>0) {				

			echo "<span class='" . $err_style . "'>" . $err_msg . "</span>" . "<script>document.getElementById('" . $focus_object . "').focus();</script>";;
						
		}
	
}
?>
