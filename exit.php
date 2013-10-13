<?php
session_start();
require "lib.inc.php";
$name=$_SESSION['name'];
last_visiting($name);
unset($_SESSION['name']);
header("Location:{$_SERVER['HTTP_REFERER']}");
?>