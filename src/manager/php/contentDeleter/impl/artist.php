<?

class ContentDeleterArtist extends ContentDeleter {
	
	protected function DeleteEntry() {
		$artists_biography_t = DbFunctions::QueryAssocArray(
			"SELECT id FROM `artists_biography_t` WHERE `artist_id`='$this->id'"
		);

		foreach ($artists_biography_t as $entry) {
			DbFunctions::DeleteEntry('artists_biography_t', $entry['id']);
		}


		$artists_t = DbFunctions::QueryAssocArray(
			"SELECT id FROM `artists_t` WHERE `artist_id`='$this->id'"
		);

		foreach ($artists_t as $entry) {
			DbFunctions::DeleteEntry('artists_t', $entry['id']);
		}


		DbFunctions::RemoveRelation('artists', $this->id);

		DbFunctions::DeleteEntry($this->table, $this->id);
	}

}