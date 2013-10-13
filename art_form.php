<?php
if($role!="admin" and $role!="editor")
	die('You have no rights to visit this page!');
?>
<form action="add_article.php" method="POST">
	<table>
		<tr>
			<td width="100%">
				<textarea name="art" cols="100%" rows="15%">
				</textarea>
			</td>
		<tr>
			<td align="right">
				<input type="submit" value="<?=change_language($lang,'Add')?>" />
			</td>
		</tr>
	</table>
</form>
