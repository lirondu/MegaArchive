<?php
if (!isset($_SESSION)) {
	session_start();
}

$isAdmin = true;
if (!isset($_SESSION['valid_admin']) || !$_SESSION['valid_admin']) {
	$isAdmin = false;
}

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
</body>

</html>