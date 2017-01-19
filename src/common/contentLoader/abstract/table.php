<?php


abstract class ContentLoaderTable extends ContentLoader {
	protected $tableEntries;
	protected $tableEmptyEntries;
	protected $order;
	protected $orderString;

	abstract protected function PrintTableContent();
	abstract protected function PrintEmptyTableContent();
	abstract protected function PrintAddButton();


	public function __construct() {
		parent::__construct();

		if (!isset($_GET['order']))	{
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}

		$this->order = $_GET['order'];
	}

	public function PrintContent() {
		?>
		<h3 class="manage-table-title">Empty <?= $this->pageName ?></h3>
		<table class="manage-table table table-hover">
			<?
			if (count($this->tableEmptyEntries) > 0) {
				$this->PrintEmptyTableContent();
			} else {
				echo '<tr><td style="padding: 5px;">No empty entries</td></tr>';
			}
			?>
		</table>
		
		<div class="manage-new-container">
			<? $this->PrintAddButton(); ?>
		</div>
		
		<h3 class="manage-table-title"><?= $this->pageName ?></h3>
		<table class="manage-table table table-hover">
			<? $this->PrintTableContent(); ?>
		</table>
		<div class="manage-table-counter">Count: <?= count($this->tableEntries) ?></div>

		<link rel="stylesheet" href="css/manage-table.css">
		<script src="js/contentCreator.js"></script>
		<?
	}

}