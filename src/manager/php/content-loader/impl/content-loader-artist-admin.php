<?php

class ContentLoaderArtistAdmin extends ContentLoaderSingle {

	public function __construct() {
		parent::__construct();

		$this->entry = ($this->pageId !== 0) ? DbFunctions::QueryAssocArray(
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
				`cob_t`.`name` AS `cob`,
				`cor_t`.`name` AS `cor`,
				`cod_t`.`name` AS `cod`
			FROM artists
			INNER JOIN `artists_t` AS `artists_t_en` ON
				(`artists`.`id`=`artists_t_en`.`artist_id` AND `artists_t_en`.`lang_code`='en')
			INNER JOIN `artists_t` AS `artists_t_de` ON
				(`artists`.`id`=`artists_t_de`.`artist_id` AND `artists_t_de`.`lang_code`='de')
			INNER JOIN `artists_t` AS `artists_t_it` ON
				(`artists`.`id`=`artists_t_it`.`artist_id` AND `artists_t_it`.`lang_code`='it')
			LEFT JOIN `countries` AS `cob_t` ON `artists`.`country_of_birth`=`cob_t`.`id`
			LEFT JOIN `countries` AS `cor_t` ON `artists`.`country_of_residence`=`cor_t`.`id`
			LEFT JOIN `countries` AS `cod_t` ON 
				(`artists`.`country_of_death`!='0' AND `artists`.`country_of_death`=`cod_t`.`id`)
			WHERE `artists`.`id`='$this->id'"
		) : false;
	}
	
	protected function PrintTitle() {
		return false;
	}

	protected function PrintThumb() {
		$flag = false;
		if (! $this->entry) {
			$flag = true;
			$this->entry['main_picture'] = ''; 
		}

		?>
		<img src="<?= $this->entry['main_picture'] ?>"
			cms-inline="pic-browse"
			cms-table="artists"
			cms-id="<?= $this->id ?>"
			cms-field="main_picture">
		<?

		if ($flag) {
			$this->entry = false;
		}
	}

	protected function PrintData() {
		// if (! $this->entry) { return false; }

		$countries = DbFunctions::GetTableEntriesIdIndexed('countries');
		$countriesNames = 'Please select;';
		$countriesValues = '0;';

		foreach ($countries as $key => $value) {
			$countriesNames .= $value['name'] . ';';
			$countriesValues .= $value['id'] . ';';
		}

		$countriesNames = substr($countriesNames, 0, -1);
		$countriesValues = substr($countriesValues, 0, -1);

		$addressArr = explode(',', $this->entry['address']);
		?> 

		<form action="">
			<div>
				<label for="">First Name</label>
				<input type="text" cms-inline="text"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="first_name"
					title="First Name"
					value="<?= $this->entry['first_name'] ?>">
			</div>
		
			<div>
				<label for="">Last Name</label>
				<input type="text" cms-inline="text"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="last_name"
					title="Last Name"
					value="<?= $this->entry['last_name']; ?>">
			</div>

			<div>
				<label for="">Sex</label>
				<div cms-inline="list"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="sex"
					title="Last Name"
					cms-list-names="Please select;Female;Male"
					cms-list-values="0;1;2"
					cms-list-selected="<?= $this->entry['sex']; ?>"></div>
			</div>

			<div>
				<label>Year of Birth</label>
				<input type="text"
					cms-inline="text"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="year_of_birth"
					value="<?= $this->entry['year_of_birth'] ?>">
			</div>

			<div>
				<label>Email</label>
				<input type="text"
					cms-inline="text"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="email"
					value="<?= $this->entry['email'] ?>">
			</div>

			<div>
				<label class="textarea-label">Address</label>
				<div cms-inline="textarea"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="address"><?= $this->entry['address'] ?></div>
			</div>

			<div class="seperator"></div>

			<div>
				<label>Country of Birth</label>
				<div cms-inline="list"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="country_of_birth"
					cms-list-names="<?= $countriesNames ?>"
					cms-list-values="<?= $countriesValues ?>"
					cms-list-selected="<?= $this->entry['country_of_birth'] ?>">
				</div>
			</div>

			<fieldset>
				<legend>City of Birth</legend>
				<div>
					<label><small>(en)</small></label>
					<input type="text"
						cms-inline="text"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_en_id'] ?>"
						cms-field="city_of_birth"
						value="<?= $this->entry['city_of_birth_en'] ?>">
				</div>

				<div>
					<label><small>(de) </small><span class="label label-warning">if empty use (en)	</span></label>
					<input type="text"
						cms-inline="text"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_de_id'] ?>"
						cms-field="city_of_birth"
						value="<?= $this->entry['city_of_birth_de'] ?>">
				</div>

				<div>
					<label><small>(it) </small><span class="label label-warning">if empty use (en)	</span></label>
					<input type="text"
						cms-inline="text"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_it_id'] ?>"
						cms-field="city_of_birth"
						value="<?= $this->entry['city_of_birth_it'] ?>">
				</div>
			</fieldset>

			<div class="seperator"></div>

			<div>
				<label>Country of Residence</label>
				<div cms-inline="list"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="country_of_residence"
					cms-list-names="<?= $countriesNames ?>"
					cms-list-values="<?= $countriesValues ?>"
					cms-list-selected="<?= $this->entry['country_of_residence'] ?>">
				</div>
			</div>

			<fieldset>
				<legend>City of Residence</legend>
				<div>
					<label><small>(en)</small></label>
					<input type="text"
						cms-inline="text"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_en_id'] ?>"
						cms-field="city_of_residence"
						value="<?= $this->entry['city_of_residence_en'] ?>">
				</div>

				<div>
					<label><small>(de) </small><span class="label label-warning">if empty use (en)	</span></label>
					<input type="text"
						cms-inline="text"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_de_id'] ?>"
						cms-field="city_of_residence"
						value="<?= $this->entry['city_of_residence_de'] ?>">
				</div>

				<div>
					<label><small>(it) </small><span class="label label-warning">if empty use (en)	</span></label>
					<input type="text"
						cms-inline="text"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_it_id'] ?>"
						cms-field="city_of_residence"
						value="<?= $this->entry['city_of_residence_it'] ?>">
				</div>
			</fieldset>

			<div class="seperator"></div>

			<div>
				<label>Country of Death</label>
				<div cms-inline="list"
					cms-table="artists"
					cms-id="<?= $this->id ?>"
					cms-field="country_of_death"
					cms-list-names="<?= $countriesNames ?>"
					cms-list-values="<?= $countriesValues ?>"
					cms-list-selected="<?= $this->entry['country_of_death'] ?>">
				</div>
			</div>

			<div class="seperator"></div>

			<fieldset class="fieldset-big">
				<legend>Biography</legend>
				<div>
					<label class="textarea-big-label"><small>(en)</small></label>
					<div cms-inline="editor"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_en_id'] ?>"
						cms-field="biography"><?= $this->entry['bio_en'] ?></div>
				</div>

				<div>
					<label class="textarea-big-label"><small>(de) </small><span class="label label-warning">if empty use (en)</span></label>
					<div cms-inline="editor"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_de_id'] ?>"
						cms-field="biography"><?= $this->entry['bio_de'] ?></div>
				</div>

				<div>
					<label class="textarea-big-label"><small>(it) </small><span class="label label-warning">if empty use (en)</span></label>
					<div cms-inline="editor"
						cms-table="artists_t"
						cms-id="<?= $this->entry['city_it_id'] ?>"
						cms-field="biography"><?= $this->entry['bio_it'] ?></div>
				</div>
			</fieldset>
		</form>
		<?
	}

	
	protected function PrintRelatedTitle() {
		return false;
	}


	protected function PrintRelatedContent() {
		return false;
	}

}