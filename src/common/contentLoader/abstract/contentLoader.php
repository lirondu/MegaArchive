<?php

abstract class ContentLoader {
	protected $collection;
	protected $pageId;
	protected $pageName;
	protected $lang;
	protected $view;
	protected $viewName;


	abstract public function PrintContent();


	public function __construct() {
		global $isAdmin;

		if (!isset($_GET['collection']) ||
			!isset($_GET['page']) ||
			!isset($_GET['lang']))
		{
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}

		if (! Permissions::ValidateCollectionsList($_GET['collection'])) {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}


		if ($_GET['collection'] === '0') {
			$collArr = DbFunctions::GetTableEntriesIdIndexed('collections', true);
			$collStr = '';
			foreach ($collArr as $key => $value) {
				$collStr .= $key . ',';
			}
			$this->collection = substr($collStr, 0, -1);
		} else {
			$this->collection = $_GET['collection'];
		}
		
		$this->pageId = $_GET['page'];
		$this->pageName = StaticMaps::$pages[$this->pageId]['table'];
		$this->lang = $_GET['lang'];

		if (!$isAdmin && !StaticMaps::$pages[$this->pageId]['is_public']) {
			 die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}
	}

}