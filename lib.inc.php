<?php
mysql_connect("localhost","root","ppp") or die(mysql_error());
mysql_select_db('metal_gym')or die(mysql_error());

//���� ����
function change_language($lang=false,$text){
		if(!$lang or $lang=='eng')
			return $text;
		else{
			$sql="SELECT $lang
					FROM languages
					WHERE eng='$text'";
			$result=mysql_query($sql)or die(mysql_error());
			$row=mysql_fetch_assoc($result)or die(mysql_error());
			$text= $row[$lang];
			return $text;
		}	
	}
//����
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
//���������� ������	
	function clear_data($data){
	return mysql_real_escape_string(trim(strip_tags($data)));
	}
//����� � �������
	function log_out(){
		unset($_SESSION['name']);
	}
//�������� �����
	function show_articles(){
		$sql="SELECT *
			FROM articles
			ORDER BY id DESC";
		$result=mysql_query($sql)or die(mysql_error());
		while($row=mysql_fetch_assoc($result)){
			//$_SESSION['art_id']=$row['id'];
			//$_SESSION['art']=$row['article'];
			$login=$row['login'];
			$art=$row['article'];
			$num=$row['id'];
			echo"³� {$login}<p>{$art}</p>
			<a href='index.php?id=edit_form&num={$num}'>����������</a><br /><br /><br /><br />";
			
		}		
	}
//���� ���� ����� � ����
	function get_art($id){
		$sql="SELECT article
				FROM articles
				WHERE id=$id";
		$result=mysql_query($sql)or die(mysql_error());
		$row=mysql_fetch_assoc($result)or die(mysql_error());
		$art=$row['article'];
		return $art;
	}
//���������� ������
	function edit($id,$nart){
		$sql="UPDATE articles
				SET article='$nart'
				WHERE id=$id";
		mysql_query($sql) or die(mysql_error);
	}
	
//������ ������
	function add_art($art,$name){
		$sql="INSERT INTO articles(	article,
									login)
						VALUES(		'$art',
									'$name')";
		mysql_query($sql)or die(mysql_error());
		return true;					
	}
//���� �����������
	function enter($login,$password){
		if($login=='admin'and $password==md5('1111')){
			$_SESSION['name']=$login;
			header("Location:{$_SERVER['HTTP_REFERER']}");
			die();
		}	
		$sql="SELECT login,password
				FROM users
				WHERE login='$login'
				AND password='$password'";
		$result=mysql_query($sql) or die(mysql_error());
		
		if(mysql_fetch_assoc($result)!==FALSE){
			$_SESSION['name']=$login;
			header("Location:{$_SERVER['HTTP_REFERER']}");
		}
		else
			header("Location:index.php?id=enter_error");
	}
//���������
	function registration($login,$password,$lang){
		$sql="SELECT login,password
				FROM users
				WHERE login='{$login}'
			";
		$result=mysql_query($sql) or die(mysql_error());
		$row=mysql_fetch_assoc($result);
		
		if($login==$row['login']){
			echo"<p color='red'>".change_language($lang,'A user with this name already registered, please choose another')."!</p>";
			exit();
		}
		
		$sql="	INSERT INTO users(
							login,password)
						VALUES(
							'$login','$password')";
		mysql_query($sql)or die(mysql_error());
		
		$_SESSION['name']="$login";		
		echo $_SESSION['name'].", ". change_language($lang,'You have successfully registered')."...<br />
				<a href='index.php'>".change_language($lang,'Return to main page')."...</a>";
	}
/////////////
	function insert($eng,$ukr,$rus){
		$sql="INSERT INTO  main_articles(
					eng_art,ukr_art,rus_art)
				VALUES(
					'$eng','$ukr','$rus')";
		mysql_query($sql)or die(mysql_error());
	}
	
	
	function main_art($lang='eng'){
		if($lang=='eng')
			$data='eng_art';
		if($lang=='ukr')
			$data='ukr_art';
		if($lang=='rus')
			$data='rus_art';
		$sql="SELECT {$data}
				FROM main_articles
			";
		$result=mysql_query($sql)or die(mysql_error());
		$row=mysql_fetch_assoc($result)or die(mysql_error());
		$art=$row[$data];
		//$art= mysql_result($result, 0, $data);
		//if($art)
		return $art;
	}
	
function insert_w($eng,$ukr,$rus){
		$sql="INSERT INTO  languages(
					eng,ukr,rus)
				VALUES(
					'$eng','$ukr','$rus')";
		mysql_query($sql)or die(mysql_error());
		echo"</br>$eng,$ukr,$rus are added";
	}	
/*insert_w('login must filled out','�� �� ����� ����','������� �����');	
insert_w('You have to enter','��� ������� �����','�� ������ �����');
insert_w('A combination of user name and password was not found, check the data, please','����� ��������� �� ����, �������� ��� � ��������� �� ���','���� ���������� ������ � ������ �� �����������, �������� ������');
insert_w('Add article','������ ������','�������� ������');
insert_w('something is going wrong','���� ���� �� ���','���-�� �� ���');
insert_w('Previous page','��������� �������','���������� ��������');
insert_w('Add','������','��������');
insert_w('You have to register','��� ������� ��������������','��� ����� �����������������');
insert_w('Edit','����������','��������');
insert_w('Hello','�����','����������');
insert_w('Exit','�����','�����');
insert_w('Registration','���������','�����������');
insert_w('Login','����','�����');
insert_w('Enter','����','����');
insert_w('Enter your nickname','������ ����','������� ��� �����');
insert_w('Enter your password','������ ������','������� ������');
insert_w('Home','�������','�������');
insert_w('Contacts','��������','��������');
insert_w('About Us','��� ���','� ���');
insert_w('News','������','�������');
insert_w('Articles','�����','������');
insert_w('Register','��������������','�����������������');
insert_w('You have successfully registered','�� ������ ��������������','�� ������� ������������������');
insert_w('Return to main page','����������� �� �������','��������� �� �������');
insert_w('A user with this name already registered, please choose another','���������� � ����� ��`�� ��� �������������, ����-�����, ������� ����','������������ � ����� ������ ��� ���������������, ����������, �������� ������');


		
	
insert_w('Password','������','������');	
	
	*/

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	?>
