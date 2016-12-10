<?

abstract class ContentCreator {
	protected $table;

	public function __construct() {
		$this->table = $_POST['table'];
	}

	abstract protected function AddNewEntry();


	public function Create() {
		try {
			$this->AddNewEntry();
			echo '1';
		} catch(Exception $e) {
			die('Content Creator Failed!!');
		}
	}
}
