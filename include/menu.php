<?php 
$user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
$user_type = get_value_from_table("users", "user_type_id","id" , $user_id );


load_menu($user_id, $page);

/*switch ($user_type) {
	case USER_TYPE_ADMIN:
		include 'include/menu/_admin.php';
		break;
		
	case USER_TYPE_STUDENT:
		include 'include/menu/_student.php';
		break;

	default:
		include 'include/menu/_non_user.php';
	
	}	*/
	
	
function load_menu($user_id=0,$page){
global $db;

$sql=$db->prepare("SELECT * FROM menu WHERE user_type_id = " . $user_id);
$sql->execute();
$data = $sql->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="row">';
					echo '<div class="col-sm-2"></div>';
						foreach($data as $row){

							echo '<div class="col-sm-2"><a href="' . $row['menu_link'] . '">' . '<span style="' . 'color:' . ($row['page']==$page?"grey;text-decoration:underline;":'') . '">' . $row['menu'] . '</span></a></div>';	
					 		 
					 	}
					echo '<div class="col-sm-2"></div>';
				
				
				
												if(isset($_SESSION['user_id'])) { 
													echo '<div class="col-sm-2"><a href="logout.php">Logout</a></div>		
															<div class="col-sm-2">
															<button class = "sticky-button" id = "sticky-button" type="submit" onclick="return validate();"   name="btn_update_profile"> Update </button>
															</div>';
															
													//echo '<div class="col-sm-2"><a href="logout.php">Logout</a></div>		
													//		<div class="col-sm-2">
													//		<button class = "sticky-button" id = "sticky-button" type="submit" onclick="return validate();"   name="btn_update_profile"> Update </button>
													//		</div>';

												} else { 
													echo '<div class="col-sm-2"><a href="signin1.php"><span ' . ($page=="signin-1" ? 'style="color:grey;"' : "") . '>Login</span></a></div>'	;	
												} 
echo '</div>';	
		

}


	
	
?>



