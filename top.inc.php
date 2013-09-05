<?php
	$language=array(
			"Eng"=>"eng.php",
			"Укр"=>"ukr.php",
			"Рос"=>"rus.php",
	);
	$menu=array(
		change_language($lang,'Home')=>"index.php",
		change_language($lang,'Contacts')=>"index.php?id=contacts",
		change_language($lang,'About Us')=>"index.php?id=about",
		change_language($lang,'News')=>"index.php?id=news",
		change_language($lang,'Articles')=>"index.php?id=articles"
	);
?>
<table width="100%">
	<tr>
		<td colspan="3"align="center">
			<img src="mg.gif" width="100%" />
		</td>
	</tr>
	<tr>
		<td  colspan="2"align="center">
			<?php
				if(!getMenu($menu,false,'30px'))
					echo"...".change_language($lang,'something is going wrong');
			?>
		</td>
		<td  align="center">
			<?php
				if(!getMenu($language,false))
					echo"...".change_language($lang,'something is going wrong');
			?>
		</td>
	</tr>
</table>