<?php

class ContentLoaderArtworks extends ContentLoaderMenu {

	public function Query() {
		return $this->pageEntries = DbFunctions::QueryAssocArray(
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
			WHERE 
				`artworks`.`id` IN ($this->idsToQuery)
				$this->filters
			GROUP BY `artworks`.`id`
			ORDER BY `$this->orderField`"
		);
	}


	protected function PrintEntryContent($entry) {
		// $artist = $this->artworksList[$entry['artist_id']];

		if ($entry['thumb'] !== '') {
			?> <img src="<?= $entry['thumb'] ?>"> <?
		} else {
			?> <p class="thumb-missing">Missing main picture</p> <?
		}

		?>
		<ul class="entry-info">
			<li class="bold">
				<?
				echo $entry['title'] . ', ' . $entry['year_start'];
				echo ($entry['year_end'] !== '0') ? '-' . $entry['year_end'] : ''; 
				?>
			</li>
			<li>
				<? echo 'By ' . $entry['artist_name']; ?>
			</li>
		</ul>
		<?
	}
}