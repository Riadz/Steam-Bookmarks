<?php
session_start();
if (!isset($_SESSION['id'])) header("location: ../index");
if (!isset($_GET['site_name']) || !isset($_GET['site_url'])) return;

require 'dataBase.php';

$id = $_SESSION['id'];
$result = $sql->query( //getting current fav count
	"SELECT `fav_count` FROM `user`
	 WHERE `id`= $id LIMIT 1"
) or die('false');

$fav_count = (int) mysqli_fetch_row($result)[0] + 1;
$site_name = mysqli_real_escape_string($sql, $_GET['site_name']);
$site_url = mysqli_real_escape_string($sql, $_GET['site_url']);

$sql->query( //adding fav to the database
	"INSERT INTO `favs` (`user_id`, `site_name`, `site_URL`, `site_order`)
	 VALUES ($id,'$site_name','$site_url','$fav_count')"
) or die('false');

$fav_id = $sql->insert_id;

$sql->query( //incrementing the fav count
	"UPDATE `user` SET `fav_count`=`fav_count`+1
	 WHERE `id`= $id"
) or die('false');

//returning the id of the inserted bookmark
echo $fav_id;
