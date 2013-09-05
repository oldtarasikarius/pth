<?php

include"lib.inc.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty($_POST['eng_art']) or !empty($_POST['ukr_art']) or !empty($_POST['rus_art'])){
		$eng=clear_data($_POST['eng_art']);
		$ukr=clear_data($_POST['ukr_art']);
		$rus=clear_data($_POST['rus_art']);
		
		insert($eng,$ukr,$rus);
		header("Location:index.php");
	}
	else
		echo"You didn`t type enything, please <a href='".$_SERVER['HTTP_REFERER']."'>returne</a> and enter your article";
	
}
?>