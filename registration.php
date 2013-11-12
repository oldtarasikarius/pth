<?php
session_start();
require "inc/lib.inc.php";
if ($_SERVER['REQUEST_METHOD']=='POST'){
	if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['repeat_password']) and !empty($_POST['email'])){	
		if ($_POST['password']!==$_POST['repeat_password']) {
				$_SESSION['error']="Check your password, please";
				header("Location:index.php?id=registration_form");
		}
		else {
			$login= clear_data($_POST['login']);
			$password=md5(clear_data($_POST['password']));
			$email=$_POST['email'];
			registration($connect,$login,$password,$email,$lang);
			if(isset($_SESSION['error'])) {
				header("Location:index.php?id=registration_form");
			}
			else {
				header("Location:index.php");
			}
		}
	}
}
?>