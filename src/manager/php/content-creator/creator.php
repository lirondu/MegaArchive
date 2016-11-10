<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/db-worker/mysql.php';


class ContentCreator {
	private $table;

	public function __construct() {
		if (!isset($_POST['table'])) {
			die('Wrong Params!! ContentCreator Failed!!');
		}

		$this->table = $_POST['table'];
	}

	public function Create() {
		try {
			$artists_id = DbFunctions::CreateEntry('artists', [], []);

			DbFunctions::CreateEntry(
				'artists_biography_t',
				['artist_id', 'lang_code'],
				[$artists_id, 'en']);

			DbFunctions::CreateEntry(
				'artists_biography_t',
				['artist_id', 'lang_code'],
				[$artists_id, 'de']);

			DbFunctions::CreateEntry(
				'artists_biography_t',
				['artist_id', 'lang_code'],
				[$artists_id, 'it']);

			DbFunctions::CreateEntry(
				'artists_t',
				['artist_id', 'lang_code'],
				[$artists_id, 'en']);

			DbFunctions::CreateEntry(
				'artists_t',
				['artist_id', 'lang_code'],
				[$artists_id, 'de']);

			DbFunctions::CreateEntry(
				'artists_t',
				['artist_id', 'lang_code'],
				[$artists_id, 'it']);
			
			echo '1';
		} catch(Exception $e) {
			die('Content Creator Failed!!');
		}
	}
}

$creator = new ContentCreator();
$creator->Create();