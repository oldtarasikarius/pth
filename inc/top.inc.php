<?php
	$language=array(
			"<img src='img/eng.png' alt='flag' class='flag'>"=>"lang/eng.php",
			"<img src='img/ukr.png' alt='flag' class='flag'>"=>"lang/ukr.php"
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
	
<a href='index.php'><img src="img/PTH.gif" alt='flag' id='main_img' /></a>
	
<div id='main_menu'>
	<?php
		if(!empty($name)){
			if(!getMenu($menu2,false))
				echo"...".change_language($connect,'something is going wrong',$lang);
		}
		else{
			if(!getMenu($menu1,false))
				echo"...".change_language($connect,'something is going wrong',$lang);
		}
	?>
</div>
<div id='lang_menu'>	
	<?php
		if(!getMenu($language,false))
			echo"...".change_language($connect,'something is going wrong',$lang);
	?>
</div>
			