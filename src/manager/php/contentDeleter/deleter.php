<?

if (!isset($_POST['table']) || !isset($_POST['id'])) {
	die('0');
}


require_once $_SERVER['DOCUMENT_ROOT'] . '/dbWorker/mysql.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/viewer/php/static-maps.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/ContentDeleter/abstract/contentDeleter.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/ContentDeleter/factory/deleterFactory.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/manager/php/ContentDeleter/impl/artist.php';


$deleter = ContentDeleterFactory::Create();
$deleter->Delete();