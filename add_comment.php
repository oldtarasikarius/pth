<?php
session_start();
require "inc/lib.inc.php";

if (!isset($_SESSION['name']) or $_SERVER['REQUEST_METHOD']!=='POST'){
  header("Location:index.php");
  exit();
}
$date=date("Y-m-d H:i:s");
$num=$_GET['num'];
$name=$_SESSION['name'];
$lang='eng';
if(isset($_SESSION['lang'])) {
  $lang=$_SESSION['lang'];
}
$sub=clear_data($_POST['sub']);
$comment=clear_data($_POST['comment']);
if($comment=="") {
  $_SESSION['error']="You forget to ener your comment!!!";
  header("Location:index.php?id=articles&num=$num#comment_form");
  exit();
}
if(add_comment($connect,$name,$sub,$comment,$num,$lang)) {
  header("Location:index.php?id=articles&num=$num#comment_form");
  exit();
}
?>