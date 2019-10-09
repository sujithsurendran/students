<?php 
$user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
$user_type = get_value_from_table("users", "user_type_id","id" , $user_id );

$menu[0][0] = "Home";$menu[0][1] = "index.php";
$menu[1][0] = "News";$menu1[1][1] = "inews.php";
$menu[2][0] = "Contact";$menu[2][1] = "contact.php";
  

switch ($user_type) {
	case USER_TYPE_ADMIN:
		include 'include/menu/_admin.php';
		break;
		
	case USER_TYPE_STUDENT:
		include 'include/menu/_student.php';
		break;

	default:
		include 'include/menu/_non_user.php';
	
	}	
	
?>



