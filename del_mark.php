<?php
session_start();
require 'inc/lib.inc.php';
if (isset($_GET['num'])){
  $num=$_GET['num'];
  if(isset($_SESSION['name'])) {
    $name=$_SESSION['name'];
    del_mark($connect,$name);
  }
  header("Location:index.php?id=articles&num=$num#mark");
  exit();
}
header("Location:index.php?id=articles");
?>