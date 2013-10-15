<?php
//mysql_connect("localhost","root","ppp") or die(mysql_error());
//mysql_select_db('metal_gym')or die(mysql_error());

	$connect= new PDO('mysql:host=localhost;dbname=metal_gym','root','ppp');
	//$_SESSION['connect']=$connect;

//Зміна мови//////////////////////////////////////////////////////////////////////////////
function change_language($connect,$text,$lang=false){
	if(!$lang or $lang=='eng')
		return $text;
	else{
			$sql="SELECT $lang
					FROM languages
					WHERE eng='$text'";
			
			$result=$connect->query($sql);
			$row=$result->fetch(PDO::FETCH_ASSOC);
			$text= $row["$lang"];
			return $text;				
	}				
}
																
//Меню//////////////////////////////////////////////////////////////////////////
	function getMenu($menu,$vertical=TRUE){
		if(!is_array($menu))
			return false;
		$style='';
		if(!$vertical)
			$style="style='display:inline;margin-right:15px'";
		echo"<ul style='list-style-type:none'>";
			foreach($menu as $link=>$href){			
				echo"<li ".$style."><a href='".$href."'>".$link."</li>";
			}	
		echo"</ul>";
		return true;
	}
//фільтрація данних	/////////////////////////////////////////////
	function clear_data($data){
		return trim(strip_tags($data));
	}
//Вихід з профілю//////////////////////////////////////////
	function log_out(){
		unset($_SESSION['name']);
	}
//Показати статті//////////////////////////////////////////////////////////////////////////////////////////
	function show_articles($connect){
			$sql="SELECT *
					FROM articles
					ORDER BY id DESC";
			$result=$connect->query($sql);
			while($row=$result->fetch(PDO::FETCH_ASSOC)){
				$login=$row['login'];
			$art=$row['article'];
			$num=$row['id'];
			echo"From {$login}<p>{$art}</p>";
			if($_SESSION['role']=="admin" or ($_SESSION['role']=="editor"and $_SESSION['name']==$login))
				echo"<a href='index.php?id=edit_form&num={$num}'>Edit</a><br /><br /><br /><br />";
			}
	}
		
//Вибір однієї статті з бази//////////////////////////////////////////////////////////////////////////////////
	function get_art($connect,$id){
		$sql="SELECT article
				FROM articles
				WHERE id=$id";
		$result=$connect->query($sql);
		$row=$result->fetch(PDO::FETCH_ASSOC);
		$art=$row['article'];
		return $art;
	}
//Редагувати статтю//////////////////////////////////////////////////////////////////////////////////////
	function edit($connect,$id,$nart){
		$sql="UPDATE articles
				SET article='$nart'
				WHERE id=$id";
		$connect->exec($sql);
		//mysql_query($sql) or die(mysql_error);
	}
	
//Додати Статтю/////////////////////////////////////////////////////////////////////////////////////////////
	function add_art($connect,$art,$name){
		$sql="INSERT INTO articles(	article,
									login)
						VALUES(		'$art',
									'$name')";
		$connect->exec($sql);//mysql_query($sql)or die(mysql_error());
		return true;					
	}
//Вхід користувача///////////////////////////////////////////////////////////////////////////
	function enter($connect,$login,$password){
		$sql="SELECT login,password,role
				FROM people
				WHERE login='$login'
				AND password='$password'";
		$result=$connect->query($sql);		
		if($result->fetch(PDO::FETCH_ASSOC)!==FALSE){
			$row=$result->fetch(PDO::FETCH_ASSOC);
			if($row['role']!=='locked'){
				$_SESSION['name']=$login;
				header("Location:{$_SERVER['HTTP_REFERER']}");
			}
		}
		else
			header("Location:index.php?id=enter_error");
	}
	
//Реєстрація//////////////////////////////////////////////////////////////
	function registration($connect,$login,$password,$email,$lang){
		$date=date("D, d M Y H:i:s");
	//login cheking
		$sql="SELECT login,password,mail     
				FROM people
				WHERE login='{$login}'
			";
		$result=$connect->query($sql);
		$row=$result->fetch(PDO::FETCH_ASSOC);
		
		if($login==$row['login']){
			echo"<p color='red'>".change_language($connect,'A user with this name already registered, please choose another',$lang)."!</p>";
			exit();
		}
	 //mail cheking
		$sql="SELECT login,password,mail     
				FROM people
				WHERE mail='{$email}'
			";
		$result=$connect->query($sql);
		$row=$result->fetch(PDO::FETCH_ASSOC);
		
		if($email==$row['mail']){
			echo"<p color='red'>".change_language($connect,'This e-mail already registered,check again please',$lang)."!</p>";
			exit();
		}
	//add user to database
		$sql="	INSERT INTO people(
							login,password,mail,registration_date)
						VALUES(
							'$login','$password','$email','$date')";
		$connect->exec($sql);//mysql_query($sql)or die(mysql_error());
		
		$_SESSION['name']="$login";		
		echo $_SESSION['name'].", ". change_language($connect,'You have successfully registered',$lang)."...<br />
				<a href='index.php'>".change_language($connect,'Return to main page',$lang)."...</a>";
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function insert($connect,$eng,$ukr,$rus){
		$sql="INSERT INTO  main_articles(
					eng_art,ukr_art,rus_art)
				VALUES(
					'$eng','$ukr','$rus')";
		$connect->exec($sql);
	}
	
	
	function main_art($connect,$lang='eng'){
		if($lang=='eng')
			$data='eng_art';
		if($lang=='ukr')
			$data='ukr_art';
		if($lang=='rus')
			$data='rus_art';
		$sql="SELECT {$data}
				FROM main_articles
			";
		$result=$connect->query($sql);
		$row=$result->fetch(PDO::FETCH_ASSOC);
		$art=$row[$data];
		return $art;
	}
////////////////////////////////////////////////////////////////////////////////	
function insert_w($connect,$eng,$ukr,$rus){
		$sql="INSERT INTO  languages(
					eng,ukr,rus)
				VALUES(
					'$eng','$ukr','$rus')";
		$connect->exec($sql);
		echo"</br>$eng,$ukr,$rus are added";
	}	

////////////ADDED AND SHOW AVAtAR FUNCTIONs///////////////////
function add_avatar($connect,$name,$fname){
	$sql="UPDATE people
			SET avatar='$fname'
			WHERE login='$name'
				";
	$connect->exec($sql);//mysql_query("$sql") or die(mysql_error());
}

function show_avatar($connect,$name){
	$sql="SELECT avatar
			FROM people
			WHERE login='$name'
		";
	$result=$connect->query($sql);
	$row=$result->fetch(PDO::FETCH_ASSOC);
	$ava=$row['avatar'];
	if($ava==NULL)
		echo"guest1.gif";
	else
		echo $ava;
}
/////////////////////SHOW ROLE FUNCTION///////////
function show_role($connect,$name){
	$sql="SELECT role
			FROM people
			WHERE login='$name'
		";
	$result=$connect->query($sql);//mysql_query("$sql") or die(mysql_error());
	$row=$result->fetch(PDO::FETCH_ASSOC);//mysql_fetch_assoc($result)or die(mysql_error());
	$role=$row['role'];
	echo $role;
}
/////////////////////////////Added and show personal data functions/////////////////////
function edit_pers_data($connect,$name,$fname="",$lname="",$email="",$password="",$role=""){
	if(!empty($role)){
		if($role=="admin" or $role=="editor" or $role=="user" or $role=="locked" or $role=="authorless" ){
			$sql="UPDATE people
				SET role='$role'
				WHERE login='$name'";
			$connect->exec($sql);//mysql_query("$sql") or die(mysql_error());
		}
		else
			die("<a href='index.php?id=edit_profile'>Please, enter correct role-name</a>");
	}
	if(!empty($fname)){
		$sql="UPDATE people
			SET first_name='$fname'
			WHERE login='$name'
				";
	$connect->exec($sql);//mysql_query("$sql") or die(mysql_error());
	}
	if(!empty($lname)){
		$sql="UPDATE people
			SET last_name='$lname'
			WHERE login='$name'
				";
	$connect->exec($sql);//mysql_query("$sql") or die(mysql_error());
	}
	if(!empty($email)){
		$sql="UPDATE people
			SET mail='$email'
			WHERE login='$name'
				";
	$connect->exec($sql);//mysql_query("$sql") or die(mysql_error());
	}
	if(!empty($password)){
		$sql="UPDATE people
			SET password='$password'
			WHERE login='$name'
				";
	$connect->exec($sql);//mysql_query("$sql") or die(mysql_error());
	}
}
////////////show_pers_data
function show_pers_data($connect,$name){
	$sql="SELECT last_name,
					first_name,
					mail,
					last_visiting,
					registration_date
			FROM people
			WHERE login='$name'";
	$result=$connect->query($sql);//mysql_query($sql)or die(mysql_error);
	$row=$result->fetch(PDO::FETCH_ASSOC);//mysql_fetch_assoc($result) or die(mysql_error());
	echo"<table>";
	if(!empty($row['last_name']))
		echo"<tr>
				<td>Last Name: </td>
				<td>".$row['last_name']."</td>
			</tr>";
	if(!empty($row['first_name']))
		echo"<tr>
				<td>First Name: </td>
				<td>".$row['first_name']."</td>
			</tr>";
	if(!empty($row['mail'])and $_SESSION['role']=='admin')
		echo"<tr>
				<td>E-mail: </td>
				<td>".$row['mail']."</td>
			</tr>";
	if(!empty($row['last_visiting']))
		echo"<tr>
				<td>Last Visiting: </td>
				<td>".$row['last_visiting']."</td>
			</tr>";
	if(!empty($row['registration_date']))
		echo"<tr>
				<td>Registration Date: </td>
				<td>".$row['registration_date']."</td>
			</tr>";
	echo "</table>";
}
////////////last visiting
function  last_visiting($connect,$name){
	$date=date("D, d M Y H:i:s");
	$sql="UPDATE people
			SET last_visiting='$date'
			WHERE login='$name'";
	$connect->exec($sql);//mysql_query($sql)or die(mysql_error());
}
	
	////////////////////////////////////////////////////////////////////////////////////
function show_names($connect){ 			// showing users names function
	$count=0;
	$sql="SELECT COUNT(*)
			FROM people
		";
	$result=$connect->query($sql);
	 $num=$result->fetchColumn();
	$sql="SELECT  login
			FROM people
			ORDER BY login DESC";
	$result=$connect->query($sql);
	while($row=$result->fetch(PDO::FETCH_ASSOC)){		
		
		$login=$row['login'];
		echo "<li><a href='index.php?id=profile&link=".$login."'>".$login."</a></li>";
		$count++;
		IF($count==$num)
			break;		
	}
}
///////////////////////////////////////////////////////////////////
	function set_role($connect,$name){
		if($name=="")
			return $_SESSION['role']="guest";
		$sql="SELECT role
				FROM people
				WHERE login='$name'";
		$result=$connect->query($sql);//mysql_query($sql)or die(mysql_error());
		$row=$result->fetch(PDO::FETCH_ASSOC);//mysql_fetch_assoc($result)or die(mysql_error());
		$_SESSION['role']=$row['role'];
		return $_SESSION['role'];
	}
//////////////////////////////////////////////////////////////////////////
function show_users($connect){
	$count=0;
	$sql="SELECT COUNT(*)
			FROM people
		";
	$result=$connect->query($sql);
	 $num=$result->fetchColumn();
	$sql="SELECT 	login,
					role,
					last_name,
					first_name,
					mail,
					avatar,
					registration_date,
					last_visiting
			FROM people	
	";
	$result=$connect->query($sql);
	while($row=$result->fetch(PDO::FETCH_ASSOC)){
		
		if($row['avatar']==NULL)
			$ava="guest1.gif";
		else
			$ava=$row['avatar'];
		echo"<image src=".$ava." width='130' height='150' style='float:left;margin-right:20px;margin-top: 20px'>";
		echo"<ul style='list-style-type:none'><li>Login:".$row['login']."</li>";
			echo"<li>Role:".$row['role']."</li>";
			echo"<li>First Name:".$row['first_name']."</li>";
			echo"<li>Last Name:".$row['last_name']."</li>";
		if($_SESSION['role']=='admin'){
			echo"<li>E-mail:".$row['mail']."</li>";
		}
			echo"<li>Registration date:".$row['registration_date']."</li>";
			echo"<li>Last Visiting:".$row['last_visiting']."</li>";
		if($_SESSION['role']=='admin'){
			echo"<li><a href='delete_user.php?link=".$row['login']."'>Delete</a> or maybe <a href='index.php?id=edit_profile&link=".$row['login']."'>Edit</a>  </li>";
		}
			
		echo"</ul><hr>";	
		
		//else
			//echo"</ul><br><hr>";
			
			
		$count++;
		IF($count==$num)
			break;		
	}	
}
//////////////////////////////////////////////////////////////////////////////

function delete_user($connect,$name){
	$sql="DELETE 
			FROM people
			WHERE login='$name'";
	$connect->exec($sql);//mysql_query($sql)or die(mysql_error());
}

//unset($connect);
















	
	?>
