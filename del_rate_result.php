<?php
require "inc/lib.inc.php";
if (isset($_GET['num'])){
  $num=$_GET['num'];
  del_rating($connect,$num);
}
header("Location:index.php?id=articles");
?>