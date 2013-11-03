<?php
if($_SESSION['role']!="admin" and $_SESSION['role']!="editor")
	die(" You have no rights to visit this page!");
if($_SERVER['REQUEST_METHOD']=='GET'){
	$num=clear_data($_GET['num']);
	if(!isset($name))
		die(change_language($connect,'You have to register',$lang));
}
?>
<form action="edit_art.php?num=<?=$num?>" method="POST"  class='art_form'>
	<input type="text" name="header" value="<?php echo get_art($connect,$num,"header")?>" size="90%">
		<textarea name="art" cols="81" rows="15">
			<?php echo get_art($connect,$num)?>
		</textarea>
	<input type="submit" value="<?=change_language($connect,'Edit',$lang)?>" />
</form>
