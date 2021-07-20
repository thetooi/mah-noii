<?php

require_once("include/functions.php");

dbconn();

logoutcookie();

//header("Refresh: 0; url=./");
Header("Location: $BASEURL/");

?>