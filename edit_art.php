<?php
include "lib.inc.php";
	
if($_SERVER['REQUEST_METHOD']=='POST'){		
	$nart=clear_data($_POST['art']);
	$num=clear_data($_GET['num']);
	if(!empty($nart)){		
		edit($connect,$num,$nart);
		header("Location:index.php?id=articles");
	}
}
?>