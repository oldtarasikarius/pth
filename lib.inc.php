<?php
mysql_connect("localhost","root","ppp") or die(mysql_error());
mysql_select_db('metal_gym')or die(mysql_error());

//Зміна мови
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
//Меню
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
//фільтрація данних	
	function clear_data($data){
	return mysql_real_escape_string(trim(strip_tags($data)));
	}
//Вихід з профілю
	function log_out(){
		unset($_SESSION['name']);
	}
//Показати статті
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
			echo"Від {$login}<p>{$art}</p>
			<a href='index.php?id=edit_form&num={$num}'>Редагувати</a><br /><br /><br /><br />";
			
		}		
	}
//Вибір однієї статті з бази
	function get_art($id){
		$sql="SELECT article
				FROM articles
				WHERE id=$id";
		$result=mysql_query($sql)or die(mysql_error());
		$row=mysql_fetch_assoc($result)or die(mysql_error());
		$art=$row['article'];
		return $art;
	}
//Редагувати статтю
	function edit($id,$nart){
		$sql="UPDATE articles
				SET article='$nart'
				WHERE id=$id";
		mysql_query($sql) or die(mysql_error);
	}
	
//Додати Статтю
	function add_art($art,$name){
		$sql="INSERT INTO articles(	article,
									login)
						VALUES(		'$art',
									'$name')";
		mysql_query($sql)or die(mysql_error());
		return true;					
	}
//Вхід користувача
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
//Реєстрація
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
/*insert_w('login must filled out','ви не ввели логін','введите логин');	
insert_w('You have to enter','Вам потрібно увійти','Вы должны войти');
insert_w('A combination of user name and password was not found, check the data, please','Данної комбінації не існує, перевірте дані й спробуйте ще раз','Этой комбинации логина и пароля не сущевствует, проверте данные');
insert_w('Add article','Додати статтю','Добавить статью');
insert_w('something is going wrong','щось пішло не так','Что-то не так');
insert_w('Previous page','попередня сторінка','Предыдущая страница');
insert_w('Add','Додати','Добавить');
insert_w('You have to register','Вам потрібно зареєструватись','Вам нужно зарегистрироватся');
insert_w('Edit','Редагувати','Изменить');
insert_w('Hello','Привіт','Здравствуй');
insert_w('Exit','Вихід','Выход');
insert_w('Registration','Реєстрація','Регистрация');
insert_w('Login','Логін','Логин');
insert_w('Enter','Вхід','Вход');
insert_w('Enter your nickname','Введіть логін','Введите ваш логин');
insert_w('Enter your password','Введіть пароль','Введите пароль');
insert_w('Home','Головна','Главная');
insert_w('Contacts','Контакти','Контакты');
insert_w('About Us','Про нас','О нас');
insert_w('News','Новини','Новости');
insert_w('Articles','Статті','Статьи');
insert_w('Register','Зареєструватись','Зарегистрироватся');
insert_w('You have successfully registered','Ви успішно зареєструвались','Вы успешно зарегистрировались');
insert_w('Return to main page','Повернутись на головну','Вернуться на главную');
insert_w('A user with this name already registered, please choose another','Користувач з таким ім`ям вже зареєстрований, будь-ласка, виберіть інше','Пользователь с таким именем уже зарегистрирован, пожалуйста, выберите другой');


		
	
insert_w('Password','Пароль','Пароль');	
	
	*/

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	?>
