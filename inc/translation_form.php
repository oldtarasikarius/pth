<?php
if (isset($_SESSION['name']) and $_SESSION['role']=='admin') {
  echo change_language($connect,"To enter a brand new word - ",$lang);
  echo" <form action='add_word.php' method='POST'>
          <input type='text' name='word' maxlength='200' >
          <input type='submit' value='".change_language($connect,'Add',$lang)."'>
        </form>
        <hr />";
  get_words($connect);
}
else {
  echo change_language($connect,"you have no permission to visit this page",$lang);
}

?>