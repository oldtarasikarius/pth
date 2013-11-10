
<?php
	if(isset($_SESSION['name'])) {
		exit(change_language($connect,"You had already register!!!",$lang));
	}
	if(isset($_SESSION['error'])) {
		$error=$_SESSION['error'];
		echo "<p color='red'>".change_language($connect,$error,$lang)."!</p>";
	}
	
?>
<div id='reg_form'>
<form action="registration.php" method="POST">
	<p class='log_role'><?=change_language($connect,'Login',$lang)?>:
				<input type="text" name="login" size="20" maxlength="40" required></p>	
	<p class='log_role'><?=change_language($connect,'Password',$lang)?>:
				<input type="password" name="password" size="20" maxlength="20" required></p>		
	<p class='log_role'><?=change_language($connect,'Repeat Password',$lang)?>:
			<input type="password" name="repeat_password" size="20" maxlength="20" required></p>		
	<p class='log_role'><?=change_language($connect,'E-mail',$lang)?>:
			<input type="email" name="email" size="20" maxlength="50" required></p>	
			
	<input type="submit" value="<?= change_language($connect,'Register',$lang)?>">
			
</form>
</div>
