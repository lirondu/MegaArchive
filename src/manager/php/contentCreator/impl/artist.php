<?

class ContentCreatorArtist extends ContentCreator {

	protected function AddNewEntry() {
		$artists_id = DbFunctions::CreateEntry('artists', ['first_name'], ['']);

		DbFunctions::CreateEntry(
			'artists_biography_t',
			['artist_id', 'lang_code'],
			[$artists_id, 'en']);

		DbFunctions::CreateEntry(
			'artists_biography_t',
			['artist_id', 'lang_code'],
			[$artists_id, 'de']);

		DbFunctions::CreateEntry(
			'artists_biography_t',
			['artist_id', 'lang_code'],
			[$artists_id, 'it']);

		DbFunctions::CreateEntry(
			'artists_t',
			['artist_id', 'lang_code'],
			[$artists_id, 'en']);

		DbFunctions::CreateEntry(
			'artists_t',
			['artist_id', 'lang_code'],
			[$artists_id, 'de']);

		DbFunctions::CreateEntry(
			'artists_t',
			['artist_id', 'lang_code'],
			[$artists_id, 'it']);
			
	}
}
