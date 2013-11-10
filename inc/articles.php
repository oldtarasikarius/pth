<?php
$num="";
if(isset($_GET['num'])) {
	$num=$_GET['num'];
}
$num=show_art($connect,$num);
if (isset($_SESSION['name'])) {
?>
<div id="mark">
	<?php
		if(!$mark=get_mark($connect,$name,$num)){
	?>
			<form action="add_mark.php?num=<?php echo $num; ?>" method="post" >
				<input type="radio" name='mark' value="1">
					<?php echo change_language($connect,'Awsome',$lang);?><br />
				<input type="radio" name='mark' value="2">
					<?php echo change_language($connect,'Pure Awsomeness',$lang);?><br />
				<input type="radio" name='mark' value="3">
					<?php echo change_language($connect,'So awsome, it`s just blow my mind!!!',$lang);?><br />
				<input type='submit' value='<?php echo change_language($connect,'Vote',$lang);?>'/>
			</form>
	<?php
		}
		else {
			echo "<h4>".change_language($connect,'Thanks for voting',$lang).", ".$name."</h4>";
			echo "<h4>".change_language($connect,'Your mark is',$lang).": ".$mark."</h4>";
			echo "<p>".change_language($connect,'Maybe, you`d like',$lang).
						"<a href='del_mark.php?num=".$num."'> ".change_language($connect,'to remove',$lang).
						" </a>".change_language($connect,'your mark to vote again',$lang)."?</p>";
		}
	?>
</div>

<div id='comment_form'>
	<p><?php echo change_language($connect,'You can leave your comment here',$lang);?>...  </p>
	
	<form action='add_comment.php?num=<?php echo $num?>' method='post' class='comment'>
		<input type="text" name="sub" size="70" placeholder="<?php echo change_language($connect,'Subject',$lang);?>"/>
		<textarea name='comment' cols='70' rows='10' required >			
		</textarea>
		<br />
		<input type='submit' value='<?php echo change_language($connect,'SUBMIT',$lang);?>' />
	</form>
</div>
<div id="comments">
<?php
}
if (isset($_SESSION['error'])) {
	echo "<p  id='error'>".change_language($connect,$_SESSION['error'],$lang)."</p>";
	unset($_SESSION['error']);
}
$c_page=1;
if(isset($_GET['c_page'])) {
	$c_page=$_GET['c_page'];
}
show_comments($connect,$num,$lang,$c_page);
?>
</div>