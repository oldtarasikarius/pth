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
		 if(!empty($row["$lang"]))
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
				echo"<li ".$style."><a href='".$href."'>".$link."</a></li>";
			}	
		echo"</ul>";
		return true;
	}
//фільтрація данних	/////////////////////////////////////////////
	function clear_data($data){
		return trim(strip_tags(htmlentities($data)));
	}
//Вихід з профілю//////////////////////////////////////////
	function log_out(){
		unset($_SESSION['name']);
	}
//Показати статті//////////////////////////////////////////////////////////////////////////////////////////

function show_articles($connect,$page_num){
	$num=10*($page_num-1);
	$lang="eng";
	if(isset($_SESSION['lang'])){
		$lang=$_SESSION['lang'];
	}
	$sql=$connect->prepare("SELECT 	id,
																	login,
																	{$lang}_art,
																	{$lang}_head,
																	date
													FROM 	articles
													ORDER BY id DESC
													LIMIT 10
													OFFSET :num ");
	$sql->bindParam(':num',$num,PDO::PARAM_INT);
	$sql->execute();
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$login=$row['login'];
		$art=$row[$lang.'_art'];
		$header=$row[$lang.'_head'];
		$date=$row['date'];
		$num=$row['id'];
		echo"<h3><a href='index.php?id=articles&amp;num=".$num."'>".$header."</a></h3>";
		echo"<p >".change_language($connect,'From',$lang).": {$login}</p>";
		echo"<p >{$date}</p>";
				
		if(mb_strlen($art)>150){
			for($i=149;$i>0;$i--){
				if($art{$i}==" ")
					break;
			}
			echo"<p>".substr($art,0,$i)."<a href='index.php?id=articles&amp;num=".$num."'>".change_language($connect,'...READ MORE',$lang)."</a></p>";
			echo"<br><br><br>";
		}
		else{
			echo"<p>".$art."</p>";
			echo"<br><br><br>";
		}
	}
			
		$num=10*($page_num);
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		echo"<p>";
		if($page_num>1)
			echo"<a href='index.php?num=".($page_num-1)."'>&#60;&#60;&#60;".change_language($connect,'Later',$lang)."</a>";
		if(!empty($row))
			  echo " <a href='index.php?num=".($page_num+1)."'>".change_language($connect,'Older',$lang)."&#62;&#62;&#62;</a>";
		echo"</p>";
			
	}
//////////////////////////oNE FULL ARTICLE//////////////////
function rating($connect,$num){
	$lang="eng";
  if(isset($_SESSION['lang']))
		$lang=$_SESSION['lang'];
	$sql=$connect->prepare("SELECT mark
													FROM 	art_rating");
	$sql->execute();
	$row=$sql->fetch(PDO::FETCH_NUM);
	if (!empty($row)){
		$quan=count($row);
		$sum=array_sum($row);
		$rating=$sum/$quan;
		echo change_language($connect,'Rating',$lang).": {$rating}\t\t\t\t\t".change_language($connect,'Votes',$lang).": {$quan}";
		if ($_SESSION['role']=='admin') {
			echo "\t\t\t\t\t<a href='del_rate_result.php?num=".$num."'>".change_language($connect,'Delete all results',$lang)."</a>";	
		}
	}
	else {
		echo change_language($connect,'Rating',$lang).": 0, ". change_language($connect,'No one has estimate this article yet',$lang);
	}
	
}
////////
function del_rating($connect,$num){
	$sql=$connect->prepare("DELETE FROM art_rating
																WHERE art_num=:num");
	$sql->bindParam(':num',$num);
	$sql->execute();
	return true;
}
////
function show_art($connect,$num=""){
	$lang="eng";
  if(isset($_SESSION['lang']))
		$lang=$_SESSION['lang'];
	if($num==""){
    $sql=$connect->prepare("SELECT 	id,
																		login,
																		{$lang}_art,
																		{$lang}_head,
																		date
															FROM 	articles
															ORDER BY id DESC
															LIMIT 1");
  }
	else{
    $sql=$connect->prepare("SELECT 			id,
																				login,
																				{$lang}_art,
																				{$lang}_head,
																				date
																FROM 	articles
																WHERE id=:num ");			
			$sql->bindParam(':num',$num,PDO::PARAM_INT);
  }	
			$sql->execute();
			$row=$sql->fetch(PDO::FETCH_ASSOC);
			
			$login=$row['login'];
			$art=$row[$lang.'_art'];
			$header=$row[$lang.'_head'];
			$date=$row['date'];
			$num=$row['id'];
			echo"<h3><a href='index.php?id=articles&amp;num=".$num."'>".$header."</a></h3>";
			echo "<p>";
				rating($connect,$num);
			echo "</p>";
			echo"<p >".change_language($connect,'From',$lang).": {$login}</p>";
			echo"<p >{$date}</p>";
			echo"<p>".$art."</p>";
			if($_SESSION['role']=="admin" or ($_SESSION['role']=="editor"and $_SESSION['name']==$login)){
					echo"<a href='index.php?id=edit_form&amp;num={$num}'>";
					echo change_language($connect,'Edit',$lang);
					echo " </a>".change_language($connect,'or maybe',$lang);
					echo "<a href='del_art.php?num={$num}' onclick=\"return confirm('Sure ?')\">".change_language($connect,'Delete',$lang).'</a>';
			}
		return $num;
}

///////////
         function del_art($connect,$id){
			$sql=$connect->prepare("DELETE FROM articles
						WHERE id=:id");
			$sql->bindParam(':id',$id);
			$sql->execute();
			$sql=$connect->prepare("DELETE FROM comments
																		WHERE art_num=:id");
			$sql->bindParam(':id',$id);
			$sql->execute();
		 }
		 
//Вибір однієї статті з бази//////////////////////////////////////////////////////////////////////////////////
	function get_art($connect,$id,$toget="art",$lang="eng"){
		if($lang=="eng"){
			$sql=$connect->prepare("SELECT 	eng_art,
																			eng_head
																	FROM articles
																	WHERE id=:id");			
		}
		elseif($lang=="ukr"){
			$sql=$connect->prepare("SELECT 	ukr_art,
																			ukr_head
																	FROM articles
																	WHERE id=:id");
		}
			$sql->bindParam(':id',$id,PDO::PARAM_INT);
			$sql->execute();
			$row=$sql->fetch(PDO::FETCH_ASSOC);
			$art=$row[$lang."_art"];
			$header=$row[$lang."_head"];			
		if($toget=="header")
			return $header;
		else
			return $art;
	}
//Редагувати статтю//////////////////////////////////////////////////////////////////////////////////////
	function edit_art($connect,$id,$n_eng_art,$n_ukr_art,$n_eng_head,$n_ukr_head){
		$sql=$connect->prepare("UPDATE articles
																SET eng_art=:n_eng_art,
																		ukr_art=:n_ukr_art,
																		eng_head=:n_eng_head,
																		ukr_head=:n_ukr_head
																WHERE id=:id");
		$sql->bindParam(':n_eng_art',$n_eng_art,PDO::PARAM_STR);
		$sql->bindParam(':n_ukr_art',$n_ukr_art,PDO::PARAM_STR);
		$sql->bindParam(':n_eng_head',$n_eng_head,PDO::PARAM_STR);
		$sql->bindParam(':n_ukr_head',$n_ukr_head,PDO::PARAM_STR);
		$sql->bindParam(':id',$id,PDO::PARAM_INT);
		$sql->execute();
	}
//Додати Статтю/////////////////////////////////////////////////////////////////////////////////////////////
	function add_art($connect,$eng_art,$ukr_art,$eng_head,$ukr_head,$name){
		$date=date("Y-m-d H:i:s");
		$sql=$connect->prepare('INSERT INTO articles(login,
																						eng_art,
																						ukr_art,
																						eng_head,
																						ukr_head,
																						date)
																			VALUES(		:name,
																						:eng_art,
																						:ukr_art,
																						:eng_head,
																						:ukr_head,
																						:date)');
		
		$sql->bindParam(':eng_art',$eng_art,PDO::PARAM_STR);
		$sql->bindParam(':ukr_art',$ukr_art,PDO::PARAM_STR);
		$sql->bindParam(':eng_head',$eng_head,PDO::PARAM_STR);
		$sql->bindParam(':ukr_head',$ukr_head,PDO::PARAM_STR);
		$sql->bindParam(':date',$date,PDO::PARAM_STR);
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->execute();
		return true;					
	}
//////////////////////////////////COMMENTS////////////////////////////////////////////
function add_comment($connect,$name,$sub,$comment,$num,$lang){
  $date=date("Y-m-d H:i:s");
	$sql=$connect->prepare("INSERT INTO comments( language,
                                                login,
                                                art_num,
                                                subject,
                                                comment,
                                                date)
                                      VALUES(   :lang,
                                                :name,
                                                :num,
                                                :sub,
                                                :comment,
                                                :date)");
  $sql->bindParam(':lang',$lang);
  $sql->bindParam(':name',$name);
  $sql->bindParam(':num',$num);
  $sql->bindParam(':sub',$sub);
  $sql->bindParam(':comment',$comment);
  $sql->bindParam(':date',$date);
  $sql->execute();  
	return true;
  
}
function show_comments($connect,$num,$lang,$c_page){
	$count=10*($c_page-1);
  $sql=$connect->prepare("SELECT 	id,
                                  login,
                                  subject,
                                  comment,
                                  date
                           FROM 	comments
													 WHERE 	language=:lang
													 AND 		art_num=:num
													 ORDER BY id DESC
													 LIMIT 10
													 OFFSET :count");
	$sql->bindParam(':lang',$lang);
	$sql->bindParam(':num',$num);
	$sql->bindParam(':count',$count,PDO::PARAM_INT);
  $sql->execute();
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$name=$row['login'];
		$sub=$row['subject'];
		$com=$row['comment'];
		$date=$row['date'];
		$com_id=$row['id'];
		echo"<div id='comment'>{$date}, <a href='index.php?id=profile&amp;link_name={$name}'>{$name}</a> ".change_language($connect,'wrote about',$lang)." ";
		if ($sub!=="") {
			echo "<i>{$sub}</i>";
		}
		else{
			if(mb_strlen($com)>15){
				for($i=15;$i>0;$i--){
					if($com{$i}==" "){
						break;
					}
				}
				echo"<i>".substr($com,0,$i)."</i>";
			}
			else{
				echo"<i>{$com}</i>";
			}
		}
		echo"<p>{$com}</p>";
		if ($_SESSION['role']=='admin') {
			echo "<a href='del_com.php?&amp;num={$num}&amp;com_id={$com_id}' onclick=\"return confirm('Sure ?')\">".change_language($connect,'Delete',$lang)."</a>";		
		}
		echo"<hr/></div>";
	}
	$count=10*($c_page);
  $sql->execute();
	$row=$sql->fetch();
	echo"<p>";
		if($c_page>1)
			echo"<a href='index.php?id=articles&amp;num={$num}&amp;c_page=".($c_page-1)."#comment_form'>&#60;&#60;&#60;".change_language($connect,'Later',$lang)."</a>";
		if(!empty($row))
			  echo " <a href='index.php?id=articles&amp;num={$num}&amp;c_page=".($c_page+1)."#comment_form'>".change_language($connect,'Older',$lang)."&#62;&#62;&#62;</a>";
		echo"</p>";	
}
///////////////////////////////
function del_comment($connect,$com_id){
	$sql=$connect->prepare("DELETE FROM comments
																WHERE id=:com_id");
	$sql->bindParam(':com_id',$com_id);
	$sql->execute();
}
//////////////////////////////////////////MARKS//////////////////////////////////////////////
function add_mark($connect,$num,$name,$mark){
	$sql=$connect->prepare("INSERT INTO art_rating(	login,
																									art_num,
																									mark)
																					VALUES(	:name,
																									:num,
																									:mark)");
	$sql->bindParam(':name',$name);
	$sql->bindParam(':num',$num);
	$sql->bindParam(':mark',$mark,PDO::PARAM_INT);
	$sql->execute();
	return true;
}
///////////////////
function get_mark($connect,$name,$num){
	$sql=$connect->prepare("SELECT mark
													FROM 	art_rating
													WHERE art_num=:num
													AND		login=:name");
	$sql->bindParam(':num',$num);
	$sql->bindParam('name',$name);
	$sql->execute();
	$row=$sql->fetch(PDO::FETCH_ASSOC);
	if(empty($row)) {
		return false;
	}
	return $mark=$row['mark'];
}
/////////////////////////////////
function del_mark($connect,$name){
	$sql=$connect->prepare("DELETE FROM art_rating
																WHERE login=:name");
	$sql->bindParam(':name',$name);
	$sql->execute();
	return true;
}
/////////////
function user_init($connect,$name,$date){
	$sql=$connect->prepare("SELECT 	login
						FROM 	people
						WHERE 	login=:name
						AND 	registration_date=:date");
	$sql->bindParam(':name',$name);
	$sql->bindParam(':date',$date);
	$sql->execute();
	$row=$sql->fetch();
	if (!empty($row)) {
		return TRUE;
	}
	else{
		return false;
	}
  }
//Вхід користувача///////////////////////////////////////////////////////////////////////////
	function enter($connect,$login,$password){
		$sql=$connect->prepare("SELECT 	login,
										password,
										role,
										registration_date
								FROM 	people
								WHERE 	login=:login
								AND 	password=:password");
		$sql->bindParam(':login',$login,PDO::PARAM_STR);
		$sql->bindParam(':password',$password,PDO::PARAM_STR);
		$sql->execute();		
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)){
			if($row['role']!=='locked'){
				$_SESSION['name']=$login;
				$_SESSION['date']=$row['registration_date'];
				header("Location:{$_SERVER['HTTP_REFERER']}");
			}
		}
		else
			header("Location:index.php?id=enter_error");
	}
	
//Реєстрація//////////////////////////////////////////////////////////////
	function registration($connect,$login,$password,$email,$lang){
		$date=date("Y-m-d H:i:s");
	//login cheking
		$sql=$connect->prepare("SELECT login     
								FROM people
								WHERE login=:login");
		$sql->bindParam(':login',$login,PDO::PARAM_STR);						
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		
		if(!empty($row['login'])){
			return $_SESSION['error']="A user with this name already registered, please choose another";
			die();
		}
	 //mail cheking
		$sql=$connect->prepare("SELECT mail     
								FROM people
								WHERE mail=:email
							");
		$sql->bindParam(':email',$email,PDO::PARAM_STR);						
		$sql->execute();
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		
		if(!empty($row['mail'])){
			return $_SESSION['error']="This e-mail already registered,check again please";
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
		$_SESSION['date']=$date;
		return true;
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
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	$art = $row[$data];
	return $art;
}

////////////////////////////////////////////////////////////////////////////////	WORDS AND TRANSLATIONS/////////////////
function insert_w($connect,$eng,$ukr=''){
		$sql=$connect->prepare("INSERT INTO  languages(
																							eng,ukr)
																		VALUES(
																							:eng,:ukr)");
		$sql->bindParam(':eng',$eng,PDO::PARAM_STR);
		$sql->bindParam(':ukr',$ukr,PDO::PARAM_STR);
		$sql->execute();
	}
	////////////////////////////////////
	function add_translation($connect,$ukr,$id) {
  $sql=$connect->prepare("UPDATE `languages` SET ukr=:ukr
                            WHERE id=:id");
  $sql->bindParam(':ukr',$ukr);
  $sql->bindParam(':id',$id);
  $sql->execute();
}
	////////////////////////////////
	function get_words($connect){
  
  $sql=$connect->prepare("SELECT eng, ukr,id
        FROM languages
        ORDER BY id DESC");
  $sql->execute();
  echo"<form action='translation.php' method='POST'>
        <table>";
  
  while($row=$sql->fetch(PDO::FETCH_ASSOC)){
      $eng=$row['eng'];
      $ukr=clear_data($row['ukr']);
      $id=$row['id'];
      echo "<tr>
							<td class='eng_word'>$eng</td>
							<td><input type='text' name='".$id."'  value='".$ukr."'></td>
							<td><a href='del_word.php?id=".$id."' onclick= \"return confirm('Sure?')\" >
								Del</a></td>
						</tr>";   
  }
  echo"
        </table>
      <input type='submit' value='Add'>
    </form>";
}
////////////////////////
function del_word($connect,$id){
	$sql=$connect->prepare("DELETE
												 FROM languages
												 WHERE id=:id");
	$sql->bindParam('id',$id);
	$sql->execute();	
}

////////////ADDED AND SHOW AVAtAR FUNCTIONs////////////////////////////////////
function add_avatar($connect,$name,$fname){
	$sql=$connect->prepare("UPDATE people
							SET avatar= :fname
							WHERE login= :name
								");
	$sql->bindParam(':fname',$fname,PDO::PARAM_STR);
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->execute();
}
//////////////////////

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
		else{
			return $_SESSION['error']="Please, enter correct role-name";
			exit();
		}
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
	if (isset($_SESSION['error'])) {
		unset($_SESSION['error']);
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
	$date=date("Y-m-d H:i:s");
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
		echo "<li><a href='index.php?id=profile&amp;link=".$login."'>".$login."</a></li>";
		$count++;
		if($count==$num)
			break;		
	}
}
/////FUNCTION THAT SWOWS ONE PICE FROM PEOPLE TABLE///

FUNCTION show_element($connect,$name,$field){
	$lang='eng';
	if(isset($_SESSION['lang'])) {
		$lang=$_SESSION['lang'];
	}
	$sql=$connect->prepare("SELECT $field
					FROM people
					WHERE login=:name");
	$sql->bindParam(':name',$name);
	$sql->execute();
	$row=$sql->fetch(PDO::FETCH_ASSOC);
	echo change_language($connect,$row[$field],$lang);
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
 return $role;
}
//////////////////////////////////////////////////

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
	$lang="eng";
	if (isset($_SESSION['lang'])){
		$lang=$_SESSION['lang'];
	}
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
		echo"<div class='all_info'><img src=".$ava." alt='avatar' class='all_us_pic'>";
		echo" <div class='us_info'>
						".change_language($connect,'Login',$lang).":".$row['login']."<br>";
			echo"".change_language($connect,'Role',$lang).":".change_language($connect,$row['role'],$lang)."<br>";
			echo"".change_language($connect,'First Name',$lang).":".$row['first_name']."<br>";
			echo"".change_language($connect,'Last Name',$lang).":".$row['last_name']."<br>";
		if($_SESSION['role']=='admin'){
			echo"".change_language($connect,'E-mail',$lang).":".$row['mail']."<br>";
		}
			echo"".change_language($connect,'Registration date',$lang).":".$row['registration_date']."<br>";
			echo"".change_language($connect,'Last Visiting',$lang).":".$row['last_visiting']."<br></div>";
		if($_SESSION['role']=='admin'){
			echo"
							<a href='delete_user.php?link=".$row['login']."' onclick=\"return confirm('Sure ?')\">".
									change_language($connect,'Delete',$lang)."
								 </a>".change_language($connect,'or maybe',$lang)."
								<a href='index.php?id=edit_profile&amp;link=".$row['login']."'>
								 ".change_language($connect,'Edit',$lang)."
							</a>
					<br>";
		}			
		echo"</div><hr>";	
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