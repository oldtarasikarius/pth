<?php
session_start();
require "inc/lib.inc.php";
if(isset($_SESSION['name']) and $_SESSION['role']=='admin'){
  if(isset($_GET['id'])){
    $id=$_GET['id'];
    del_word($connect,$id);  
  }
}
header("Location:index.php?id=translation_form");
?>