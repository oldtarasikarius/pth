<?php
  require "inc/lib.inc.php";


if($_SERVER['REQUEST_METHOD']=='POST') {
  foreach($_POST as $id => $ukr) {
    if (!empty($ukr)) {
      add_translation($connect,$ukr,$id);
    }
  }
}
header("Location:index.php?id=translation_form");
?>