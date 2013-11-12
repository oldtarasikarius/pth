<?php
session_start();
require "inc/lib.inc.php";

$value=clear_data($_GET['value']);
$field=clear_data($_GET['field']);

function field_validation($connect,$value,$field){
  $lang="eng";
  if (isset($_SESSION['lang'])) {
    $lang=$_SESSION['lang'];
  }
  if ($field=="login"){
    $sql=$connect->prepare("SELECT login     
                            FROM   people
                            WHERE  login=:value");
    $sql->bindParam(':value',$value,PDO::PARAM_STR);
  }
  if ($field=="mail"){
    $sql=$connect->prepare("SELECT mail     
                            FROM   people
                            WHERE  mail=:value");
    $sql->bindParam(':value',$value,PDO::PARAM_STR);
  }
    $sql->execute();
		$row=$sql->fetch();		
	if(!empty($row)){
			echo change_language($connect,'already registered',$lang);
  }
}
field_validation($connect,$value,$field);
?>