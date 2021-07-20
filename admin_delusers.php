<?php
require "include/functions.php";
dbconn();
loggedinorreturn();
//referer();
if (get_user_class() < UC_ADMINISTRATOR)
{
		stderr("Error", "Permission denied");
}

$sql = sprintf('DELETE FROM users WHERE id IN(%s)', implode($_POST['deleteuser'],','));
mysql_query($sql);


header("Location: ".$_SERVER['HTTP_REFERER']);
?>