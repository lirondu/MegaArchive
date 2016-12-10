<?php

class ContentLoaderGalleries extends ContentLoaderMenu {

	public function Query() {
		$this->pageEntries = DbFunctions::QueryAssocArray(
			"SELECT 
				`galleries`.*,
				`countries`.`name` AS `country_name`
			FROM galleries
			INNER JOIN `countries` ON `galleries`.`country`=`countries`.`id`
			WHERE `galleries`.`id` IN ($this->idsToQuery)
			GROUP BY `galleries`.`id`
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
				<?= $entry['name']; ?>
			</li>
			<li>
				<?= $entry['city'] . ', ' . $entry['country_name'] ?>
			</li>
		</ul>
		<?
	}
}