<?php
	$connect= new PDO('mysql:host=localhost;dbname=pth','root','ppp');

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
			 
	/////////////////////////////////
			/*$sql=$connect->prepare("SELECT :lang
					FROM languages
					WHERE eng= :text");
			$sql->bindParam(':lang',$lang,PDO::PARAM_STR);
			$sql->bindParam(':text',$text,PDO::PARAM_STR);
			
			$sql->execute();			
			$row=$sql->fetch(PDO::FETCH_ASSOC);
			//$text= $row["$lang"];
			print_r($row);
			//return $text;	*/ 		
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
	function show_articles($connect,$page_num,$page="main"){
			$num=10*($page_num-1);
			$sql=$connect->prepare("SELECT 	id,
							login,
							article,
							header,
							date
					FROM 	articles
					ORDER BY id DESC
					LIMIT 10
					OFFSET :num ");
			$sql->bindParam(':num',$num,PDO::PARAM_INT);
			$sql->execute();
			while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				$login=$row['login'];
				$art=$row['article'];
				$header=$row['header'];
				$date=$row['date'];
				$num=$row['id'];
				echo"<h3 id='art".$num."'><a href='index.php?id=articles&num=".$page_num."#art".$num."'>".$header."</a></h3>";
				echo"<p align='left'>From {$login}</p>";
				echo"<p align='left'>{$date}</p>";
				if($page=="articles"){
					echo"<p>".$art."</p>";
					if($_SESSION['role']=="admin" or ($_SESSION['role']=="editor"and $_SESSION['name']==$login))
					echo"<a href='index.php?id=edit_form&num={$num}'>EDIT</a>or maybe <a href='del_art.php?num={$num}'>DELETE</a><br /><br /><br /><br />";
					$qstr="index.php?id=articles&num=";
				}
				else{
					if(mb_strlen($art)>150){
						for($i=149;$i<150;$i--){
							if($art{$i}==" ")
								break;
						}
						echo"<p>".substr($art,0,$i)."<a href='index.php?id=articles&num=".$page_num."#art".$num."'> ...READ MORE</a></p>";
						echo"<br><br><br>";
					}
					else{
						echo"<p>".$art."</p>";
						echo"<br><br><br>";
					}
					$qstr="index.php?num=";
				}
			}
			
				$num=10*($page_num);
				$sql->execute();
				$row=$sql->fetch(PDO::FETCH_ASSOC);
				echo"<p>";
				if($page_num>1)
					echo"<a href='".$qstr.($page_num-1)."'>&#60;&#60;&#60;Later</a>";
				if(!empty($row))
					  echo "    <a href='".$qstr.($page_num+1)."'>Older&#62;&#62;&#62;</a></p>";
				echo"</p>";
			
	}
///////////
         function del_art($connect,$id){
			$sql=$connect->prepare("DELETE FROM articles
						WHERE id=:id");
			$sql->bindParam(':id',$id);
			$sql->execute();
		 }		
//Вибір однієї статті з бази//////////////////////////////////////////////////////////////////////////////////
	function get_art($connect,$id,$toget="art"){
		$sql=$connect->prepare("SELECT 	article,
										header
								FROM articles
								WHERE id=:id");
		$sql->bindParam(':id',$id,PDO::PARAM_INT);
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		$art=$row['article'];
		$header=$row['header'];
		if($toget=="header")
			return $header;
		else
			return $art;
	}
//Редагувати статтю//////////////////////////////////////////////////////////////////////////////////////
	function edit_art($connect,$id,$nart,$nhead){
		$sql=$connect->prepare("UPDATE articles
				SET article=:nart,
					header=:nhead
				WHERE id=:id");
		$sql->bindParam(':nart',$nart,PDO::PARAM_STR);
		$sql->bindParam(':nhead',$nhead,PDO::PARAM_STR);
		$sql->bindParam(':id',$id,PDO::PARAM_INT);
		$sql->execute();
	}
//Додати Статтю/////////////////////////////////////////////////////////////////////////////////////////////
	function add_art($connect,$art,$header,$name){
		$date=date("D, d M Y H:i:s");
		$sql=$connect->prepare('INSERT INTO articles(login,
													article,
													header,
													date)
										VALUES(		:name,
													:art,
													:header,
													:date)');
		
		$sql->bindParam(':art',$art,PDO::PARAM_STR);
		$sql->bindParam(':header',$header,PDO::PARAM_STR);
		$sql->bindParam(':date',$date,PDO::PARAM_STR);
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->execute();
		return true;					
	}
//Вхід користувача///////////////////////////////////////////////////////////////////////////
	function enter($connect,$login,$password){
		$sql=$connect->prepare("SELECT login,password,role
								FROM people
								WHERE login=:login
								AND password=:password");
		$sql->bindParam(':login',$login,PDO::PARAM_STR);
		$sql->bindParam(':password',$password,PDO::PARAM_STR);
		$sql->execute();		
		if($sql->fetch()!==FALSE){
			$row=$sql->fetch(PDO::FETCH_ASSOC);
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
		$sql=$connect->prepare("SELECT login,password,mail     
								FROM people
								WHERE login=:login");
		$sql->bindParam(':login',$login,PDO::PARAM_STR);						
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		
		if($login==$row['login']){
			echo"<p color='red'>".change_language($connect,'A user with this name already registered, please choose another',$lang)."!</p>";
			exit();
		}
	 //mail cheking
		$sql=$connect->prepare("SELECT login,password,mail     
								FROM people
								WHERE mail=:email'
							");
		$sql->bindParam(':email',$email,PDO::PARAM_STR);						
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		
		if($email==$row['mail']){
			echo"<p color='red'>".change_language($connect,'This e-mail already registered,check again please',$lang)."!</p>";
			exit();
		}
	//add user to database
		$sql=$connect->prepare("	INSERT INTO people(
												login,password,mail,registration_date)
											VALUES(
												:login,:password,:email,:date)");
		$sql->bindParam(':login',$login,PDO::PARAM_STR);
		$sql->bindParam(':password',$password,PDO::PARAM_STR);
		$sql->bindParam(':email',$email,PDO::PARAM_STR);
		$sql->bindParam(':date',$date);		
		$sql->execute();
		
		$_SESSION['name']="$login";		
		echo $_SESSION['name'].", ". change_language($connect,'You have successfully registered',$lang)."...<br />
				<a href='index.php'>".change_language($connect,'Return to main page',$lang)."...</a>";
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function insert($connect,$eng,$ukr,$rus){
		$sql=$connect->prepare("INSERT INTO  main_articles(
											eng_art,ukr_art,rus_art)
										VALUES(
											:eng,:ukr,:rus)");
		$sql->bindParam(':eng',$eng,PDO::PARAM_STR);
		$sql->bindParam(':ukr',$ukr,PDO::PARAM_STR);
		$sql->bindParam(':rus',$rus,PDO::PARAM_STR);		
		$sql->execute();
	}
	
	
	function main_art($connect,$lang='eng'){
		if($lang=='eng')
			$data='eng_art';
		if($lang=='ukr')
			$data='ukr_art';
		if($lang=='rus')
			$data='rus_art';
		$sql=$connect->prepare("SELECT :data
									FROM main_articles
								");
		$sql->bindParam(':data',$data,PDO::PARAM_STR);
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		$art=$row[$data];
		return $art;
	}
////////////////////////////////////////////////////////////////////////////////	
function insert_w($connect,$eng,$ukr,$rus){
		$sql=$connect->prepare("INSERT INTO  languages(
											eng,ukr,rus)
										VALUES(
											:eng,:ukr,:rus)");
		$sql->bindParam(':eng',$eng,PDO::PARAM_STR);
		$sql->bindParam(':ukr',$ukr,PDO::PARAM_STR);
		$sql->bindParam(':rus',$rus,PDO::PARAM_STR);
		$sql->execute();
		echo"</br>$eng,$ukr,$rus are added";
	}	

////////////ADDED AND SHOW AVAtAR FUNCTIONs///////////////////
function add_avatar($connect,$name,$fname){
	$sql=$connect->prepare("UPDATE people
							SET avatar= :fname
							WHERE login= :name
								");
	$sql->bindParam(':fname',$fname,PDO::PARAM_STR);
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->execute();
}

function show_avatar($connect,$name){
	$sql=$connect->prepare("SELECT avatar
								FROM people
								WHERE login=:name
							");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->execute();
	$row=$sql->fetch(PDO::FETCH_ASSOC);
	$ava=$row['avatar'];
	if($ava==NULL)
		echo"img/guest1.gif";
	else
		echo $ava;
}
/////////////////////SHOW ROLE FUNCTION///////////
function show_role($connect,$name){
	$sql=$connect->prepare("SELECT role
							FROM people
							WHERE login=:name
						");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->execute();
	$row=$sql->fetch(PDO::FETCH_ASSOC);
	$role=$row['role'];
	echo $role;
}
/////////////////////////////Added and show personal data functions/////////////////////
function edit_pers_data($connect,$name,$fname="",$lname="",$email="",$password="",$role=""){
	if(!empty($role)){
		if($role=="admin" or $role=="editor" or $role=="user" or $role=="locked" or $role=="authorless" ){
			$sql=$connect->prepare("UPDATE people
									SET role=:role
									WHERE login=:name");
			$sql->bindParam(':role',$role,PDO::PARAM_STR);
			$sql->bindParam(':name',$name,PDO::PARAM_STR);
			$sql->execute();
		}
		else
			die("<a href='index.php?id=edit_profile'>Please, enter correct role-name</a>");
	}
	if(!empty($fname)){
		$sql=$connect->prepare("UPDATE people
								SET first_name=:fname
								WHERE login=:name
									");
		$sql->bindParam(':fname',$fname,PDO::PARAM_STR);
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->execute();
	}
	if(!empty($lname)){
		$sql=$connect->prepare("UPDATE people
								SET last_name='$lname'
								WHERE login='$name'
									");
		$sql->bindParam(':lname',$lname,PDO::PARAM_STR);
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->execute();
	}
	if(!empty($email)){
		$sql=$connect->prepare("UPDATE people
								SET mail=:email
								WHERE login=:name
									");
		$sql->bindParam(':email',$email,PDO::PARAM_STR);
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->execute();
	}
	if(!empty($password)){
		$sql=$connect->prepare("UPDATE people
								SET password=:password
								WHERE login=:name
									");
		$sql->bindParam(':password',$password,PDO::PARAM_STR);
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->execute();
	}
}
////////////show_pers_data
function show_pers_data($connect,$name){
	$sql=$connect->prepare("SELECT last_name,
									first_name,
									mail,
									last_visiting,
									registration_date
							FROM people
							WHERE login=:name");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->execute();
	$row=$sql->fetch(PDO::FETCH_ASSOC);//mysql_fetch_assoc($result) or die(mysql_error());
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
	$sql=$connect->prepare("UPDATE people
							SET last_visiting=:date
							WHERE login=:name");
	$sql->bindParam(':date',$date);
	$sql->bindParam(':name',$name);
	$sql->execute();
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
		$sql=$connect->prepare("SELECT role
								FROM people
								WHERE login=:name");
		$sql->bindParam(':name',$name);
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);//mysql_fetch_assoc($result)or die(mysql_error());
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
			$ava="img/guest1.gif";
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
	$sql=$connect->prepare("DELETE 
							FROM people
							WHERE login=:name");
	$sql->bindParam(':name',$name);
	$sql->execute();
}



	
	?>