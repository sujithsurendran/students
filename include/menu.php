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
global $db, $show_update_and_cancel_button;





$sql=$db->prepare("SELECT * FROM menu WHERE user_type_id = " . $user_id);
$sql->execute();
$data = $sql->fetchAll(PDO::FETCH_ASSOC);



echo '<div class="row">';
					echo '<div class="col-sm-2"></div>';
						foreach($data as $row){

							//echo '<div class="col-sm-2"><span class ="menu" ><a href="' . $row['menu_link'] . '">' . '<span style="' . 'color:' . ($row['page']==$page?"grey;text-decoration:underline;":'') . '">' . $row['menu'] . '</span></a></div>';	
							
							if($row['page']==$page) {	
									echo '<div class="col-sm-2 current-page">
													<span class ="menu" >
														<a href="' . $row['menu_link'] . '">' . $row['menu'] . 
														'</a>
													</span>
												</div>';
							}else {
									echo '<div class="col-sm-2"><span class ="menu" ><a href="' . $row['menu_link'] . '">' . $row['menu'] . '</a></div>';	
							}	
					 		 
					 	}
					echo '<div class="col-sm-2"></div>';
				
				
												if(isset($_SESSION['name'])){

													$name = $_SESSION['name'];
												
												}else {
													$name="";
												}				
				
				
												if(isset($_SESSION['user_id'])) { 
													echo '<div class="col-sm-2"><span id="menu"><a href="logout.php"><span >Logout &nbsp;[' . $name . ']</span></a></span></div>';
															


												} else { 
													//echo '<div class="col-sm-2"><span id="menu"><a href="sign-in-1.php"><span ' . ($page=="sign-in-1" ? 'style="color:grey;"' : "") . '>Login</span></a></span></div>'	;	
													echo '<div class="col-sm-2"><span id="menu"><a href="sign-in-1.php">Login</a></span></div>'	;	
												} 
echo '</div>';	

					

}




function	show_update_and_cancel_button() {

echo '<div class="row">	
															<div class="col-sm-2"></div>							
							
															<div class="col-sm-8">
																	<button class="btn btn-primary btn-sm" type="submit" onclick="return validate();"   name="btn_update_profile"> Update </button>
																	<button class="btn btn-warning btn-sm" type="submit" onclick="return validate();"   name="btn_cancel"> Cancel </button>
															</div>
															
															<div class="col-sm-2"></div>															
															
															
															';

echo '</div>';	


} 


	
	
?>



