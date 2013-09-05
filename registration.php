<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty($_POST['login']) and !empty($_POST['password'])){	
		$login= clear_data($_POST['login']);
		$password=md5(clear_data($_POST['password']));
		registration($login,$password,$lang);
	}	
}
?>