<?php
if($_SESSION['role']!="admin" and $_SESSION['role']!="editor")
	die(" You have no rights to visit this page!");
if($_SERVER['REQUEST_METHOD']=='GET'){
	$num=clear_data($_GET['num']);
	if(!isset($name))
		die(change_language($connect,'You have to register',$lang));
}
?>
<form action="edit_art.php?num=<?=$num?>" method="POST">
	<table>
		<tr>
			<td width="100%">
				<textarea name="art" cols="100%" rows="15%">
				<?=get_art($connect,$num)?>
				</textarea>
			</td>
		<tr>
			<td align="right">
				<input type="submit" value="<?=change_language($connect,'Edit',$lang)?>" />
			</td>
		</tr>
	</table>
</form>
