<?php
session_start();
if (!isset($_SESSION['id'])) header("location: ../index");

require 'dataBase.php';

$id = $_SESSION['id'];
$result = $sql->query(
	"SELECT `fav_id`, `site_name`, `site_URL`
	 FROM `favs` WHERE `user_id`= $id
	 ORDER BY `site_order` ASC"
) or die('false');

$bookmarksArray = array();
while ($data = mysqli_fetch_row($result)) {
	array_push($bookmarksArray, $data[0], htmlspecialchars($data[1]), htmlspecialchars($data[2]));
}

echo json_encode($bookmarksArray);
