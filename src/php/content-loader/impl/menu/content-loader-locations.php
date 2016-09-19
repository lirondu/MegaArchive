<?php

class ContentLoaderLocations extends ContentLoaderMenuPage {

	public function Query() {
		$this->pageEntries = DbFunctions::QueryAssocArray(
			"SELECT 
				`locations`.*,
				`countries`.`name` AS `country_name`,
				`collections`.`name` AS `collection_name`
			FROM locations
			INNER JOIN `countries` ON `locations`.`country`=`countries`.`id`
			LEFT JOIN `collections` ON `locations`.`collection`=`collections`.`id`
			WHERE `locations`.`id` IN ($this->idsToQuery)
			GROUP BY `locations`.`id`
			ORDER BY `$this->orderField`"
		);
	}


	protected function PrintEntryContent($entry) {
		if ($entry['thumb'] !== '') {
			?> <img src="<?= $entry['thumb'] ?>"> <?
		} else {
			?> <p class="thumb-missing">Missing main picture</p> <?
		}

		?>
		<ul class="entry-info">
			<li class="bold">
				<?= $entry['name'] ?>
			</li>
			<li>
				<?= $entry['city'] . ', ' . $entry['country_name'] ?>
			</li>
		</ul>
		<?
	}
}