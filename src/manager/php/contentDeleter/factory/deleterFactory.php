<?

class ContentDeleterFactory {
	
	public static function Create() {
		if (! array_key_exists($_POST['table'], StaticMaps::$contentDeletersMap)) {
			die('0');
		}

		return new StaticMaps::$contentDeletersMap[$_POST['table']];
	}
	
}