<form name="enterForm" action="enter.php"  method="POST" onsubmit="return validate()">
	<table>
		<tr>
		<?php if(!empty($name)){		
			echo "<td>".change_language($lang,'Hello').",".$name."!!!</td>";
		?>
			<td>
				<a href="exit.php"><?=change_language($lang,'Exit');?></a>
			</td>
		<?php 
			}else{
		?>
			<td align="left">
				<a href="index.php?id=registration_form"><?=change_language($lang,'Registration')?>...</a>
			</td>
			<td>
				<input type="text" size="20" maxlength="20" name="login" value="<?=change_language($lang,'Login')?>" />
			</td>
			<td>
				<input type="password" size="20" maxlength="20" name="password" value="pass" />
			</td>
			<td>
				<input type="submit" value="<?=change_language($lang,'Enter')?>" />
			</td>	
		<?php
		}?>
		</tr>
	</table>
</form>