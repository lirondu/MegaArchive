<?php

class ContentLoaderArtwork extends ContentLoaderSingle {

	public function __construct() {
		parent::__construct();

		$this->entry = DbFunctions::QueryAssocArray(
			"SELECT 
				`artworks`.*,
				`artworks_t`.`title`,
				`artworks_t`.`caption`,
				CONCAT(`artists`.`first_name`, ' ', `artists`.`last_name`) AS `artist_name`,
				`artworks_media`.`name` as `medium_name`,
				`galleries`.`name` as `gallery_name`,
				`collections`.`name` as `collection_name`,
				`locations`.`name` as `location_name`,
				`artworks_size_classes`.`name` as `size_name`
			FROM artworks
			INNER JOIN `artworks_t` ON
				(`artworks`.`id`=`artworks_t`.`artwork_id` AND `artworks_t`.`lang_code`='$this->lang')
			INNER JOIN `artists` ON `artworks`.`artist_id`=`artists`.`id`
			INNER JOIN `artworks_media` ON `artworks`.`medium`=`artworks_media`.`id`
			INNER JOIN `galleries` ON `artworks`.`gallery_id`=`galleries`.`id`
			INNER JOIN `collections` ON `artworks`.`collection_id`=`collections`.`id`
			INNER JOIN `locations` ON `artworks`.`location_id`=`locations`.`id`
			LEFT JOIN `artworks_size_classes` ON
				`artworks`.`size_class`=`artworks_size_classes`.`id`
			WHERE `artworks`.`id`='$this->id'"
		);
	}
	
	protected function PrintTitle() {
		echo $this->entry['artist_name'] . ', ' . $this->entry['year_start'];
	}

	protected function PrintThumb() {
		echo $this->entry['thumb'];
	}

	protected function PrintData() {
		?> 
		<ul class="single-content-list">
			<li>
				<?= $this->entry['artist_name'] . ', ' . $this->entry['year_start'] ?>
			</li>

			<li>
				<p>Medium:</p>
				<p><?= $this->entry['medium_name'] ?></p>
			</li>

			<li>
				<p>Caption:</p>
				<p><?= $this->entry['caption'] ?></p>
			</li>

			<li>
				<p>Dimensions:</p>
				<p><?= $this->entry['dimensions'] ?></p>
			</li>

			<li>
				<p>Edition:</p>
				<p><?= $this->entry['edition'] ?></p>
			</li>

			<li>
				<p>Collection:</p>
				<p><?= $this->entry['collection_name'] ?></p>
			</li>

			<li>
				<p>Location:</p>
				<p><?= $this->entry['location_name'] ?></p>
			</li>
		</ul>
		<?
	}

	
	protected function PrintRelatedTitle() {
		echo 'Other artworks by ' . $this->entry['artist_name'];
	}


	protected function PrintRelatedContent() {
		$_GET['filters'] = "`artist_id`='" . $this->entry['artist_id'] .
			"' AND `artworks`.`id`!='" . $this->id . "'";
		$_GET['grouping'] = 'false';
		$_GET['view'] = '2';
		$_GET['page'] = '2';
		$_GET['order'] = StaticMaps::$pagesSubMenus['artworks'][0];
		
		$artworksLoader = new ContentLoaderArtworks();
		$this->relatedEntries = $artworksLoader->PrintContent();
	}

}