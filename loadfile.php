<?php

session_start();
require("lib.inc.php");


if(isset($_SESSION['name'])){
	$name=$_SESSION['name'];
		if(isset ($_GET['link']))
			$link_name=clear_data($_GET['link']);
		else
			$link_name=$name;


	if($_FILES['userfile']['type']!=="image/jpeg"  ){
		header("Location:index.php?id=edit_profile&link=".$link_name);
		exit();
	}

	if(isset($_FILES['userfile'])){	
		if(!is_dir("C:/Users/Public/SERVER/Apache2.2/htdocs/test/photos/$link_name"))
			mkdir("C:/Users/Public/SERVER/Apache2.2/htdocs/test/photos/$link_name");

		$fname="photos/".$link_name."/".$link_name; 
		$tmp_name=$_FILES['userfile']['tmp_name'];
		$_SESSION['fname']=$fname;
		if(move_uploaded_file($tmp_name,$fname)){
			add_avatar($link_name,$fname);
			header("Location:index.php?id=edit_profile&link=".$link_name);
		}
	}
}
?>