<?
if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['valid_admin']) || !$_SESSION['valid_admin']) {
	header('location: /manager/login/');
}


require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/login/expire.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/permissions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/static-maps.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db-worker/mysql.php';
?>

<!DOCTYPE html>
<html>

<head>
	<? require_once $_SERVER['DOCUMENT_ROOT'] . '/common/html_head.php'; ?>
</head>

<body>
	<? require_once $_SERVER['DOCUMENT_ROOT'] . '/common/html_body.php'; ?>

	
	<!-- Admin css -->
	<link rel="stylesheet" href="css/layout.css">
	<link rel="stylesheet" href="css/cms-inline.css">

	<!-- Admin scripts -->
	<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>
	<script src="js/layout.js"></script>
	<script src="js/cms-config.js"></script>
	<script src="js/cms-common.js"></script>
	<script src="js/cms-inline-submit.js"></script>
	<script src="js/cms-inline-init.js"></script>
</body>

</html>