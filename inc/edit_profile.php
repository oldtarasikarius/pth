<?php
if($_SESSION['role']=="authorless")
	die("You have no rights to be here!");
if(isset ($_GET['link']))
	$link_name=clear_data($_GET['link']);
else
	$link_name=$name;	
?>
<div class='change_ava_form'>
	<image src=<?php
		show_avatar($connect,$link_name);
	?> width=150 height=150>
	
	<form enctype='multipart/form-data' action='loadfile.php?link=<?=$link_name?>' method='post'>
		<input type='file' name='userfile' ><br>
		<input type='submit' value='Add'>
	</form>
</div>
			
<div class='change_info_form'>
	<form action="index.php?id=edit_pers_data&link=<?=$link_name?>" method="post">
		<p><input type="text" name="lname" placeholder="Enter your last name">
			Last Name</p>
		<p><input type="text" name="fname" placeholder="Enter your first name">
			First Name</p>
		<p><input type="text" name="email" placeholder="Change e-mail address">
			E-mail</p>
		<p><input type="password" name="password" placeholder="Change the password">
			Password</p>
		<p><input type="password" name="repeat_password" placeholder="Confirm new password">
			Confirm Password</p>
		<?php if($role=="admin"){?>
		<p><input type="text" name="new_role" placeholder="Enter new role for this user">
			New Role</p>
		<?php } ?>
		
		<input type="Submit"  value="SUBMIT">
		<input type="reset"  value="CANCEL">							
	</form>
</div>