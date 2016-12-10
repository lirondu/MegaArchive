<?php

class ContentLoaderPublications extends ContentLoaderMenu {

	public function Query() {
		$this->pageEntries = DbFunctions::QueryAssocArray(
			"SELECT 
				`publications`.*,
				`countries`.`name` AS `country_name`,
				`collections`.`name` AS `collection_name`
			FROM publications
			INNER JOIN `countries` ON `publications`.`country`=`countries`.`id`
			LEFT JOIN `collections` ON `publications`.`collection`=`collections`.`id`
			WHERE `publications`.`id` IN ($this->idsToQuery)
			GROUP BY `publications`.`id`
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
				<?= $entry['title'] ?>
			</li>
			<li>
				<?= $entry['city'] . ', ' . $entry['country_name'] ?>
			</li>
		</ul>
		<?
	}
}