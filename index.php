<?php
session_start();
$name="";
if(isset($_SESSION['name']))
	$name=$_SESSION['name'];
$lang="eng";
if(isset($_SESSION['lang']))
	$lang=$_SESSION['lang'];
$id="";
if(isset($_GET['id']))
	$id=$_GET['id'];
	
require"lib.inc.php";
?>

<!DOCTYPE html>

<html>
<head>
	<title>Metal Gym</title>
	<meta charset=windows-1251" />
	<style type="text/css">
		body{ 
			margin:50px 100px 50px 100px;
			}
	</style>
</head>

<body>
<table border="0" width="100%" > 

	
<tr>
	<td colspan="3" align="center">
<!--верхня частина сторінки-->
		<?php 
			include_once "top.inc.php";
		?>
	</td>
</tr>
<?php
	if($id=='profile'){
		if(!empty($name)){
			include("profile.php");
		}
		else
			echo"Please log in!";
	}
	elseif($id=='edit_profile'){
		if(!empty($name)){
			include("edit_profile.php");
		}
		else
			echo"Please log in!";
	}
	else{
?>
<!--Форма входу-->
<tr>
	<td align="right" colspan="3">
		<?php
			include "enter_form.inc.php";
		?>
	</td>
</tr>
	<!--ліве меню-->
<tr>
	<td width="25%"align="center">
		
	</td>
	<td align="center">
<!--основний контент-->
		<?php
			switch($id){
				case'contacts':
					include"contacts.php";break;
				case'about':
					include"about.php";break;
				case'news':
					include"news.php";break;
				case'articles':
					include"articles.php";break;
				case'registration':
					include"registration.php";break;
				case'registration_form':
					include"registration_form.php";break;
				case'art_form':
					if(isset($name))
						include"art_form.php";
					else
						echo change_language($lang,'You have to enter');
					break;
				case'enter_error':	
					if(empty($name))
						echo change_language($lang,'A combination of user name and password was not found, check the data, please');
					else
						echo main_art($lang);
					break;
				case'edit_form':
					include"edit_form.php";break;
				case'main_art_form':
					include"main_art_form.php";break;
				case'edit_pers_data':
					include"edit_pers_data.php";break;
				default:
					echo main_art($lang);
			}
		?>
	</td>
	<td width="25%" align="center" valign="top">
	<!--праве меню-->
		<table>
			<tr>
				<td>
					<?php
						switch($id){
							case'articles':
								if(!empty($name))
									echo"<a href='index.php?id=art_form'>".change_language($lang,'Add article')."<a>";break;
						}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
						if($name == 'admin') {
							echo"<a href='index.php?id=main_art_form'>Add  Main Article</a>";
						}
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
			//include "bottom.inc.php";
		?>
	</td>
</tr>
</table>

</body>
</html>