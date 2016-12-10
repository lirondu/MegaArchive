<?php


abstract class ContentLoaderSingle extends ContentLoader {
	protected $id;
	protected $entry;
	protected $relatedEntries;
	
	abstract protected function PrintTitle();
	abstract protected function PrintThumb();
	abstract protected function PrintData();
	abstract protected function PrintRelatedTitle();
	abstract protected function PrintRelatedContent();


	public function __construct() {
		parent::__construct();

		if (!isset($_GET['id'])) {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}

		$this->id = $_GET['id'];
	}


	protected function PrintCmsInlineElement($elId, $cmsType, 
											$cmsTable, $cmsId, 
											$cmsField, $value = '',
											$listNames = '', $listValues = '', $listSelected = '') {
		switch ($cmsType) {
			case 'text':
				?>
				<input id="<?= $elId ?>" type="text"
					cms-inline="text"
					cms-table="<?= $cmsTable ?>"
					cms-id="<?= $cmsId ?>"
					cms-field="<?= $cmsField ?>"
					value="<?= $value ?>">
				<?
				break;
			
			case 'list':
				?>
				<div id="<?= $elId ?>"
					cms-inline="list"
					cms-table="<?= $cmsTable ?>"
					cms-id="<?= $cmsId ?>"
					cms-field="<?= $cmsField ?>"
					cms-list-names="<?= $listNames ?>"
					cms-list-values="<?= $listValues ?>"
					cms-list-selected="<?= $listSelected ?>"></div>
				<?
				break;
		}
	}



	public function PrintContent() {
		if (count($this->entry) !== 1) {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		} else {
			$this->entry = $this->entry[0];
		}
		
		?>
		<div class="single-content-container">
			<div class="single-content-header-container">
				<h1 class="single-content-header">
					<? $this->PrintTitle(); ?>
				</h1>
			</div>
			
			<div class="single-content">
				<div class="single-content-thumb">
					<img src="<? $this->PrintThumb(); ?>">
				</div>
				
				<div class="single-content-data">
					<? $this->PrintData(); ?>
				</div>
			</div>

			<div class="artworks-by">
				<div>
					<h1><? $this->PrintRelatedTitle(); ?></h1>
				</div>
				<? $this->PrintRelatedContent(); ?>
			</div>
		</div>
		<?
	}
	
}