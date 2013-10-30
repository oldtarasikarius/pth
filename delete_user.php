<?php
require"inc/lib.inc.php";
if(isset ($_GET['link'])){
	$link_name=clear_data($_GET['link']);
	delete_user($connect,$link_name);
}
header("Location:index.php?id=all_users");

?>