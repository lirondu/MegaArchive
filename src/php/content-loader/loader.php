<?php

require_once '../permissions.php';
require_once '../../db-worker/mysql.php';
require_once '../static-maps.php';
require_once './abstract/content-loader.php';
require_once './abstract/content-loader-menu-page.php';
require_once './abstract/content-loader-single.php';
require_once './impl/menu/content-loader-artists.php';
require_once './impl/menu/content-loader-artworks.php';
require_once './impl/menu/content-loader-galleries.php';
require_once './impl/menu/content-loader-exhibitions.php';
require_once './impl/menu/content-loader-locations.php';
require_once './impl/menu/content-loader-publications.php';
require_once './impl/menu/content-loader-contributers.php';
require_once './impl/single/content-loader-artist.php';
require_once './impl/single/content-loader-artwork.php';
require_once './factory/content-loader-factory.php';


$loader = ContentLoaderFactory::Create();
$loader->PrintContent();