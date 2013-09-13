<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['repeat_password']) and !empty($_POST['email'])){	
		if($_POST['password']==$_POST['repeat_password']){
			$login= clear_data($_POST['login']);
			$password=md5(clear_data($_POST['password']));
			$email=$_POST['email'];
			registration($login,$password,$email,$lang);
		}
		else{
			echo"Check your password, please";
		}
	}
	else{
		echo"Please check the form filling";
	}
}
?>