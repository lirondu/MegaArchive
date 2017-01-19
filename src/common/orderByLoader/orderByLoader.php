<?
if (!isset($_SESSION)) {
	session_start();
}

$isAdmin = true;
if (!isset($_SESSION['valid_admin']) || !$_SESSION['valid_admin']) {
	$isAdmin = false;
}


require_once $_SERVER['DOCUMENT_ROOT'] . '/common/staticMaps/staticMaps.php';


if (!isset($_GET['page-name'])) {
	die('missing params!!');
}

$pageName = $_GET['page-name'];
$orderArr = StaticMaps::$pagesSubMenus[$pageName];

foreach ($orderArr as $order) {
	if (!$isAdmin && !StaticMaps::$orders[$order]['is_public']) { continue; }
	?>
	<li class="nav-item">
		<a href="javascript:void(0)"
			class="menu-link order-link"
			url-name="order"
			url-value="<?= $order ?>">
			<?= StaticMaps::$orders[$order]['name'] ?>
		</a>
	</li>
	<?
}