<?php

class SearchTableArtists extends SearchTable {
	public function Search() {
		$this->results = DbFunctions::QueryAssocArray(
			"SELECT
				`artists`.`id`,
				CONCAT(`artists`.`first_name`, ' ', `artists`.`last_name`) AS `full_name`,
				`artists`.`year_of_birth`,
				`artists_t`.`city_of_birth`,
				`artists_t`.`city_of_residence`,
				`cor_t`.`name` AS `country_of_residence`,
				`cob_t`.`name` AS `country_of_birth`,
				'artists' AS `table`
			FROM artists
			INNER JOIN `artists_t` ON `artists`.`id`=`artists_t`.`artist_id`
			INNER JOIN `countries` AS `cor_t` ON `artists`.`country_of_residence`=`cor_t`.`id`
			INNER JOIN `countries` AS `cob_t` ON `artists`.`country_of_birth`=`cob_t`.`id`
			WHERE 
				CONCAT(`artists`.`first_name`, ' ', `artists`.`last_name`) LIKE '%$this->query%' OR
				`artists_t`.`city_of_residence` LIKE '%$this->query%' OR
				`artists_t`.`city_of_birth` LIKE '%$this->query%' OR
				`cor_t`.`name` LIKE '%$this->query%' OR
				`cob_t`.`name` LIKE '%$this->query%'
			GROUP BY `artists`.`id`,`artists_t`.`artist_id`"
		);

		return $this->results;
	}
}