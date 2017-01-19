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
				`artists`.`id`=`artists_t`.`artist_id` AND `artists_t`.`lang_code`='$this->lang'
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

	protected function PrintSlideShow() {
		echo $this->entry['main_picture'];
	}

	protected function PrintSlideShowCaption() {
		?>
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

		<p class="line-margin">
			<?= StaticMaps::$artistsInfoPerLang[$this->lang][5] ?>:
			<?= $this->entry['main_picture_photographer'] ?>
		</p>

		<p>
			<?= StaticMaps::$artistsInfoPerLang[$this->lang][6] ?>:
			<?= $this->entry['main_picture_source'] ?>
		</p>
		<?
	}

	protected function PrintArticleHeader() {
		$bioWriter = '';
		if ($this->entry['bio_writer_id'] === '0') {
			$bioWriter = $this->entry['bio_writer_name'];
		} else {
			$contributer = DbFunctions::GetTableEntryById('contributors', $this->entry['bio_writer_id'])[0];
			$bioWriter = $contributer['first_name'] . ' ' . $contributer['last_name'];
		}
		?> 
			<p>
				<?= StaticMaps::$artistsInfoPerLang[$this->lang][7] ?>:
				<?= $bioWriter ?>
			</p>

			<p>
				<?= StaticMaps::$artistsInfoPerLang[$this->lang][6] ?>:
				<?= $this->entry['bio_source'] ?>
			</p>
		<?
	}

	protected function PrintArticle() {
		echo $this->entry['biography'];
	}

	protected function PrintRelatedData() {
		// artworks
		$_GET['filters'] = "`artist_id`='" . $this->id . "'";
		$_GET['grouping'] = 'false';
		$_GET['view'] = '2';
		$_GET['page'] = '2';
		$_GET['order'] = StaticMaps::$pagesSubMenus['artworks'][0];

		$artworksLoader = new ContentLoaderArtworks();
		$this->PrintRelatedDataSection(1, 'Artworks', $artworksLoader);
		

		// exhibitions
		$idsToQuery = DbFunctions::QueryAssocArray(
			"SELECT `exhibitions` FROM `artists_exhibitions_r` WHERE `artist_id`='" . $this->id . "'"
		);

		$idsToQuery = (count($idsToQuery) > 0) ? $idsToQuery[0]['exhibitions'] : '0';

		$_GET['filters'] = "`exhibitions`.`id` IN (" . $idsToQuery . ")";
		$_GET['grouping'] = 'false';
		$_GET['view'] = '2';
		$_GET['page'] = '4';
		$_GET['order'] = StaticMaps::$pagesSubMenus['exhibitions'][0];

		$exhibitionsLoader = new ContentLoaderExhibitions();
		$this->PrintRelatedDataSection(2, 'Exhibitions', $exhibitionsLoader);


		//  publications
		$idsToQuery = DbFunctions::QueryAssocArray(
			"SELECT `publications` FROM `artists_publications_r` WHERE `artist_id`='" . $this->id . "'"
		);

		$idsToQuery = (count($idsToQuery) > 0) ? $idsToQuery[0]['publications'] : '0';

		$_GET['filters'] = "`publications`.`id` IN (" . $idsToQuery . ")";
		$_GET['grouping'] = 'false';
		$_GET['view'] = '2';
		$_GET['page'] = '6';
		$_GET['order'] = StaticMaps::$pagesSubMenus['publications'][0];

		$publicationsLoader = new ContentLoaderPublications();
		$this->PrintRelatedDataSection(3, 'Publications', $publicationsLoader);


		// contact
		global $isAdmin;
		// if (!$isAdmin) { return; }

		$contactContent = '
		<div class="related-data-section-content">
			<div class="contact-column">
				<h3>studio</h3>'
				. $this->entry['address'] .
			'</div>
			<div class="contact-column">
				<h3>webpage</h3>'
				. $this->entry['website'] .
			'</div>
			<div class="contact-column">
				<h3>email</h3>'
				. $this->entry['email'] .
			'</div>
		</div>
		';

		$this->PrintRelatedDataSection(4, 'Contact', $contactContent);
		
	}

}