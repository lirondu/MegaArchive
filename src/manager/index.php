<?
if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['valid_admin']) || !$_SESSION['valid_admin']) {
	header('location: /manager/login/');
} else {
	$isAdmin = true;
}


require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/login/expire.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/permissions/permissions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/staticMaps/staticMaps.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/dbWorker/mysql.php';
?>

<!DOCTYPE html>
<html>

<head>
	<? require_once $_SERVER['DOCUMENT_ROOT'] . '/common/html/htmlHead.php'; ?>
</head>

<body>
	<? require_once $_SERVER['DOCUMENT_ROOT'] . '/common/html/htmlBody.php'; ?>

	
	<!-- Admin css -->
	<link rel="stylesheet" href="css/layout.css">
	<link rel="stylesheet" href="css/cms-inline.css">

	<!-- Admin scripts -->
	<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>
	<script src="/params/params.js"></script>
	<script src="js/layout.js"></script>
	<script src="js/cms-config.js"></script>
	<script src="js/cms-common.js"></script>
	<script src="js/cms-inline-submit.js"></script>
	<script src="js/cms-inline-init.js"></script>
	<script src="js/contentDeleter.js"></script>

	<? require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/dynamicElements.php' ?>
</body>

</html>