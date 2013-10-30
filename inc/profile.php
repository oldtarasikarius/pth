<?php
if(isset ($_GET['link']))
	$link_name=clear_data($_GET['link']);
else
	$link_name=$name;
	
?>
		<tr>
			<td width="20%"></td>
			<td align="left" width="15%">
				<ul style='list-style-type:none' >
						<li><image src=<?=show_avatar($connect,$link_name)?> width=150 height=150></li>
						<li><?=$link_name?></li>
						<li><?=show_role($connect,$link_name)?></li>
				</ul>
			</td>
			<td align="left">
				<?php
				show_pers_data($connect,$link_name);
				?>
				
			</td>
			<td width="20%"></td>
		</tr>
		<?php if($role=="admin"or ($name==$link_name and $role!=="authorless")){?>
		<tr>
			<td colspan='3' align="center">
				<a href="index.php?id=edit_profile&link=<?=$link_name?>">Edit Profile</a>
			</td>	
		</tr>
		<?php }?>