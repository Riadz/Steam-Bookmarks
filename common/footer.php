<head>
	<style>
		footer {
			display: flex;
			align-items: center;
			justify-content: center;

			height: 60px;
			width: 100%;

			color: white;
			background: var(--secondary-bg-color);
		}

		footer a {
			margin-left: 0.4rem;
			color: var(--primary-color);
		}

		footer a:hover {
			color: var(--complementary-color);
		}
	</style>
</head>

<body>
	<footer>
		<span>
			Copyright &copy;
			<?= date("Y") ?>
			All rights reserved, Created By<a href="#">Riad</a>
		</span>
	</footer>
</body>
