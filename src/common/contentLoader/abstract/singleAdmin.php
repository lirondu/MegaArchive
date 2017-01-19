<?

abstract class ContentLoaderSingleAdmin extends ContentLoaderSingle {

	protected function PrintSlideShow() {}
	protected function PrintSlideShowCaption() {}
	protected function PrintRelatedData() {}
	
	public function PrintContent() {
		if (count($this->entry) > 1) {
			die('<strong>No content to show...</strong>');
		} else if (count($this->entry) === 1) {
			$this->entry = $this->entry[0];
		}
		
		?>
		<div class="single-content-container">
			<div class="single-content">
				<div class="single-content-thumb">
					<? $this->PrintThumb(); ?>
				</div>
				
				<div class="single-content-data">
					<? $this->PrintData(); ?>
				</div>
			</div>
		</div>
		<?
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

}