<?php

abstract class ContentLoaderMenuPage extends ContentLoader {
	protected $order;
	protected $orderField;
	public $idsToQuery;
	protected $pageEntries;
	protected $linkToPage;
	protected $filters;
	protected $printGrouping;

	abstract protected function PrintEntryContent($entry);
	abstract protected function Query();


	public function PrintContentAdmin() {
		$this->PrintContent();
	}


	public function __construct() {
		parent::__construct();

		if (!isset($_GET['order']) ||
			!isset($_GET['view']))
		{
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}

		$this->order = $_GET['order'];

		if (! array_key_exists($this->order, StaticMaps::$orderFieldPerPage[$this->pageName])) {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}

		$this->orderField = StaticMaps::$orderFieldPerPage[$this->pageName][$this->order];

		$this->view = $_GET['view'];
		
		if ($this->view === '1') {
			$this->viewName = 'text';
		} else if ($this->view === '2') {
			$this->viewName = 'thumb';
		} else {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}
		
		$this->idsToQuery = DbFunctions::GetCollectionsPageRelationships($this->collection, $this->pageName);

		if (! $this->idsToQuery) {
			die('No results to show...');
		}

		$this->linkToPage = StaticMaps::$pages[$this->pageId]['link_to_page'];

		$this->filters = (isset($_GET['filters'])) ? ' AND ' . $_GET['filters'] : '';

		$this->printGrouping = (!isset($_GET['grouping']));

		$this->Query();
	}

	
	public function PrintContent() {
		if (!$this->pageEntries) {
			echo '<strong>No items to display!!</strong>';
			return;
		}

		?> <ul class="page-container-list"> <?

		foreach($this->pageEntries as $entry) {
			?>
			<li class="<?= $this->viewName ?>-entry-container">
				<? ($this->printGrouping) ? $this->PrintGroupingTitle($entry) : null; ?>
				<a 	href="javascript:void(0)" 
					class="<?= $this->viewName ?>-list-link"
					page="<?= $this->linkToPage ?>"
					entry-id="<?= $entry['id'] ?>">
					<? $this->PrintEntryContent($entry); ?>
				</a>
			</li>
			<?
		}

		?> </ul> <?
	}


	protected function PrintGroupingTitle($currItem) {
		static $last;
		$current = null;

		switch ($this->order) {
			case 1:
			case 7:
				$current = substr(
					$currItem[StaticMaps::$orderFieldPerPage[$this->pageName][$this->order]],
					0,
					1); 
				break;

			case 5:
				$current = $currItem[StaticMaps::$orderFieldPerPage[$this->pageName][$this->order]];
				$current = StaticMaps::$gender[$current];
				break;
			
			default:
				$current = $currItem[StaticMaps::$orderFieldPerPage[$this->pageName][$this->order]];
		}

		if ($current !== $last) {
			echo '<h5 class="list-group-title">' . $current . '</h5>';
			$last = $current;
		}
	}

}
