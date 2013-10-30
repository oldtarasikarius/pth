
<?php
	if(isset($_SESSION['name']))
		exit("You had already register!!!");
		
?>
<form action="index.php?id=registration" method="POST">
	<table border="0"width="30%">
		<tr>
			<td align="right">
				<?=change_language($connect,'Login',$lang)?>:
			</td>
			<td align="left">
				<input type="text" name="login" size="20">
			</td>
		</tr>
		<tr>
			<td align="right">
				<?=change_language($connect,'Password',$lang)?>:
			</td>
			<td align="left">
				<input type="password" name="password" size="20">	
			</td>
		</tr>
		<tr>
			<td align="right">
				<?=change_language($connect,'Repeat Password',$lang)?>:
			</td>
			<td align="left">
				<input type="password" name="repeat_password" size="20">	
			</td>
		</tr>
		<tr>
			<td align="right">
				<?=change_language($connect,'E-mail',$lang)?>:
			</td>
			<td align="left">
				<input type="text" name="email" size="20">	
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" value="<?= change_language($connect,'Register',$lang)?>">
			</td>
		</tr>
	</table>
</form>