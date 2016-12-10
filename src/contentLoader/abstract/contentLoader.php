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
		if (!isset($_GET['collection']) ||
			!isset($_GET['page']) ||
			!isset($_GET['lang']))
		{
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}

		if (! Permissions::ValidateCollectionsList($_GET['collection'])) {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}


		$this->collection = $_GET['collection'];
		$this->pageId = $_GET['page'];
		$this->pageName = StaticMaps::$pages[$this->pageId]['table'];
		$this->lang = $_GET['lang'];
	}

}