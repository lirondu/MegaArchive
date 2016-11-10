<?php
if (!isset($_SESSION)) {
	session_start();
}

$isAdmin = true;
if (!isset($_SESSION['valid_admin']) || !$_SESSION['valid_admin']) {
	$isAdmin = false;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/permissions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db-worker/mysql.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/static-maps.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/content-loader/abstract/content-loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/content-loader/abstract/content-loader-menu-page.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/content-loader/abstract/content-loader-single.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/content-loader/abstract/content-loader-table.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/content-loader/factory/content-loader-factory.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/menu/content-loader-artists.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/menu/content-loader-artworks.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/menu/content-loader-galleries.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/menu/content-loader-exhibitions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/menu/content-loader-locations.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/menu/content-loader-publications.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/menu/content-loader-contributers.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/single/content-loader-artist.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/content-loader/impl/single/content-loader-artwork.php';


if ($isAdmin) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/content-loader/impl/content-loader-artist-admin.php';

	require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/content-loader/impl/content-loader-artist-table.php';
}


$loader = ContentLoaderFactory::Create();

if ($isAdmin) {
	$loader->PrintContentAdmin();
} else {
	$loader->PrintContent();
}
