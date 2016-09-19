<?php

class ContentLoaderArtist extends ContentLoaderSingle {

	public function __construct() {
		parent::__construct();

		$this->entry = DbFunctions::QueryAssocArray(
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
			WHERE `artists`.`id`='$this->id'"
		);
	}
	
	protected function PrintTitle() {
		echo $this->entry['first_name'] . ' ' . $this->entry['last_name'];
	}

	protected function PrintThumb() {
		echo $this->entry['main_picture'];
	}

	protected function PrintData() {
		$addressArr = explode(',', $this->entry['address']);
		?> 
		<ul class="single-content-list">
			<li>
				<p>
					<?= StaticMaps::$artistsInfoPerLang[$this->lang][0] ?>
					<?= $this->entry['year_of_birth'] ?> 
					<?= StaticMaps::$artistsInfoPerLang[$this->lang][1] ?>
					<?= $this->entry['city_of_birth'] ?>,
					<?= $this->entry['cob'] ?>
				</p>

				<p>
					<?= StaticMaps::$artistsInfoPerLang[$this->lang][2] ?>
					<?= $this->entry['city_of_residence'] ?>,
					<?= $this->entry['cor'] ?>
				</p>
			</li>

			<li>
				<?
				foreach ($addressArr as $value) {
					?>
					<p>
						<?= $value ?>
					</p>
					<?
				}
				?>
			</li>

			<li>
				<p>email:</p>
				<p>
					<a href="mailto:<?= $this->entry['email'] ?>" target="_blank">
						<?= $this->entry['email'] ?>
					</a>
				</p>
			</li>

			<li>
				<p><?= $this->entry['biography'] ?></p>
			</li>
		</ul> <?
	}

	
	protected function PrintRelatedTitle() {
		echo 'Artworks by ' . $this->entry['first_name'] . ' ' . $this->entry['last_name'];
	}


	protected function PrintRelatedContent() {
		$_GET['filters'] = "`artist_id`='" . $this->id . "'";
		$_GET['grouping'] = 'false';
		$_GET['view'] = '2';
		$_GET['page'] = '2';
		$_GET['order'] = StaticMaps::$pagesSubMenus['artworks'][0];
		
		$artworksLoader = new ContentLoaderArtworks();
		$this->relatedEntries = $artworksLoader->PrintContent();
	}

}