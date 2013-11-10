<?php
require "inc/lib.inc.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
  $word=clear_data($_POST['word']);
  insert_w($connect,$word);
}
header("Location:index.php?id=translation_form");
?>