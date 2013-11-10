<?php
session_start();
require "inc/lib.inc.php";
if(isset($_SESSION['name'])){
	if(isset ($_GET['link']))
		$link_name=clear_data($_GET['link']);
	else
		$link_name=$name;
	if($_SERVER['REQUEST_METHOD']="POST"){
		if(!empty($_POST['lname']) or 
			!empty($_POST['new_role']) or
			!empty($_POST['fname']) or 
			!empty($_POST['email']) or 
			!empty($_POST['password']) or 
			!empty($_POST['repeat_password'])){
			if($_POST['password']!==$_POST['repeat_password']){
				$_SESSION['error']="Password wasn`t confirm properly!";
				header("Location:index.php?id=edit_profile&link=".$link_name);
				exit();				
			}
			else{
				$fname=clear_data($_POST['fname']);
				$lname=clear_data($_POST['lname']);
				$email=clear_data($_POST['email']);
				$new_role=clear_data($_POST['new_role']);
				$password="";
				if(!empty($_POST['password']))
					$password=md5(clear_data($_POST['password']));
					
				edit_pers_data($connect,$link_name,$fname,$lname,$email,$password,$new_role);
				if(isset($_SESSION['error'])){
					header("Location:index.php?id=edit_profile&link=".$link_name);
					exit();
				}
				header("Location:index.php?id=profile&link=".$link_name);
			}
		}
		else
			header("Location:index.php?id=edit_profile&link=".$link_name);
	}
}
?>