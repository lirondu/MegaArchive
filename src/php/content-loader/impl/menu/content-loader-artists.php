<?php

class ContentLoaderArtists extends ContentLoaderMenuPage {

	public function Query() {		
		return $this->pageEntries = DbFunctions::QueryAssocArray(
			"SELECT 
				`artists`.*,
				`artists_t`.`city_of_birth`,
				`artists_t`.`city_of_residence`,
				`artists_t`.`city_of_death`,
				`artists_t`.`biography`,
				`cob_t`.`name` AS `cob`,
				`cor_t`.`name` AS `cor`,
				`cod_t`.`name` AS `cod`
			FROM artists
			INNER JOIN `artists_t` ON
				(`artists`.`id`=`artists_t`.`artist_id` AND `artists_t`.`lang_code`='$this->lang')
			INNER JOIN `countries` AS `cob_t` ON `artists`.`country_of_birth`=`cob_t`.`id`
			INNER JOIN `countries` AS `cor_t` ON `artists`.`country_of_residence`=`cor_t`.`id`
			LEFT JOIN `countries` AS `cod_t` ON 
				(`artists`.`country_of_death`!='0' AND `artists`.`country_of_death`=`cod_t`.`id`)
			WHERE 
				`artists`.`id` IN ($this->idsToQuery)
				$this->filters
			GROUP BY `artists`.`id`
			ORDER BY `$this->orderField`"
		);
	}
	

	protected function PrintEntryContent($entry) {
		if ($entry['main_picture'] !== '') {
			?> <img src="<?= $entry['main_picture'] ?>"> <?
		} else {
			?> <p class="thumb-missing">Missing main picture</p> <?
		}
		
		?>
		<ul class="entry-info">
			<li class="bold"><?= $entry['first_name'] . ' ' . $entry['last_name'] ?></li>
			<li>
				<?= StaticMaps::$artistsInfoPerLang[$this->lang][0] ?>
				<?= $entry['year_of_birth'] ?> 
				<?= StaticMaps::$artistsInfoPerLang[$this->lang][1] ?>
				<?= $entry['city_of_birth'] ?>,
				<?= $entry['cob'] ?>
			</li>
			<li>
				<?
				if ($entry['year_of_death'] === '0') {
				?>
					<?= StaticMaps::$artistsInfoPerLang[$this->lang][2] ?>
					<?= $entry['city_of_residence'] ?>,
					<?= $entry['cor'] ?>
				<?
				} else { ?>
					<?= StaticMaps::$artistsInfoPerLang[$this->lang][3] ?>
					<?= $entry['year_of_death'] ?>
					<?= StaticMaps::$artistsInfoPerLang[$this->lang][4] ?>				
					<?= $entry['city_of_death'] ?>,
					<?= $entry['cod'] ?>
				<?
				}
				?>
			</li>
		</ul>
		<?
	}

}