<?php
session_start();
if (!isset($_SESSION['id']))
	header('location: login');

if (!isset($_COOKIE['tabWidth'])) {
	setcookie('tabWidth', 243, time() + (86400 * 90), "/");
	$tabWidth = 243;
} elseif (!is_numeric($_COOKIE['tabWidth'])) {
	setcookie('tabWidth', 243, time() + (86400 * 90), "/");
	$tabWidth = 243;
} else $tabWidth = $_COOKIE['tabWidth'];

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<title>My Bookmarks</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/from.css" />
	<link rel="stylesheet" type="text/css" href="css/profile.css" />
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/profile.js"></script>
</head>

<body>
	<!-- Header -->
	<?php include('common/header.php') ?>

	<main>
		<div class="top-div">
			<div>
				<span id="hellospan">Hello <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></span>
			</div>
			<div class="size-slider-container">
				<img src="img\scale_up_down.svg" alt="scale up down">
				<input value="<?= $tabWidth ?>" oninput="scaleTabs(this.value)" id="size-slider" type="range" min="143" max="343">
			</div>
		</div>

		<div id="fav-container">
			<div class="noBg favDiv" fav_id="last">
				<button id="addFavButton">
					<img src="img/fav.png" />
				</button>
			</div>

			<!-- Align Divs -->
			<?php for ($i = 0; $i < 7; $i++) { ?>
				<div class="favDiv align-div" style="width: <?= $tabWidth ?>px;"></div>
			<?php } ?>
			<!-- Align Divs End -->
		</div>

		<!-- Add modal -->
		<div id="modal">
			<div id="mContent">
				<div id="mContentContainer">
					<input id="site_nameInput" class="form-input" type="text" placeholder="Site Name" />
					<input id="site_urlInput" class="form-input" type="text" placeholder="Site URL" />
					<button id="addFavSubmit" class="form-submit">Submit</button>
				</div>
			</div>
		</div>
	</main>

	<!-- Footer -->
	<?php include('common/footer.php') ?>
</body>

</html>
