<?php 
	if(!empty($name)){	
?>
	<div id='user'>
	<img src='<?=show_avatar($connect,$name)?>' alt='avatar' class="ava">
	<br /><a href='index.php?id=profile'><?=$name?></a> 
	</div>
<?php	
	}
	else{
?>
<form name="enterForm" action="enter.php"  method="POST" id="form" >
	<input type="text"  maxlength="20" name="login" placeholder="<?=change_language($connect,'Login',$lang)?>" />
	<input type="password"  maxlength="20" name="password" placeholder="<?=change_language($connect,'Password',$lang)?>" />
	<input type="submit" value="<?=change_language($connect,'Enter',$lang)?>" />
</form>		
<?php
	}?>

		
	
