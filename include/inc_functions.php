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







?>
