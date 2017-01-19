<?
$allPublishedCollections = DbFunctions::GetTableEntries('collections', '1', 'position');
?>

<div id="top_menu">

<!--div id="site_logo">COLLECTION</div-->

<div id="collections_links">
	<ul>
		<li>
			<a href="javascript:void(0)" 
				title="click to select"
				value="0"
				color="#000">
				All Collections
			</a>
		</li>

		<?
		foreach ($allPublishedCollections as $collection) {
			if (! Permissions::ValidateCollectionId($collection['id'])) { continue; }
			?>
				<li>
					<a href="javascript:void(0)" 
						title="click to select"
						value="<?= $collection['id'] ?>"
						color="<?= $collection['bg_color'] ?>">
						<?= $collection['name'] ?>
					</a>
				</li>
			<?
		}
		?>
	</ul>
</div>

<div id="pages_links">
	<ul>
		<?
		foreach (StaticMaps::$pages as $pageId => $page) {
			if (!$page['show_in_menu'] ||
				!$isAdmin && !$page['is_public']) {
					continue;
			}
			?>
			<li class="page-link-container">
				<a 	href="javascript:void(0)" 
					class="page-link page-url-link" 
					page="<?= $pageId ?>" 
					order="<?= StaticMaps::$pagesSubMenus[$page['table']][0] ?>">
						<?= $page['name'] ?>
				</a>
			</li>
			<?
		}
		?>
	</ul>
</div>

</div>