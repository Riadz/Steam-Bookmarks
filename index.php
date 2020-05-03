<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />

	<!-- SEO -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="Content-Language" content="en">	
	<meta name="language" content="en" />
	<meta name="application-name" content="Steambookmarks">
	<meta name="description" content="Steambookmarks Is simply a site where you can add bookmarks to be saved, set this site as your steam ingame browser's homepage, create an account and add your bookmarks">
	<meta name="keywords" content="steambookmarks, steam, bookmarks" />
	<meta name="robots" content="index,follow" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Default-Style" content="dark">

	<meta property="og:title" content="Save your Steam's ingame browser bookmarks" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://steambookmarks.rf.gd/" />
    <meta property="og:image" content="img/logo.svg" />
    <meta property="og:description" content="Steambookmarks Is simply a site where you can add bookmarks to be saved, set this site as your steam ingame browser's homepage, create an account and add your bookmarks">
    <meta property="og:site_name" content="Steambookmarks" />
	<!-- SEO end -->

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Steam Bookmarks</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/index.css" />
	<script src="js/index.js"></script>
</head>

<body>
	<!-- Header -->
	<?php include('common/header.php') ?>

	<main>
		<section class="intro" itemprop="reviewedBy" itemscope itemtype="https://schema.org/Organization">
			<div class="intro-text" itemprop="brand" itemscope itemtype="https://schema.org/Organization">
				<h1 class="text-gradient-1" itemprop="legalName" >Steam Bookmarks</h1>
				<p>
					Is simply a site where you can add bookmarks to be saved, set this
					site as your steam browser's homepage, create an account and add
					your bookmarks.<br />
					I created this because steam's in-game browser doesn't have a
					bookmark system.<br />
					<strong><u>This site is not affiliated with Steam.</u></strong>
				</p>
				<div class="horizontal-btn-or-container">
					<a href="login" class="styled-btn">
						Log in
					</a>
					<span class="horizontal-btn-or-splitter">Or</span>
					<a href="signup" class="styled-btn sb-complementary">
						Sign up
					</a>
				</div>
			</div>
			<div class="intro-image" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
				<img src="img/logo.svg" itemprop="thumbnail" />
			</div>
		</section>
		<section class="info-1">
			<div class="text-container">
				<h2>About me</h2>
				<p>
					Hello my name is <strong>Riad</strong> and i'm a full stack web developer,<br />
					feel free to contact me any time.
				</p>
			</div>
			<div class="button-container">
				<a href="#portfolio" class="styled-btn">
					Contact Now
				</a>
			</div>
		</section>
		<section class="two-images-2">
			<div class="two-images-2-wrapper">
				<div class="two-images-2-container">
					<div class="two-images-2-text">
						<img src="img\drag_and_drop.svg" alt="Click, Drag & Drop">
						<h2 class="text-gradient-1">Click, Drag & Drop</h2>
						<p>
							<strong>Easily</strong> re-arrange your bookmarks
						</p>
					</div>
					<div class="two-images-2-img">
						<video autoplay muted loop src="video/drag_and_drop.mp4">
						</video>
					</div>
				</div>
				<div class="two-images-2-container">
					<div class="two-images-2-img">
						<video autoplay muted loop src="video/scale_up_down.mp4">
						</video>
					</div>
					<div class="two-images-2-text">
						<img src="img\scale_up_down.svg" alt="Scale Up & Down">
						<h2 class="text-gradient-1">Scale Up & Down</h2>
						<p>
							<strong>Easily</strong> scale the tabs to fit you screen
						</p>
					</div>
				</div>
			</div>
		</section>
	</main>

	<!-- Footer -->
	<?php include('common/footer.php') ?>
</body>

</html>
