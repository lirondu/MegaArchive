<?php

if (!isset($_GET['q']) || !isset($_GET['t'])) {
	die('ERROR!! Don\'t try manual queries!!');
}

require_once './../../db-worker/mysql.php';
require_once './search-artists.php';
require_once './search-artworks.php';


abstract class SearchTable {
	protected $results;
	protected $table;
	protected $query;


	public function __construct() {
		$this->table = $_GET['t'];
		$this->query = $_GET['q'];
	}


	public function PrintResults() {
		echo json_encode($this->results);
	}


	public function Search() {
		$this->results = DbFunctions::SearchInTable($this->table, $this->query, $this->fieldsArray);
	}
}







$searcher = null;
switch ($_GET['t']) {
	case 'artists':
		$searcher = new SearchTableArtists();
		break;

	case 'artworks':
		$searcher = new SearchTableArtworks();
		break;
	
	case 'all':
		$searcher = new SearchAllTables();
		break;

	default:
		die('ERROR!!');
}

$searcher->Search();
$searcher->PrintResults();
