<?php
	$language=array(
			"Eng"=>"eng.php",
			"Укр"=>"ukr.php",
			"Рос"=>"rus.php"
	);
	$menu1=array(
		change_language($lang,'Home')=>"index.php",
		change_language($lang,'Contacts')=>"index.php?id=contacts",
		change_language($lang,'About Us')=>"index.php?id=about",
		change_language($lang,'News')=>"index.php?id=news",
		change_language($lang,'Articles')=>"index.php?id=articles",
		change_language($lang,'Registration')=>"index.php?id=registration_form"
	);
	$menu2=array(
		change_language($lang,'Home')=>"index.php",
		change_language($lang,'Contacts')=>"index.php?id=contacts",
		change_language($lang,'About Us')=>"index.php?id=about",
		change_language($lang,'News')=>"index.php?id=news",
		change_language($lang,'Articles')=>"index.php?id=articles",
		change_language($lang,'Exit')=>"exit.php"
	);
?>

<table border="0" width="50%">
	<tr>
		<td colspan="3"align="center">
			<img src="mg.gif" width="90%" />
		</td>
	</tr>
	<tr>
		<td  colspan="2">
			<?php
				if(!empty($name)){
					if(!getMenu($menu2,false,'30px'))
						echo"...".change_language($lang,'something is going wrong');
				}
				else{
					if(!getMenu($menu1,false,'30px'))
						echo"...".change_language($lang,'something is going wrong');
				}
			?>
		</td>
		<td  >
			<?php
				if(!getMenu($language,false))
					echo"...".change_language($lang,'something is going wrong');
			?>
		</td>
	</tr>
</table>
