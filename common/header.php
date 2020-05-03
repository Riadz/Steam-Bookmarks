<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();
?>

<head>
	<link rel="stylesheet" href="css/header.css">
</head>

<body>
	<header id="header-container">
		<div id="header">
			<div id="logo-container">
				<img src="img/logo.svg" alt="Steam Bookmarks logo" />
				<span class="text-gradient-1">Steam Bookmarks</span>
			</div>
			<div id="nav-container">
				<ul id="nav">
					<li><a href="index">Home</a></li>
					<li><a href="#portfolio">Contact</a></li>
					<?php if (!isset($_SESSION['id'])) { ?>
						<li><a href="signup">Sign up</a></li>
						<li><a href="login">Log in</a></li>
					<?php } else { ?>
						<li><a href="logout">Log out</a></li>
						<li><a href="profile">My Bookmarks</a></li>
					<?php } ?>
				</ul>
			</div>
			<button id="dropdown-btn"></button>
		</div>
	</header>
</body>
