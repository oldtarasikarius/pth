<?php
if($_SESSION['role']=="authorless") {
	die(change_language($connect,"You have no rights to be here!",$lang));
}
if(isset ($_GET['link'])) {
	$link_name=clear_data($_GET['link']);
}
else {
	$link_name=$name;
}
if (isset($_SESSION['error'])) {
	echo $_SESSION['error'];
	unset($_SESSION['error']);
}

?>
<div class='change_ava_form'>
	<img src='<?php
		show_avatar($connect,$link_name);?>' alt='avatar' width=150 height=150>
	
	<form enctype='multipart/form-data' action='loadfile.php?link=<?=$link_name?>' method='post'>
		<input type='file' name='userfile' ><br>
		<input type='submit' value= "<?php echo change_language($connect,'Add',$lang); ?>" >
	</form>
</div>
			
<div class='change_info_form'>
	<form action="edit_pers_data.php?link=<?=$link_name?>" method="post">
		<p>
				<input type="text"
							name="lname"
							value="<?php show_element($connect,$link_name,'last_name');?>"
							placeholder="<?php echo change_language($connect,'Enter your last name',$lang); ?>"
				>
				<?php echo change_language($connect,'Last Name',$lang); ?>
		</p>
		<p>
			<input type="text"
						 name="fname"
						 value="<?php show_element($connect,$link_name,'first_name');?>"
						placeholder="<?php echo change_language($connect,'Enter your first name',$lang);?>"
			>
				<?php echo change_language($connect,'First Name',$lang);?>
		</p>
		<p>
			<input type="email"
						 name="email"
						 value="<?php show_element($connect,$link_name,'mail');?>"
						placeholder="<?php echo change_language($connect,'Change e-mail address',$lang); ?>"
			>
				<?php echo change_language($connect,'E-mail',$lang); ?>
		</p>
		<p>
			<input type="password"
						 name="password"
						 placeholder="<?php echo change_language($connect,'Change the password',$lang); ?>"
			>
				<?php echo change_language($connect,'Password',$lang); ?>
		</p>
		<p>
			<input type="password"
						 name="repeat_password"
						 placeholder="<?php echo change_language($connect,'Confirm new password',$lang); ?>"
			>
				<?php echo change_language($connect,'Confirm Password',$lang); ?>
		</p>
	<?php if($role=="admin"){?>
		<p>
			<input type="text"
						 name="new_role"
						 value="<?php echo show_role($connect,$link_name);?>"
						placeholder="<?php echo change_language($connect,'Enter new role for this user',$lang); ?>"
			>
			<?php echo change_language($connect,'New Role',$lang); ?>
		</p>
		<?php } ?>
		<p>
			<?php
				if (isset($_SESSION['error'])) {
					echo change_language($connect,$_SESSION['error'],$lang);
				}
			?>
		</p>
		
		<input type="Submit"
					 value="<?php echo change_language($connect,'SUBMIT',$lang); ?>"
					onclick= "return confirm('Sure ?')"
		>
		<input type="reset"
					 value="<?php echo change_language($connect,'RESET',$lang); ?>"
		>							
	</form>
</div>