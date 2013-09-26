<?php

session_start();
require("lib.inc.php");
if(isset($_SESSION['name'])){
	$name=$_SESSION['name'];
	


	if($_FILES['userfile']['type']!=="image/jpeg"  ){
		header("Location:index.php?id=edit_profile");
		exit();
	}

	if(isset($_FILES['userfile'])){	
		if(!is_dir("C:/Users/Public/SERVER/Apache2.2/htdocs/test/photos/$name"))
			mkdir("C:/Users/Public/SERVER/Apache2.2/htdocs/test/photos/$name");

		$fname="photos/".$name."/".$name; 
		$tmp_name=$_FILES['userfile']['tmp_name'];
		$_SESSION['fname']=$fname;
		if(move_uploaded_file($tmp_name,$fname)){
			add_avatar($name,$fname);
			header("Location:index.php?id=edit_profile");
		}
	}
}
?>