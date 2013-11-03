<?php
if($role!="admin" and $role!="editor")
	die('You have no rights to visit this page!');
?>
<form action="add_article.php" method="POST"  class='art_form'>
	<input type="text" name="header" placeholder="Article header" size="90%">
	<textarea name="art" cols="81" rows="15">
	</textarea>
	<input type="submit" value="<?=change_language($connect,'Add',$lang)?>" />
</form>
