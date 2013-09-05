<?php
session_start();
include"lib.inc.php";
	if(isset($_SESSION['name'])){
		$name=$_SESSION['name'];
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$art=clear_data($_POST['art']);
			if(!empty($_POST['art']))
				add_art($art,$name);
		}
		else 
			echo change_language($lang,'something is going wrong')."... <a href='".$_SERVER['HTTP_REFERER']."'>".change_language($lang,'Previous page')."</a>";
		header("Location:index.php?id=articles");
	}
?>