<?php
//removing session
session_start();
session_unset();
//removing cookies
setcookie('logged_id', null, 1, '/');
setcookie("logged_hash", null, 1, '/');

header("location: index");
