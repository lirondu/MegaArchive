<?
$allPublishedCollections = DbFunctions::GetTableEntries('collections', '1', 'position');
?>

<div id="header_mobile_content">
	<div id="mobile_menu_btn_container">
		<a id="mobile_menu_btn" href="javascript:void(0)" is-opened="false">
			<span class="glyphicon glyphicon-menu-hamburger"></span>
		</a>
	</div>
	
	<div class="title-container">
		<a href="/"><h1>collection</h1></a>
	</div>
</div>

<div id="header_content">

	<div id="top_bar">
		<div id="view_links">
			<a href="javascript:void(0)" class="view-link url-link" type="view" value="1">Text 	View</a>
			<a href="javascript:void(0)" class="view-link url-link" type="view" value="2">Thumbnails 	View</a>
		</div>

		<div id="site_links">
			<!--a href="javascript:void(0)" id="login_btn">Login</a-->
			<a href="javascript:void(0)" class="lang-btn url-link" type="lang" value="en">en</a>
			<span>/</span>
			<a href="javascript:void(0)" class="lang-btn url-link" type="lang" value="de">de</a>
			<span>/</span>
			<a href="javascript:void(0)" class="lang-btn url-link" type="lang" value="it">it</a>
		</div>

		<div id="search_container">
			<input type="text" id="site_search" placeholder="Search">
			<span id="loading_results"></span>
		</div>
	</div>

	<div class="clear-both"></div>

	<div class="title-container">
		<a href="/"><h1>collection</h1></a>
	</div>

	<div id="collections_container">
		<ul>
		<?
		foreach ($allPublishedCollections as $collection) {
			if (! Permissions::ValidateCollectionId($collection['id'])) { continue; }
			?>
				<li>
					<div class="custom-checkbox">
						<input 	type="checkbox" 
								id="chk<?= $collection['id'] ?>"
								value="<?= $collection['id'] ?>">

						<label 	for="chk<?= $collection['id'] ?>"
								style="color: <?= $collection['bg_color'] ?>">
									<?= $collection['name'] ?>
						</label>
					</div>
				</li>
			<?
		}
		?>
		</ul>
	</div>

	<div id="pages_container" class="clear-both">
		<ul class="main-pages-links">
		<?
		foreach (StaticMaps::$pages as $pageId => $page) {
			if (!$page['show_in_menu']) { continue; }
		?>
			<li class="page-link-container">
				<a 	href="javascript:void(0)" 
					class="page-link page-url-link" 
					page="<?= $pageId ?>" 
					order="<?= StaticMaps::$pagesSubMenus[$page['table']][0] ?>">
						<?= $page['name'] ?>
				</a>
			
				<ul class="page-link-submenu" state="closed">
				<?
				foreach (StaticMaps::$pagesSubMenus[$page['table']] as $menuItem) {
				?>
					<li>
						<a 	href="javascript:void(0)" 
							class="page-url-link" 
							page="<?= $pageId ?>"
							order="<?= $menuItem ?>">
							<?= StaticMaps::$orders[$menuItem] ?>
						</a>
					</li>
				<?
				}
				?>
				</ul>
			</li>
		<?
		}
		?>
		</ul>
	</div>

</div>