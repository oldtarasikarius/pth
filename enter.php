<?php
session_start();
include"inc/lib.inc.php";

if($_SERVER['REQUEST_METHOD']=='POST'){

	if(!empty($_POST['login']) and !empty($_POST['password'])){
		$login= clear_data($_POST['login']);
		$password=md5(clear_data($_POST['password']));
		enter($connect,$login,$password);
	}
	else
		header("Location:index.php?id=enter_error");
}	
?>