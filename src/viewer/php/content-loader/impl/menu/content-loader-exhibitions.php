<?php

class ContentLoaderExhibitions extends ContentLoaderMenuPage {

	public function Query() {
		$this->pageEntries = DbFunctions::QueryAssocArray(
			"SELECT 
				`exhibitions`.*,
				`countries`.`name` AS `country_name`,
				`collections`.`name` AS `collection_name`
			FROM exhibitions
			INNER JOIN `countries` ON `exhibitions`.`country`=`countries`.`id`
			INNER JOIN `collections` ON `exhibitions`.`collection`=`collections`.`id`
			WHERE `exhibitions`.`id` IN ($this->idsToQuery)
			GROUP BY `exhibitions`.`id`
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
				<?= $entry['name'] . ', ' . $entry['year'] ?>
			</li>
			<li>
				<?= $entry['city'] . ', ' . $entry['country_name'] ?>
			</li>
		</ul>
		<?
	}
}