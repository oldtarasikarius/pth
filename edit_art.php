<?php
include "inc/lib.inc.php";
	
if($_SERVER['REQUEST_METHOD']=='POST'){		
	$n_eng_art=clear_data($_POST['eng_art']);
	$n_ukr_art=clear_data($_POST['ukr_art']);
	$n_eng_head=clear_data($_POST['eng_head']);
	$n_ukr_head=clear_data($_POST['ukr_head']);
	$num=clear_data($_GET['num']);
	if(!empty($n_eng_art) and !empty($n_ukr_art)){		
		edit_art($connect,$num,$n_eng_art,$n_ukr_art,$n_eng_head,$n_art_head);
		header("Location:index.php?id=articles&num=$num");
	}
}
?>