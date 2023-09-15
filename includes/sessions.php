<?php session_start();


function myErrorMsg() {
	if (isset($_SESSION['errorMsg'])) {
		$output = '<div class="alert alert-danger alert-dismissible fade show position-fixed p-2 col-xl-12" style="border-radius: 0px; z-index: 3;" role="alert">';
		$output.= '<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close" style="cursor: pointer;">';
		$output.= '<span aria-hidden="true">&times;</span>';
		$output.= '</button>';
		$output.= $_SESSION['errorMsg'];
		$output.= '</div>';
		$_SESSION['errorMsg'] = null;
		return $output;
	}

}
function mySuccessMsg() {
	if (isset($_SESSION['successMsg'])) {
		$output = '<div class="alert alert-success alert-dismissible fade show position-fixed col-xl-12" style="border-radius: 0px; z-index: 3;" role="alert">';
		$output.= '<button type="button" class="close p-2" data-dismiss="alert" aria-label="Close" style="cursor: pointer;">';
		$output.= '<span aria-hidden="true">&times;</span>';
		$output.= '</button>';
		$output.= $_SESSION['successMsg'];
		$output.= '</div>';
		$_SESSION['successMsg'] = null;
		return $output;
	}

}


 ?>
