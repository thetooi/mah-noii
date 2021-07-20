<?php

require_once("include/functions.php");

if (!mkglobal("username:password:Turing"))
	die();

dbconn();
//referer();
failedloginscheck ();
function bark($text = "<b>Error</b>: Username or password incorrect<br>Don't remember your password? <b><a href=recover.php>Recover</a></b> your password!")
{
  stderr("Login failed!", $text);
}
$res = mysql_query("SELECT id, passhash, secret, enabled FROM users WHERE username = " . sqlesc($username) . " AND status = 'confirmed'");
$row = mysql_fetch_assoc($res);
include('captcha/captchac_lib.php');
	$Turing_code = $_REQUEST["Turing"];
	if ( CheckCaptcha($Turing_code) !=1 )
    {
    	bark("The Captcha Code you entered is invalid. Please press the Back button of your browser and try again.");
	return 1;
    }

if (!$row)
	bark();

if (!$row)
    failedlogins();

if ($row["passhash"] != md5($row["secret"] . $password . $row["secret"]))
    failedlogins();

if ($row["enabled"] == "no")
	bark("This account has been disabled.");

$ip = sqlesc(getip());
mysql_query("DELETE FROM loginattempts WHERE ip = $ip");

logincookie($row["id"], $row["passhash"]);

if (!empty($_POST["returnto"]))
	header("Location: $_POST[returnto]");
else
	header("Location: my.php");

?>