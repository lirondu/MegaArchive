<?

abstract class ContentLoaderSingleAdmin extends ContentLoaderSingle {
	
	public function PrintContent() {
		if (count($this->entry) > 1) {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
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

}