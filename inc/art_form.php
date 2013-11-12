<?php
if($role!="admin" and $role!="editor")
	die('You have no rights to visit this page!');
?>
<form action="add_article.php" method="POST"  class='art_form'>
	<h3><?php echo change_language($connect,'English version of article',$lang)?></h3>
	<input type="text" name="eng_head" placeholder="<?php echo change_language($connect,'English article header',$lang)?>" size="80" required>
	<textarea name="eng_art" cols="81" rows="15" required>
	</textarea>
	
	<h3><?php echo change_language($connect,'Ukrainian version of article',$lang)?></h3>
	<input type="text" name="ukr_head" placeholder="<?php echo change_language($connect,'Ukrainian article header',$lang)?>" size="80" required>
	<textarea name="ukr_art" cols="81" rows="15"  required>
	</textarea>
	
	<input type="submit" value="<?php echo change_language($connect,'Add',$lang)?>" />
</form>
