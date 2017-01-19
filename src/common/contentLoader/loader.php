<?php
if (!isset($_SESSION)) {
	session_start();
}

$isAdmin = true;
if (!isset($_SESSION['valid_admin']) || !$_SESSION['valid_admin']) {
	$isAdmin = false;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/common/permissions/permissions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/dbWorker/mysql.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/staticMaps/staticMaps.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/common/contentLoader/abstract/contentLoader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/contentLoader/abstract/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/contentLoader/abstract/single.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/contentLoader/abstract/singleAdmin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/contentLoader/abstract/table.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/contentLoader/factory/factory.php';

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
