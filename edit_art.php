<?php
include "inc/lib.inc.php";
	
if($_SERVER['REQUEST_METHOD']=='POST'){		
	$nart=clear_data($_POST['art']);
	$nhead=clear_data($_POST['header']);
	$num=clear_data($_GET['num']);
	if(!empty($nart)){		
		edit_art($connect,$num,$nart,$nhead);
		header("Location:index.php?id=articles");
	}
}
?>