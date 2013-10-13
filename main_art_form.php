<?php
if($role!="admin" and $role!="editor")
	die("You have no rights to visit this page!");
?>
<form action="add_main_art.php" method="POST">
	<table>
		<tr>
			<td width="100%">
				<textarea name="eng_art" cols="100%" rows="15%">
					On English
				</textarea>
			</td>
		<tr>
			<td width="100%">
				<textarea name="ukr_art" cols="100%" rows="15%">
					Українською
				</textarea>
			</td>
		<tr>
			<td width="100%">
				<textarea name="rus_art" cols="100%" rows="15%">
					На Русском
				</textarea>
			</td>
		<tr>
			<td align="right">
				<input type="submit" value="Add" />
			</td>
		</tr>
	</table>
</form>
