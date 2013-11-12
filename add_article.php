<?php
session_start();
$lang="eng";
if(isset($_SESSION['lang']))
	$lang=$_SESSION['lang'];
include"inc/lib.inc.php";
	if(isset($_SESSION['name'])){
		$name=$_SESSION['name'];
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$eng_art=clear_data($_POST['eng_art']);
			$ukr_art=clear_data($_POST['ukr_art']);
			$eng_head=clear_data($_POST['eng_head']);
			$ukr_head=clear_data($_POST['ukr_head']);
			if(!empty($eng_art) and !empty($ukr_art)){
				add_art($connect,$eng_art,$ukr_art,$eng_head,$ukr_head,$name);
				header("Location:index.php?id=articles");
				exit();
			}
			else
				header("Location:{$_SERVER['HTTP_REFERER']}");
		}		
	}

?>