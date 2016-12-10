<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbWorker/mysql.php';


if ( !isset($_POST['table']) ||
	 !isset($_POST['id']) ||
	 !isset($_POST['field']) ||
	 !isset($_POST['value']) ) {
	die('0');
}

$table	 = $_POST['table'];
$id		 = $_POST['id'];
$field	 = $_POST['field'];
$value	 = $_POST['value'];

$q = DbFunctions::UpdateEntry($table, $id, [$field], [$value]);

echo ($q) ? '1' : '0';
