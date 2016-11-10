<?php

class ContentLoaderArtistTable extends ContentLoaderTable {

	public function __construct() {
		parent::__construct();

		$this->orderString = 'ORDER BY ';
		switch ($this->order) {
			case '1':
				$this->orderString .= '`artists`.`first_name`'; 
				break;

			case '2':
				$this->orderString .= '`artists`.`last_name`'; 
				break;

			case '3':
				$this->orderString .= '`artists`.`id` DESC'; 
				break;
		}


		$this->tableEntries = DbFunctions::QueryAssocArray(
			"SELECT 
				`artists`.*,
				`artists_t_en`.`city_of_birth` AS `city_of_birth_en`,
				`artists_t_de`.`city_of_birth` AS `city_of_birth_de`,
				`artists_t_it`.`city_of_birth` AS `city_of_birth_it`,
				`artists_t_en`.`city_of_residence` AS `city_of_residence_en`,
				`artists_t_de`.`city_of_residence` AS `city_of_residence_de`,
				`artists_t_it`.`city_of_residence` AS `city_of_residence_it`,
				`artists_t_en`.`biography` AS `bio_en`,
				`artists_t_de`.`biography` AS `bio_de`,
				`artists_t_it`.`biography` AS `bio_it`,
				`artists_t_en`.`id` AS `city_en_id`,
				`artists_t_de`.`id` AS `city_de_id`,
				`artists_t_it`.`id` AS `city_it_id`,
				`artists_t`.`city_of_residence`,
				`artists_t`.`city_of_death`,
				`cob_t`.`name` AS `cob`,
				`cor_t`.`name` AS `cor`,
				`cod_t`.`name` AS `cod`
			FROM artists
			INNER JOIN `artists_t` ON
				(`artists`.`id`=`artists_t`.`artist_id` AND `artists_t`.`lang_code`='en')
			INNER JOIN `artists_t` AS `artists_t_en` ON
				(`artists`.`id`=`artists_t_en`.`artist_id` AND `artists_t_en`.`lang_code`='en')
			INNER JOIN `artists_t` AS `artists_t_de` ON
				(`artists`.`id`=`artists_t_de`.`artist_id` AND `artists_t_de`.`lang_code`='de')
			INNER JOIN `artists_t` AS `artists_t_it` ON
				(`artists`.`id`=`artists_t_it`.`artist_id` AND `artists_t_it`.`lang_code`='it')
			INNER JOIN `countries` AS `cob_t` ON `artists`.`country_of_birth`=`cob_t`.`id`
			INNER JOIN `countries` AS `cor_t` ON `artists`.`country_of_residence`=`cor_t`.`id`
			LEFT JOIN `countries` AS `cod_t` ON 
				(`artists`.`country_of_death`!='0' AND `artists`.`country_of_death`=`cod_t`.`id`)
			$this->orderString"
		);


		$this->tableEmptyEntries = DbFunctions::QueryAssocArray(
			"SELECT * FROM `artists`
			WHERE `artists`.`first_name`='' OR `artists`.`last_name`=''"
		);
	}


	public function PrintAddButton() {
		?>
		<button class="manage-new-btn btn btn-primary" table="artists">Add New</button>
		<?
	}


	protected function PrintEmptyTableContent() {
		?>
		<thead>
			<tr>
				<th class="col-xs-1 text-center">#</th>
				<th class="col-xs-4"></th>
			</tr>
		</thead>

		<tbody>
		<?
		$counter = 1;
		foreach ($this->tableEmptyEntries as $entry) {
			?>
			<tr>
				<td class="text-center"><?= $counter ?></td>
				<td class="text-center">
					<a class="content-loader-link btn btn-xs btn-warning" href="javascript:void(0)"
						page="8"
						entry-id="<?= $entry['id'] ?>">
						Edit
					</a>
				</td>
			</tr>
			<?

			$counter++;
		}
		?>
		</tbody>
		<?
	}
	
	
	protected function PrintTableContent() {
		?>
		<div class="manage-table-sort">
			<span>Sort by:</span> 
			
			<a href="/manager/#page=15" <?= ($this->order === '1') ? 'class="active"' : '' ?>>
				First Name
			</a>
			<a href="/manager/#page=15&order=2" <?= ($this->order === '2') ? 'class="active"' : '' ?>>
				Last Name
			</a>
			<a href="/manager/#page=15&order=3" <?= ($this->order === '3') ? 'class="active"' : '' ?>>
				ID
			</a>
		</div>

		<thead>
			<tr>
				<th class="col-xs-1 text-center">ID</th>
				<th class="col-xs-5">Name</th>
				<th class="col-xs-2 text-center">Published</th>
			</tr>
		</thead>

		<tbody>
		<?

		$counter = 1;
		foreach ($this->tableEntries as $entry) {
			?>
			<tr>
				<td class="text-center"><?= $entry['id'] ?></td>
				<td>
					<a class="content-loader-link" href="javascript:void(0)"
						page="8"
						entry-id="<?= $entry['id'] ?>">
						<?= $entry['first_name'] . ' ' . $entry['last_name'] ?>
					</a>
				</td>
				<td class="text-center"><input type="checkbox" checked></td>
			</tr>
			<?

			$counter++;
		}

		?>
		</tbody>
		<?
	}

}