<?php
require_once './php/permissions.php';
require_once './php/static-maps.php';
require_once './db-worker/mysql.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="./css/custom-checkbox.css">
	<link rel="stylesheet" href="./css/override.css">
	<link rel="stylesheet" href="./css/big-screen.css" media="(min-width: 850px)">
	<link rel="stylesheet" href="./css/small-screen.css" media="(max-width: 849px)">
	<link rel="stylesheet" href="./css/common.css">
	<!--link rel="stylesheet" href="./external/jquery-typeahead-2.7.0/jquery.typeahead.min.css"-->
	<link rel="stylesheet" href="./css/search-box.css">
</head>
<body>

<div id="header">
	<? require_once './php/header.php'; ?>
</div>


<div id="page_container"></div>


<div id="page_footer">
	<p>&copy; 2016, Kathrin Oberrauch, Finstral AG</p>
</div>


<script src="./js/screen-width.js"></script>
<script src="./js/mobile-menu.js"></script>
<script src="./js/url-worker.js"></script>
<script src="./js/header.js"></script>
<script src="./js/thumb-view.js"></script>
<script src="./js/content-loader.js"></script>
<script src="./external/typeahead-0.11.1-fork/typeahead.bundle.min.js"></script>
<!--script src="./external/jquery-typeahead-2.7.0/jquery.typeahead.min.js"></script-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
<script src="./js/search-box.js"></script>

</body>
</html>