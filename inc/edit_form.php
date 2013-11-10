<?php
if($_SESSION['role']!="admin" and $_SESSION['role']!="editor")
	die(change_language($connect,"you have no permission to visit this page",$lang));
if($_SERVER['REQUEST_METHOD']=='GET'){
	$num=clear_data($_GET['num']);
	if(!isset($name))
		die(change_language($connect,'You have to register',$lang));
}
?>
<form action="edit_art.php?num=<?=$num?>" method="POST"  class='art_form'>
	<h3><?php echo change_language($connect,'English version of article',$lang);?></h3>
	<input type="text" name="eng_head" value="<?php echo get_art($connect,$num,"header")?>" size="70">
		<textarea name="eng_art" cols="81" rows="15">
			<?php echo get_art($connect,$num)?>
		</textarea>
		
	<h3><?php echo change_language($connect,'Ukrainian version of article',$lang);?></h3>
	<input type="text" name="ukr_head" value="<?php echo get_art($connect,$num,"header","ukr")?>" size="70">
		<textarea name="ukr_art" cols="81" rows="15">
			<?php echo get_art($connect,$num,"art","ukr")?>
		</textarea>
		
	<input type="submit" value="<?=change_language($connect,'Edit',$lang)?>" />
</form>
