<?php

class Permissions {
	public static $validCollections;

	public static function ValidateCollectionId ($id) {
		return (in_array($id, self::$validCollections));
	}

	public static function ValidateCollectionsList($list) {
		$valid = true;
		$collArr = explode(',', $list);

		foreach ($collArr as $collection) {
			$valid &= (in_array($collection, self::$validCollections));

			if (!$valid) { return $valid; }
		}

		return $valid;
	}
}

Permissions::$validCollections = [1, 2, 3];