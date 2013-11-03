<?php
if(isset ($_GET['link']))
	$link_name=clear_data($_GET['link']);
else
	$link_name=$name;
	
?>
		
<div id='prof_left_part'>
	<image src=<?=show_avatar($connect,$link_name)?> class='profile_pic'>
	<p class='log_role'><?=$link_name?></p>
	<p class='log_role'><?=show_role($connect,$link_name)?></p>
</div>
<div class='change_info_form'>	
	<?php
		show_pers_data($connect,$link_name);
	?>

	<?php if($role=="admin"or ($name==$link_name and $role!=="authorless")){?>
		<p ><a href="index.php?id=edit_profile&link=<?=$link_name?>">Edit Profile</a></p>
	<?php }?>
</div>