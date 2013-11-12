<?php
session_start();
require"inc/lib.inc.php";

if (isset($_SESSION['name'])){
		if ($_SESSION['role']=="admin"){
			if(isset($_GET["num"])){
        $num=$_GET['num'];
      }
      if(isset($_GET['com_id'])){
        $com_id=$_GET['com_id'];
        del_comment($connect,$com_id);
        header("Location:index.php?id=articles&num={$num}#comment_form");
        exit();
      }
    } 
}

  else{
  	header("Location:{$_SERVER['HTTP_REFERER']}");
  }
?>