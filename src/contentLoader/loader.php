<?php
if (!isset($_SESSION)) {
	session_start();
}

$isAdmin = true;
if (!isset($_SESSION['valid_admin']) || !$_SESSION['valid_admin']) {
	$isAdmin = false;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/permissions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbWorker/mysql.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/static-maps.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/contentLoader/abstract/contentLoader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/contentLoader/abstract/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/contentLoader/abstract/single.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/contentLoader/abstract/singleAdmin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/contentLoader/abstract/table.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/contentLoader/factory/factory.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/menu/artists.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/menu/artworks.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/menu/galleries.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/menu/exhibitions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/menu/locations.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/menu/publications.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/menu/contributers.php';

if (!$isAdmin) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/single/artist.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/contentLoader/impl/single/artwork.php';
} else {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/contentLoader/impl/artistAdmin.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/contentLoader/impl/artistsTable.php';
}



$loader = ContentLoaderFactory::Create();
$loader->PrintContent();
