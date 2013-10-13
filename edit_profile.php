<?php
if($_SESSION['role']=="authorless")
	die("You have no rights to be here!");
if(isset ($_GET['link']))
	$link_name=clear_data($_GET['link']);
else
	$link_name=$name;
	
?>
		<tr>
			<td width="20%"></td>
			<td align="left" width="15%">
				<ul style='list-style-type:none' >
						<li><image src=<?php
											show_avatar($link_name);
										?> width=150 height=150>
						</li>
						<li>
							<form enctype='multipart/form-data' action='loadfile.php?link=<?=$link_name?>' method='post'>
							<input type='file' name='userfile' ><br>
							<input type='submit' value='Add'>
							</form>
						</li>
					</ul>
			</td>
			<td align="left">
				<table>
					<form action="index.php?id=edit_pers_data&link=<?=$link_name?>" method="post">
						<tr>
							<td><input type="text" name="lname" placeholder="Enter your last name"></td>
							<td>Last Name</td>
						</tr>	
						<tr>
							<td><input type="text" name="fname" placeholder="Enter your first name"></td>
							<td>First Name</td>
						</tr>
						<tr>
							<td><input type="text" name="email" placeholder="Change e-mail address"></td>
							<td>E-mail</td>
						</tr>
						<tr>
							<td><input type="password" name="password" placeholder="Change the password"></td>
							<td>Password</td>
						</tr>
						<tr>
							<td><input type="password" name="repeat_password" placeholder="Confirm new password"></td>
							<td>Confirm Password</td>
						</tr>
						<?php if($role=="admin"){?>
						<tr>
							<td><input type="text" name="new_role" placeholder="Enter new role for this user"></td>
							<td>New Role</td>
						</tr><?php } ?>
						<tr>
							<td  ><input type="Submit"  value="SUBMIT"></td>
							<td ><input type="reset"  value="CANCEL"></td>							
						</tr>
					</form>
				</table>
			</td>
			<td width="20%"></td>
		</tr>