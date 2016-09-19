<?php

class SearchTableArtworks extends SearchTable {
	public function Search() {
		$this->results = DbFunctions::QueryAssocArray(
			"SELECT
				`artworks`.`id`,
				`artworks`.`location_id`,
				`artworks_t`.`title`,
				`artists`.`first_name`,
				`artists`.`last_name`,
				`locations`.`name` AS `location`,
				'artworks' AS `table`
			FROM artworks
			INNER JOIN `artworks_t` ON `artworks`.`id`=`artworks_t`.`artwork_id`
			INNER JOIN `artists` ON `artworks`.`artist_id`=`artists`.`id`
			INNER JOIN `locations` ON `artworks`.`location_id` = `locations`.`id`
			WHERE 
				`artworks_t`.`title` LIKE '%$this->query%' OR
				`locations`.`name` LIKE '%$this->query%'
			GROUP BY `artworks`.`id`,`artworks_t`.`artwork_id`"
		);

		return $this->results;
	}
}