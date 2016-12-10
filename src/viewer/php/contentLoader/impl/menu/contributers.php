<?php

class ContentLoaderContributers extends ContentLoaderMenu {

	public function Query() {
		return $this->pageEntries = DbFunctions::QueryAssocArray(
			"SELECT 
				`contributors`.*,
				`cob_t`.`name` AS `cob`,
				`cor_t`.`name` AS `cor`
			FROM contributors
			INNER JOIN `countries` AS `cob_t` ON `contributors`.`country_of_birth`=`cob_t`.`id`
			INNER JOIN `countries` AS `cor_t` ON `contributors`.`country_of_residence`=`cor_t`.`id`
			WHERE `contributors`.`id` IN ($this->idsToQuery)
			GROUP BY `contributors`.`id`
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
				<?= $entry['first_name'] . ' ' . $entry['last_name'] ?>
			</li>
			<li>
				<?= $entry['type'] ?>
			</li>
		</ul>
		<?
	}
}