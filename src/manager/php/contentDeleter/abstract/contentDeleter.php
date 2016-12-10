<?

abstract class ContentDeleter {
	protected $table;
	protected $id;

	public function __construct() {
		$this->table = $_POST['table'];
		$this->id = $_POST['id'];
	}

	abstract protected function DeleteEntry();

	public function Delete() {
		try {
			$this->DeleteEntry();			
			echo '1';
		} catch(Exception $e) {
			die('Content Deleter Failed!!');
		}
	}
}