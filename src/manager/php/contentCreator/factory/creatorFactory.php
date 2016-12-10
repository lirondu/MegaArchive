<?

class ContentCreatorFactory {
	
	public static function Create() {
		if (! array_key_exists($_POST['table'], StaticMaps::$contentCreatorsMap)) {
			die('0');
		}

		return new StaticMaps::$contentCreatorsMap[$_POST['table']];
	}
	
}