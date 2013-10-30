<?php
session_start();
require"inc/lib.inc.php";

$name="";
if(isset($_SESSION['name']))
	$name=$_SESSION['name'];	
$lang="eng";
if(isset($_SESSION['lang']))
	$lang=$_SESSION['lang'];
$id="";
if(isset($_GET['id']))
	$id=$_GET['id'];
$role=set_role($connect,$name);

$page_num=1;
if(isset($_GET['num']))
	$page_num=$_GET['num'];

?>

<!DOCTYPE html>

<html>
<head>
	<title>Protest The Hero</title>
	<meta charset=windows-1251" />
	<style type="text/css" >
		body{
			margin:50px 100px 50px 100px;
		}
		#role{
			margin-top:0;
			float:right;
		}
	</style>
</head>

<body>
<table border="0" width="100%" > 

	
<tr>
	<td colspan="3" align="center">
<!--верхня частина сторінки-->
		<p id="role">Hello,<?php echo $role?></p>
		<?php 
			include_once "inc/top.inc.php";
		?>
	</td>
</tr>

<!--Форма входу-->
<tr>
	<td align="right" colspan="3">
		<?php
			include "inc/enter_form.inc.php";
		?>
	</td>
</tr>
<?php
	if($id=='profile'){
		if(!empty($name)){
			include"inc/profile.php";
		}
		else
			echo"Please log in!";
	}
	elseif($id=='edit_profile'){
		if(!empty($name)){
			include("inc/edit_profile.php");
		}
		else
			echo"Please log in!";
	}
	elseif($id=='all_users'){
		if(!empty($name)){
			include("inc/all_users.php");
		}
		else
			echo"Please log in!";
	}
	else{
?>
<tr>
	<td width="25%"align="left" valign="top"><!--ліве меню-->
		<?php
			if($role!=="guest"){
				echo"<ul>";
				show_names($connect);
				echo"</ul>
				<a href='index.php?id=all_users'><p>All users</p></a>";
			}
		?>
	</td>
	<td align="center">
<!--основний контент-->
		<?php
			switch($id){
				case'contacts':
					include"inc/contacts.php";break;
				case'about':
					include"inc/about.php";break;
				case'news':
					include"inc/news.php";break;
				case'articles':
					include"inc/articles.php";break;
				case'registration':
					include"inc/registration.php";break;
				case'registration_form':
					include"inc/registration_form.php";break;
				case'art_form':
					if(isset($name))
						include"inc/art_form.php";
					else
						echo change_language($connect,'You have to enter',$lang);
					break;
				case'enter_error':	
					if(empty($name)){
						echo"This profile was locked or...<br>";
						echo change_language($connect,'A combination of user name and password was not found, check the data, please',$lang);
					}
					else
						show_articles($connect,$page_num);
					break;
				case'edit_form':
					include"inc/edit_form.php";break;
				case'main_art_form':
					include"inc/main_art_form.php";break;
				case'edit_pers_data':
					include"inc/edit_pers_data.php";break;
				default:
					echo show_articles($connect,$page_num);
			}
		?>
	</td>
	<td width="25%" align="center" valign="top">
	<!--праве меню-->
		<table>
			<tr>
				<td>
				<?php
					if(!empty($name) and ($role=='admin'or $role=='editor'))
						echo"<a href='index.php?id=art_form'>".change_language($connect,'Add article',$lang)."<a>";
					?>
				</td>
			</tr>
		</table>
	</td>
</tr>
<?php
		}
?>		
<tr>
	<td colspan="3" align="center" valign="bottom">
		<?php
			//include "inc/bottom.inc.php";
		?>
	</td>
</tr>
</table>

</body>
</html>