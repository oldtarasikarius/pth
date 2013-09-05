<form action="index.php?id=registration" method="POST">
	<table border="0"width="30%">
		<tr>
			<td align="right">
				<?=change_language($lang,'Enter your nickname')?>:
			</td>
			<td align="left">
				<input type="text" name="login" size="20">
			</td>
		</tr>
		<tr>
			<td align="right">
				<?=change_language($lang,'Enter your password')?>:
			</td>
			<td align="left">
				<input type="password" name="password" size="20">	
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" value="<?= change_language($lang,'Register')?>">
			</td>
		</tr>
	</table>
</form>