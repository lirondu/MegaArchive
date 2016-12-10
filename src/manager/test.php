<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbWorker/mysql.php';

function RemoveRelation($relTable, $id) {
	if (!$relTable || !$id) {
		throw new Exception('RemoveRelation Failed!! Missing function arguments!!');
	}

	$rgx = '/(.*)((?:,' . $id . '\b)|(?:\b' . $id . ',))(.*)/';
	$table = 'collections_' . $relTable . '_r';
	$relations = DbFunctions::QueryAssocArray("SELECT * FROM `$table`");
	
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
			DbFunctions::UpdateEntry($table, $relation['id'], [$relTable], [$newRelations]);
		}
	}
}

try {
	RemoveRelation('artists', '34');
} catch (Exception $e) {
	echo $e;
}