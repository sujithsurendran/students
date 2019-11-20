<?php session_start();
$page="index";
$page_name="Home";
$show_update_and_cancel_button=true;
global $arr_alert;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'include/inc_constants.php';
include 'include/secure/inc_constants.php';
include 'include/inc_functions.php';
include 'include/db_connection.php';
include 'include/error_messages.php';
include 'include/inc_js_and_css.php';
include 'include/page-header-and-menu.php';





if(!isset($_SESSION['user_id'])) {
	redirect('index.php');
}

profile();

?>











<?php 







include 'include/footer.php';
// DB Connection -------------------------------------- CLOSE
$conn = null; ?>








