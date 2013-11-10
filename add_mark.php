<?php
session_start();
require "inc/lib.inc.php";
if($_SERVER['REQUEST_METHOD']=='POST') {
  if(isset($_SESSION['name'])){
    if(isset($_GET['num'])){
      $num=$_GET['num'];
      $name=$_SESSION['name'];
      $mark=clear_data($_POST['mark']);
      if(!get_mark($connect,$name,$num)){
        add_mark($connect,$num,$name,$mark);
      }
       header("Location:index.php?id=articles&num=$num#mark");
       exit();
    }
  }  
}
header("Location:index.php?id=articles");
?>