<script src="js/reg_form.js"></script>
<?php
	if(isset($_SESSION['name'])) {
		exit(change_language($connect,"You had already register!!!",$lang));
	}
	if(isset($_SESSION['error'])) {
		$error=$_SESSION['error'];
		echo "<p color='red'>".change_language($connect,$error,$lang)."!</p>";
		unset($_SESSION['error']);
	}
	
?>
<div id='reg_form'>
<form action="registration.php" name="reg_form" method="POST" onsubmit="return regVal()" >
	<div class='field_name'><?=change_language($connect,'Login',$lang)?>:</div>
	<p><input  type="text" name="login" size="20" maxlength="40" onblur="fieldValidation(this.value,'login')" required>	
			<span class='field_mess' id="loginVal"></span>
	</p>
	<div class='field_name'><?=change_language($connect,'Password',$lang)?>:</div>
	<p><input  type="password" name="password" size="20" maxlength="20" onblur="fieldValidation(this.value,'pass')"  required>
			<span class='field_mess' id="passVal"></span>
	</p>		
	<div class='field_name'><?=change_language($connect,'Repeat Password',$lang)?>:</div>
	<p><input  type="password" name="repeat_password" size="20" maxlength="20" onblur="fieldValidation(this.value,'conf_pass')" required>
			<span class='field_mess' id="conf_passVal"></span>
	</p>		
	<div class='field_name'><?=change_language($connect,'E-mail',$lang)?>:</div>
	<p><input  type="email" name="email" size="20" maxlength="50" onblur="fieldValidation(this.value,'mail')" required>
			<span class='field_mess' id="mailVal"></span>
	</p>	
			
	<input type="submit" value="<?= change_language($connect,'Register',$lang)?>"-->
			
</form>
</div>
