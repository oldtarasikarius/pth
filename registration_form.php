
<?php
	if(isset($_SESSION['name']))
		exit("You had already register!!!");
		
?>
<form action="index.php?id=registration" method="POST">
	<table border="0"width="30%">
		<tr>
			<td align="right">
				<?=change_language($lang,'Login')?>:
			</td>
			<td align="left">
				<input type="text" name="login" size="20">
			</td>
		</tr>
		<tr>
			<td align="right">
				<?=change_language($lang,'Password')?>:
			</td>
			<td align="left">
				<input type="password" name="password" size="20">	
			</td>
		</tr>
		<tr>
			<td align="right">
				<?=change_language($lang,'Repeat Password')?>:
			</td>
			<td align="left">
				<input type="password" name="repeat_password" size="20">	
			</td>
		</tr>
		<tr>
			<td align="right">
				<?=change_language($lang,'E-mail')?>:
			</td>
			<td align="left">
				<input type="text" name="email" size="20">	
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" value="<?= change_language($lang,'Register')?>">
			</td>
		</tr>
	</table>
</form>