<?php

$data = file_get_contents('https://plus.google.com/_/favicon?domain=' . $_GET['url']);
$base64 = base64_encode($data);
$favicon = hash('md5', $base64) != 'd3952ca268d60e45d0a3ce54ff0241c4' ? true : false;

if ($favicon) echo 'true';
else echo 'false';
