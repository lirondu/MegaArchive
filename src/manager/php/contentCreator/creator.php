<?

if (! isset($_POST['table'])) { die('0'); }


require_once $_SERVER['DOCUMENT_ROOT'] . '/dbWorker/mysql.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/static-maps.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/ContentCreator/abstract/contentCreator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/ContentCreator/factory/creatorFactory.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/ContentCreator/impl/artist.php';



$creator = ContentCreatorFactory::Create();
$creator->Create();