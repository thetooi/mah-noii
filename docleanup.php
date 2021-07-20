<?php
require_once("include/functions.php");
dbconn();
loggedinorreturn();
//referer();
if (get_user_class() < UC_ADMINISTRATOR) stderr("Error", "Permission denied");
docleanup();
echo("Done");

?>
