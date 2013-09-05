<?php
session_start();
$_SESSION['lang']='eng';
header("Location:{$_SERVER[HTTP_REFERER]}");
?>