<?php
(!isset($_SESSION)) ? session_start() : null;

// Timeout in seconds
$timeOut = 1200; //20 Min

// If only check then last activity is not updated
$onlyCheck = (isset($_POST['only-check'])) ? true : false;


if (isset($_SESSION['last_activity'])) {
	$inactive = time() - $_SESSION['last_activity'];
	
	if ($inactive > $timeOut) {
		if ($onlyCheck) {
			echo 'expired';
		} else {
			header("Location: /manager/login/logout.php");
		}
	} else if ($onlyCheck) {
		echo 'valid';
	}
}

if (! $onlyCheck) {
	$_SESSION['last_activity'] = time();
}
