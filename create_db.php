<?php

	mysql_connect("localhost","root","ppp") or die(mysql_error());
	
	$sql="CREATE DATABASE metal_gym";
	mysql_query($sql) or die(mysql_error());
	
	mysql_select_db('metal_gym')or die(mysql_error());
	
	$sql="CREATE TABLE users(
			login 		VARCHAR(20) NOT NULL PRIMARY KEY,
			password 	VARCHAR(50) NOT NULL,
						UNIQUE(login, password)
	)";
	mysql_query($sql) or die(mysql_error());

	$sql="CREATE TABLE articles(
			id 		INT NOT NULL auto_increment,
			article TEXT NOT NULL,
			login 	VARCHAR(20) NOT NULL,
					PRIMARY KEY(id)
	)";
	mysql_query($sql) or die(mysql_error());
	
	$sql="CREATE TABLE languages(
			id 	INT NOT NULL auto_increment,
			eng TEXT NOT NULL,
			ukr TEXT NOT NULL,
			rus TEXT NOT NULL,
				PRIMARY KEY(id)
	)";
	mysql_query($sql) or die(mysql_error());
	
	$sql="CREATE TABLE main_articles(
			id 			INT NOT NULL PRIMARY KEY auto_increment,
			eng_art 	TEXT,
			ukr_art 	TEXT,
			rus_art 	TEXT
	)";
	mysql_query($sql)or die(mysql_error());
	
	mysql_close();
	
	//echo"<p>Структура бази данних успішно створена)</p>";
?>