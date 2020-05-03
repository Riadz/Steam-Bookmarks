<?php
require 'api/dataBase.php';
session_start();
//if session is present redirect to profile
if (isset($_SESSION['id'])) {
	header("location: profile");
};
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
};
//post login
if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($sql, $_POST['username']);
	$password = mysqli_real_escape_string($sql, $_POST['password']);

	$result = $sql->query(
		"SELECT `id`, `password`, `email`, `hash`
		 FROM `user`
		 WHERE `username` ='$username'"
	) or die("unexpected error please try again");

	if ($result->num_rows !== 0) {
		$data = mysqli_fetch_assoc($result);

		if (!password_verify($password, $data['password']))
			echo '
			<script>
				window.onload = () => {
					showErr("Wrong username or password !");
				}
			</script>
			';
		else {
			$_SESSION['id'] = $data['id'];
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $data['email'];
			$_SESSION['hash'] = $data['hash'];

			$sql->query(
				"UPDATE `user`
			 	 SET `last_login_date`='" . date("Y/m/d") . "'
			 	 WHERE `id`=" . $data['id']
			);

			setcookie("logged_id", $data['id'], time() + (86400 * 90), "/");
			setcookie("logged_hash", $data['hash'], time() + (86400 * 90), "/");

			header("location: profile");
		}
	} else
		echo '
		<script>
			window.onload = () => {
				showErr("This username doesn\'t exist !");
			}
		</script>
		';
}
?>
<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Log in</title>
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
			<form name="login" method="POST">
				<input class="form-input" name="username" type="text" placeholder="User Name" required>
				<input class="form-input" name="password" type="password" placeholder="Password" required>
				<button class="form-submit" type="submit" name="login">login</button>
				<span class="form-bottom-text">Not registered? <a href="signup">Create an account</a></span>
			</form>
		</div>
	</div>

	<!-- Footer -->
	<?php include('common/footer.php') ?>
</body>

</html>
