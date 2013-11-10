<?php
if(isset ($_GET['link'])) {
	$link_name=clear_data($_GET['link']);
}
else {
	$link_name=$name;
}
$role=show_role($connect,$link_name);
?>
		
<div id='prof_left_part'>
	<img src='<?=show_avatar($connect,$link_name)?>' alt='avatar' class='profile_pic'>
	<p class='log_role'><?php echo $link_name; ?></p>
	<p class='log_role'><?php echo change_language($connect,$role,$lang); ?></p>
</div>
<div class='change_info_form'>	
	<?php
		show_pers_data($connect,$link_name);
	?>

	<?php if($role=="admin"or ($name==$link_name and $role!=="authorless")){?>
		<p ><a href="index.php?id=edit_profile&amp;link=<?=$link_name?>">
			<?php echo change_language($connect,"Edit Profile",$lang); ?></a></p>
	<?php }?>
</div>