<?php 
function redirect_me_to($newPage) {
	header('location:'.$newPage);
	exit();
}	

function confirmlogin() {
	if(isset($_SESSION['email'])) {
		return true;
	}else{
		$_SESSION['errorMsg'] = "Login Required";
		redirect_me_to('login.php');
	}
}

?>