<?php


class ContentLoaderFactory {
	public static function Create() {
		global $isAdmin;
		
		if (!isset($_GET['page'])) {
			die('<strong>HTTP request is missing params!!</strong>');
			return false;
		}

		if (! array_key_exists($_GET['page'], StaticMaps::$pages)) {
			die('<strong>Wrong parameters!! Don\'t modify the URL manually!!</strong>');
		}

		if ($isAdmin) {
			return new StaticMaps::$pages[$_GET['page']]['admin_content_loader'];
		} else {
			return new StaticMaps::$pages[$_GET['page']]['content_loader'];
		}
		
	} 
}