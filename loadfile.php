<?php
session_start();
require("inc/lib.inc.php");


if(isset($_SESSION['name'])){
	$name=$_SESSION['name'];
		if(isset ($_GET['link']))
			$link_name=clear_data($_GET['link']);
		else
			$link_name=$name;


	if ($_FILES['userfile']['type']!=="image/jpeg" or $_FILES['userfile']['type']!=="image/gif" ){
		$_SESSION['error']=change_language($connect,'You can only upload *.gif and *.jpg files!!!',$lang);
		header("Location:index.php?id=edit_profile&link=".$link_name);
		exit();
	}

	if (isset($_FILES['userfile'])) {
		if(!is_dir("img/photos/$link_name"))
			mkdir("img/photos/$link_name");

		$fname="img/photos/{$link_name}/{$link_name}";
		$tmp_name=$_FILES['userfile']['tmp_name'];
		$_SESSION['fname']=$fname;
		if(move_uploaded_file($tmp_name,$fname)){
			add_avatar($connect,$link_name,$fname);
			header("Location:index.php?id=edit_profile&link=".$link_name);
		}
	}
}
?>