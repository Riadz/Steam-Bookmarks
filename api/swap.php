<?php
session_start();
if (!isset($_SESSION['id'])) header("location: ../index");
if (!isset($_GET['fav1Id']) || !isset($_GET['fav2Id'])) return;
if ($_GET['fav1Id']  === $_GET['fav2Id']) return;
require 'dataBase.php';

$id = $_SESSION['id'];
$fav_id_1 = mysqli_real_escape_string($sql, $_GET['fav1Id']);
$fav_id_2 = mysqli_real_escape_string($sql, $_GET['fav2Id']);

$result = $sql->query(
	"SELECT `site_order` FROM `favs`
	 WHERE `fav_id`= '$fav_id_1'"
) or die('false');
$site_order_1 = mysqli_fetch_row($result)[0];

if ($fav_id_2 != "last") {

	$result = $sql->query(
		"SELECT `site_order` FROM `favs`
		 WHERE `fav_id`= '$fav_id_2'"
	) or die('false');
	$site_order_2 = mysqli_fetch_row($result)[0];

	//Case 1: moving from top to down
	if ($site_order_1 < $site_order_2) {
		$sql->query(
			"UPDATE `favs`
			 SET `site_order`=`site_order`-1
			 WHERE `user_id` = $id
			 AND `site_order`> $site_order_1
			 AND `site_order`< $site_order_2
			 ORDER BY `site_order` ASC"
		) or die('false');

		$site_order_2--;
		$sql->query(
			"UPDATE `favs` SET `site_order`= $site_order_2
			 WHERE fav_id= '$fav_id_1'"
		) or die('false');
	}
	//Case 2: moving from down to top
	else {
		$sql->query(
			"UPDATE `favs`
			 SET `site_order`= `site_order`+1
			 WHERE `user_id`= $id
			 AND `site_order`>= $site_order_2
			 AND `site_order`< $site_order_1
			 ORDER BY `site_order` ASC"
		) or die('false');

		$sql->query(
			"UPDATE `favs` SET `site_order`= $site_order_2
			 WHERE fav_id= '$fav_id_1'"
		) or die('false');
	}
}
//Case 3: (special case) moving to the last case
else {
	$sql->query(
		"UPDATE `favs`
		 SET `site_order`= `site_order`-1
		 WHERE `user_id` = $id
		 AND `site_order`> $site_order_1"
	) or die('false');

	$result = $sql->query(
		"SELECT `fav_count` FROM `user`
		 WHERE `id`= $id"
	) or die('false');
	$last_site_order = mysqli_fetch_row($result)[0];

	$sql->query(
		"UPDATE `favs` SET `site_order`= $last_site_order
		WHERE `fav_id`= '$fav_id_1'"
	) or die('false');
}
