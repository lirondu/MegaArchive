<?php

class DbFunctions {
	private static $dbWorker = null;


	public static function Init() {
		if (self::$dbWorker === null) {
			self::$dbWorker = new mysqli('127.0.0.1', 'root', '', 'oberrauch_collection');

			if (self::$dbWorker->connect_errno) {
				die('Database: DB connection failed!!');
			}

			if (!self::$dbWorker->set_charset("utf8")) {
				die("Database: Error loading character set utf8!!");
			}
		}
	}



	public static function PrintLastError() {
		echo self::$dbWorker->error;
	}


	public static function Query($queryStr) {
		$result = self::$dbWorker->query($queryStr);
		
		if ($result) {
			return self::$dbWorker->insert_id;
		} else {
			throw new Exception();
		}
	}


	public static function QueryAssocArray($queryStr) {
		$result = self::$dbWorker->query($queryStr);
		$resultArr = [];
		
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$resultArr[] = $row;
			}
			return $resultArr;
		} else {
			die('DbFunctions: QueryAssocArray failed!! Check query string:  ' . $queryStr);
		}
	}


	public static function QueryIdIndexedArray($queryStr) {
		$retTable = [];

		$result = self::$dbWorker->query($queryStr);
		
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$retTable[$row['id']] = $row;
			}			
			return $retTable;
		} else {
			die('DbFunctions: QueryIdIndexedArray failed!! Check query string:  ' . $queryStr);
		}
	}



	public static function GetTableEntries($tableName, $published=null, $orderBy = null){
		$pub		 = ($published) ? 'WHERE published=1' : '';
		$order		 = ($orderBy) ? 'ORDER BY ' . $orderBy : '';

		return self::QueryAssocArray("SELECT * FROM `$tableName` $pub $order");
	}


	public static function GetTableEntriesIdIndexed($tableName, $published=null, $orderBy = null){
		$pub		 = ($published) ? 'WHERE published=1' : '';
		$order		 = ($orderBy) ? 'ORDER BY ' . $orderBy : '';

		return self::QueryIdIndexedArray("SELECT * FROM `$tableName` $pub $order");
	}


	public static function GetTableEntryById($tableName, $id){
		return self::QueryAssocArray("SELECT * FROM `$tableName` WHERE id='$id'");
	}


	public static function GetTableEntryTranslation($tableName, $field, $value, $langCode){
		return self::QueryAssocArray("SELECT * FROM `$tableName` WHERE $field='$value' AND `lang_code`='$langCode'");
	}


	/*public static function GetPage($collection, $page, $published=null, $orderBy=null) {
		$pub	= ($published) ? 'WHERE published=1' : '';
		$order	= ($orderBy) ? 'ORDER BY ' . $orderBy : '';
		$idsToQuery = '';

		$collectionIds = self::QueryAssocArray(
			"SELECT GROUP_CONCAT($page) as $page 
			FROM `collections_".$page."_r`
			WHERE  `collection_id` IN ($collection)"
		);

		if (!$collectionIds || !$collectionIds[0][$page]) {
			return false;
		} else {
			$idsToQuery = $collectionIds[0][$page];
		}

		return self::QueryAssocArray("SELECT * FROM $page WHERE id IN ($idsToQuery) $pub $order");
	}*/


	public function GetCollectionsPageRelationships($collections, $page) {
		$collectionIds = self::QueryAssocArray(
			"SELECT GROUP_CONCAT($page) as $page FROM `collections_".$page."_r` WHERE  `collection_id` IN ($collections)");

		if (!$collectionIds || !$collectionIds[0][$page]) {
			return false;
		} else {
			return $collectionIds[0][$page];
		}
	}


	/*public static function GetPageJoinedTables ($collection, 
												$page, 
												$joinedTables, 
												$lang, 
												$published=null, 
												$orderBy=null )
	{
		$pub	= ($published) ? 'WHERE ' . $page . '.published=1' : '';
		$order	= ($orderBy) ? 'ORDER BY ' . $orderBy : '';
		$idsToQuery = '';

		$collectionIds = self::QueryAssocArray(
			"SELECT GROUP_CONCAT($page) as $page FROM `collections_".$page."_r` WHERE  `collection_id` IN ($collection)");

		if (!$collectionIds || !$collectionIds[0][$page]) {
			return false;
		} else {
			$idsToQuery = $collectionIds[0][$page];
		}

		$joinedTablesStr = '';
		$joinedFieldsStr = '';
		$joinedLangStr = '';
		foreach ($joinedTables as $table) {
			$joinedTablesStr .= '`' . $table['table'] . '`, ';
			$joinedFieldsStr .= '`' . $table['table'] . '`.`' . $table['field'] . '`=' . $page . '.id AND ';
			$joinedLangStr .= '`' . $table['table'] . '`.`lang_code`=\'' . $lang . '\' AND ';
		}
		$joinedTablesStr = substr($joinedTablesStr, 0, strlen($joinedTablesStr) - 2);
		$joinedFieldsStr = substr($joinedFieldsStr, 0, strlen($joinedFieldsStr) - 5);
		$joinedLangStr = substr($joinedLangStr, 0, strlen($joinedLangStr) - 5);

		return self::QueryAssocArray(
			"SELECT * FROM $page
			INNER JOIN ($joinedTablesStr) ON ($joinedFieldsStr)
			WHERE $joinedLangStr AND $page.id IN ($idsToQuery)
			$pub $order"
		);
	}*/


	public static function SearchInTable($table, $value, $fieldsArray) {
		$query = "SELECT * FROM `$table` WHERE";

		foreach ($fieldsArray as $field) {
			$query .= ' `' . $field . '` LIKE ' . "'%" . $value . "%'";
			$query .= ' OR';
		}
		$query = substr($query, 0, strlen($query) - 3);

		return self::QueryAssocArray($query);
	}





	/******** Admin functions ********/

	public static function IsValidLogin($uname, $pwd) {
		$users = self::GetTableEntries('users');

		foreach ($users as $user) {
			if ($user['uname'] === $uname) {
				return ($user['passwd'] === $pwd);
			}
		}

		return false;
	}


	public static function CreateEntry($table, $fieldsArray, $valuesArray) {
		if (count($fieldsArray) !== count($valuesArray)) {
			die('DbFunctions::CreateEntry Failed!! "$fieldsArray" and "$valuesArray" count don\'t match');
		}

		$fieldsStr = '(';
		$valuesStr = '(';

		for ($i = 0; $i < count($fieldsArray); $i++) {
			$fieldsStr .= "`" . $fieldsArray[$i] . "`" . ',';
			$valuesStr .= "'" . $valuesArray[$i] . "'" . ',';
		}

		if (count($fieldsArray) > 0) {
			$fieldsStr = substr($fieldsStr, 0, -1);
			$valuesStr = substr($valuesStr, 0, -1);
		}

		$fieldsStr .= ')';
		$valuesStr .= ')';

		$query = "INSERT INTO `$table` $fieldsStr VALUES $valuesStr";

		return self::Query($query);
	}


	public static function DeleteEntry($table, $id) {
		$query = "DELETE FROM `$table` WHERE id='$id' LIMIT 1";

		return self::Query($query);
	}


	public static function UpdateEntry($table, $id, $fieldsArr, $valuesArr) {
		if (count($fieldsArr) !== count($valuesArr)) {
			throw new Exception('UpdateEntry Failed!! fields and values don\'t match');
		}

		$setStr = '';
		for ($i = 0; $i < count($fieldsArr); $i++) {
			$setStr .= '`' . $fieldsArr[$i] . '`' . '=' . "'" . $valuesArr[$i] . "'" . ',';
		}
		$setStr = substr($setStr, 0, -1);

		$q = "UPDATE `$table` SET $setStr WHERE id='$id' LIMIT 1";

		return self::$dbWorker->query($q);
	}


	public static function RemoveRelation($relTable, $id) {
		if (!$relTable || !$id) {
			throw new Exception('RemoveRelation Failed!! Missing function arguments!!');
		}

		$rgx = '/(.*)((?:,' . $id . '\b)|(?:\b' . $id . ',))(.*)/';
		$table = 'collections_' . $relTable . '_r';
		$relations = self::QueryAssocArray("SELECT * FROM `$table`");

		foreach ($relations as $relation) {
			$newRelations = $relation[$relTable];

			// only 1 entry
			if (preg_match('/^\s*' . $id . '$\s*/', $relation[$relTable])) {
				$newRelations = '';
			}

			// list of entries
			if (preg_match($rgx, $relation[$relTable], $match)) {
				$newRelations = $match[1] . $match[3];
			}

			// update if needed
			if ($newRelations !== $relation[$relTable]) {
				self::UpdateEntry($table, $relation['id'], [$relTable], [$newRelations]);
			}
		}
	}	

}

DbFunctions::Init();