<?php
session_start();
if (!isset($_SESSION['id'])) header("location: ../index");
if (!isset($_GET['target'])) return;

require 'dataBase.php';

$id = $_SESSION['id'];
$target = mysqli_real_escape_string($sql, $_GET['target']);
$result = $sql->query(
	"SELECT `site_order` FROM `favs`
	WHERE `fav_id`= $target"
) or die('false');
$site_order = mysqli_fetch_row($result)[0];

$sql->query( //deleting the bookmark
	"DELETE FROM `favs` WHERE `fav_id`= $target LIMIT 1"
) or die('false');
$sql->query( //updating the order of other bookmarks
	"UPDATE `favs` SET `site_order`=`site_order`-1
	 WHERE `user_id`= $id  AND `site_order` > $site_order"
) or die('false');
$sql->query( //decrementing the fav count
	"UPDATE `user` SET `fav_count`=`fav_count`-1 WHERE `id`= $id"
) or die('false');
