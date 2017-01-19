<?php


abstract class ContentLoaderSingle extends ContentLoader {
	protected $id;
	protected $entry;
	protected $relatedEntries;
	
	abstract protected function PrintTitle();
	abstract protected function PrintSlideShow();
	abstract protected function PrintSlideShowCaption();
	abstract protected function PrintArticleHeader();
	abstract protected function PrintArticle();
	abstract protected function PrintRelatedData();
	
	

	public function __construct() {
		parent::__construct();

		if (!isset($_GET['id'])) {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}

		$this->id = $_GET['id'];
	}



	protected function PrintRelatedDataSection($num, $title, $content) {
		?>
		<div class="related-data-section panel">
			<div role="tab" id="heading<?=$num?>">
				<h3 class="related-data-header">
					<a role="button" data-toggle="collapse" data-parent="#single_view_accordion" href="#collapse<?=$num?>" 	aria-expanded="true" aria-controls="collapse<?=$num?>">
						<?= $title ?>
					</a>
				</h3>
			</div>

			<div class="related-data-section-content panel-collapse collapse" id="collapse<?=$num?>" role="tabpanel" aria-labelledby="heading<?=$num?>">
				<? 
					if (gettype($content) === 'string') {
						echo $content;
					} else {
						$content->PrintContent();
					}
				?>
			</div>
		</div>
		<?
	}



	public function PrintContent() {
		if (count($this->entry) !== 1) {
			die('<strong>No content to show...</strong>');
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
				<div class="single-content-slideshow-container">
					<div class="single-content-slideshow">
						<img src="<? $this->PrintSlideShow(); ?>">
						<div class="slideshow-caption">
							<? $this->PrintSlideShowCaption(); ?>
						</div>
					</div>
				</div>
				
				<div class="single-content-data">
					<div class="single-content-text">
						<? $this->PrintArticleHeader(); ?>
						<p class="single-content-main-article"><? $this->PrintArticle(); ?></p>
						<p class="single-content-readmore"></p>
						<a href="javascript:void(0)" class="single-content-readmore-link" is-open="false">read more...</a>
					</div
				</div>
			</div>

			<div class="single-content-related panel-group" id="single_view_accordion" role="tablist" aria-multiselectable="true">
				<? $this->PrintRelatedData(); ?>
			</div>
		</div>
		<?
	}
	
}