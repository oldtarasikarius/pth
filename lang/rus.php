<?php
session_start();
$_SESSION['lang']='rus';
header("Location:{$_SERVER[HTTP_REFERER]}");
?>