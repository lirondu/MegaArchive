<?php
if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['valid_admin']) && $_SESSION['valid_admin']) {
	header('Location: /manager/');
}

require_once './../../db-worker/mysql.php';

$loginError = '';

if (isset($_POST['uname']) && isset($_POST['passwd'])) {
	$uname	 = $_POST['uname'];
	$passwd	 = md5($_POST['passwd']);
	
	if (DbFunctions::IsValidLogin($uname, $passwd)) {
		$_SESSION['valid_admin'] = true;

		header('Location: /manager/');
	}
	else {
		$loginError = 'Wrong username or password';
	}
}
?>


<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Archive Management Login</title>
	<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
		crossorigin="anonymous">
	<link rel="stylesheet" href="login.css">
</head>


<body>
	<div id="login_form_container">
		<h3>Archive Management Login</h3>
		
		<div id="login_error_div" class="alert alert-danger">
			<span id="login_error_div_close_handler">
				<span id="login_error_div_close" class="close">&times;</span>
			</span>
			<p><? echo $loginError; ?></p>
		</div>

		<form action="index.php" method="POST" id="login_form">
			<ul>
				<li>
					<label for="uname">Username</label>
					<input type="text" id="uname" name="uname">
				</li>
				<li>
					<label for="passwd">Password</label>
					<input type="password" id="passwd" name="passwd">
				</li>
				<li>
					<input type="submit" value="Sign in" class="btn btn-primary">
				</li>
			</ul>
		</form>
	</div>


	<script>
		$('input').first().focus();

		if ($('#login_error_div p').html() !== '') {
			$('#login_error_div').slideDown(250);
		}

		$('#login_error_div_close_handler').click(function (){
			$('#login_error_div').slideUp(250);
			$('input').first().focus();
		});

		$('#login_form').submit(function(){
			$('#login_error_div').slideUp(250);
		});
	</script>

</body>

</html>