<?php
if($_SERVER['REQUEST_METHOD']=='GET'){
	$num=clear_data($_GET['num']);
	if(!isset($name))
		die(change_language($lang,'You have to register'));
}
?>
<form action="edit_art.php?num=<?=$num?>" method="POST">
	<table>
		<tr>
			<td width="100%">
				<textarea name="art" cols="100%" rows="15%">
				<?=get_art($num)?>
				</textarea>
			</td>
		<tr>
			<td align="right">
				<input type="submit" value="<?=change_language($lang,'Edit')?>" />
			</td>
		</tr>
	</table>
</form>
