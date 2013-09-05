<?php

session_start();
$_SESSION['lang']='ukr';
header("Location:{$_SERVER[HTTP_REFERER]}");
?>