<?php
require 'api/dataBase.php';
session_start();
//if session is present redirect to profile
if (isset($_SESSION['id'])) {
	header("location: profile");
}
//cookie auto login
if (isset($_COOKIE['logged_id'])) {
	$id = mysqli_real_escape_string($sql, $_COOKIE['logged_id']);
	$hash = mysqli_real_escape_string($sql, $_COOKIE['logged_hash']);

	$result = $sql->query(
		"SELECT `username`, `email`
     FROM `user`
		 WHERE `id` = $id
		 AND `hash` = '$hash'"
	) or die($sql->error);

	if ($data = mysqli_fetch_row($result)) {

		$sql->query(
			"UPDATE `user`
			 SET `last_login_date`='" . date("Y/m/d") . "'
			 WHERE `id` = $id"
		) or die($sql->error);

		$_SESSION['id'] = $id;
		$_SESSION['username'] = $data[0];
		$_SESSION['email'] = $data[1];
		$_SESSION['hash'] = $hash;

		header("location: profile");
	} else header("location: logout");
}
//post signup
if (isset($_POST['signup']) && $_POST['password'] === $_POST['re-password']) {
	$username = mysqli_real_escape_string($sql, $_POST['username']);
	$email    = mysqli_real_escape_string($sql, $_POST['email']);
	$password = mysqli_real_escape_string($sql, $_POST['password']);
	$password = password_hash($password, PASSWORD_BCRYPT);

	$result = $sql->query(
		"SELECT `id` FROM `user` WHERE `username` = '$username'"
	) or die($sql->error);

	if ($result->num_rows === 0) {
		$hash = md5(random_int(0, 700) . $username . date("Y/m/d") . 'secret_key_lmao');
		$date = date("Y/m/d");

		$sql->query(
			"INSERT INTO `user`(`username`,`email`,`password`,`hash`,`register_date`,`last_login_date`)
		 VALUES ('$username',
		 				 '$email',
						 '$password',
						 '$hash',
						 '$date',
						 '$date')"
		) or die($sql->error);

		$_SESSION['id'] = $sql->insert_id;
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['hash'] = $hash;

		setcookie("logged_id", $sql->insert_id, time() + (86400 * 90), "/");
		setcookie("logged_hash", $hash, time() + (86400 * 90), "/");

		header("location: profile");
	} else
		echo '
		<script>
		window.onload = () => {
			showErr("Username already exists!");
		}
		</script>
		';
}
if (isset($_POST['signup']) && $_POST['password'] !== $_POST['re-password'])
	echo '
		<script>
		window.onload = () => {
			showErr("Passwords don\'t match!");
		}
		</script>
		';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign up</title>
	<link rel="shortcut icon" href="favicon.png">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/from.css">
	<script src="js/jquery/jquery-3.3.1.min.js"></script>
	<script src="js/from.js"></script>
</head>

<body>
	<!-- Header -->
	<?php include('common/header.php') ?>

	<div class="form-container">
		<div class="form-wrapper">
			<div id="fromErrorDiv"></div>
			<form name="signup" method="POST">
				<input class="form-input" name="username" type="text" placeholder="User Name *" required>
				<input class="form-input" name="email" type="email" placeholder="Email Address">
				<input class="form-input" name="password" type="password" placeholder="Password *" required>
				<input class="form-input" name="re-password" type="password" placeholder="Confirm Password *" required>
				<button class="form-submit" type="submit" name="signup">Signup</button>
				<span class="form-bottom-text">Already registered? <a href="login">Log In</a></span>
			</form>
		</div>
	</div>
	<!-- Footer -->
	<?php include('common/footer.php') ?>
</body>

</html>
