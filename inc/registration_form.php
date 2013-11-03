
<?php
	if(isset($_SESSION['name']))
		exit("You had already register!!!");
		
?>
<div id='reg_form'>
<form action="index.php?id=registration" method="POST">
	<p class='log_role'><?=change_language($connect,'Login',$lang)?>:
				<input type="text" name="login" size="20"></p>	
	<p class='log_role'><?=change_language($connect,'Password',$lang)?>:
				<input type="password" name="password" size="20"></p>		
	<p class='log_role'><?=change_language($connect,'Repeat Password',$lang)?>:
			<input type="password" name="repeat_password" size="20"></p>		
	<p class='log_role'><?=change_language($connect,'E-mail',$lang)?>:
			<input type="text" name="email" size="20"></p>	
			
	<input type="submit" value="<?= change_language($connect,'Register',$lang)?>">
			
</form>
</div>