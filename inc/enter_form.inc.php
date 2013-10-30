<form name="enterForm" action="enter.php"  method="POST" >
	<table >
		
		<?php 
			if(!empty($name)){	
		?>
			<tr><td aligne='center'><image src=<?=show_avatar($connect,$name)?> width=100 height=100></td></tr>
			<tr><td aligne='center'><a href='index.php?id=profile'><?=$name?></a></td></tr> 
		<?php	
			}
			else{
		?>
		<tr>
			<td >
				<input type="text"  maxlength="20" name="login" placeholder="<?=change_language($connect,'Login',$lang)?>" />
			</td>
			<td align="left" valign="top">
				<input type="password"  maxlength="20" name="password" placeholder="<?=change_language($connect,'Password',$lang)?>" />
			</td>
			<td >
				<input type="submit" value="<?=change_language($connect,'Enter',$lang)?>" />
			</td>	
		<?php
		}?>
		</tr>
	</table>
</form>