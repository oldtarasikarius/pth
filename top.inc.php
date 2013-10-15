<?php
	$language=array(
			"Eng"=>"eng.php",
			"Укр"=>"ukr.php",
			"Рос"=>"rus.php"
	);
	$menu1=array(
		change_language($connect,'Home',$lang)=>"index.php",
		change_language($connect,'Contacts',$lang)=>"index.php?id=contacts",
		change_language($connect,'About Us',$lang)=>"index.php?id=about",
		change_language($connect,'News',$lang)=>"index.php?id=news",
		change_language($connect,'Articles',$lang)=>"index.php?id=articles",
		change_language($connect,'Registration',$lang)=>"index.php?id=registration_form"
	);
	$menu2=array(
		change_language($connect,'Home',$lang)=>"index.php",
		change_language($connect,'Contacts',$lang)=>"index.php?id=contacts",
		change_language($connect,'About Us',$lang)=>"index.php?id=about",
		change_language($connect,'News',$lang)=>"index.php?id=news",
		change_language($connect,'Articles',$lang)=>"index.php?id=articles",
		change_language($connect,'Exit',$lang)=>"exit.php"
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
						echo"...".change_language($connect,'something is going wrong',$lang);
				}
				else{
					if(!getMenu($menu1,false,'30px'))
						echo"...".change_language($connect,'something is going wrong',$lang);
				}
			?>
		</td>
		<td  >
			<?php
				if(!getMenu($language,false))
					echo"...".change_language($connect,'something is going wrong',$lang);
			?>
		</td>
	</tr>
</table>
