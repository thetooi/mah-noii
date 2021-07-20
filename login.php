<?php
require_once("include/functions.php");
dbconn();
referer();
if ($CURUSER)
{
stderr("Sorry", "You have already loged in $SITENAME!.");
die();
}
failedloginscheck ();
stdhead("Login");
//echo("<img src='cimage.php'><p></p>");
unset($returnto);
if (!empty($_GET["returnto"])) {
	$returnto =intval($_GET["returnto"]);
	if (!$_GET["nowarn"]) {
		echo("<h1>Not logged in!</h1>\n");
		echo("<p><b>Error:</b> The page you tried to view can only be used when you're logged in.</p>\n");
	}
}
?>
<form method="post" action="takelogin.php">
<p>Note: You need cookies enabled to log in.</p>
<table border="0" cellpadding=5>
<tr><td class=rowhead>Username:</td><td align=left><input type="text" size=40 name="username" /></td></tr>
<tr><td class=rowhead>Password:</td><td align=left><input type="password" size=40 name="password" /></td></tr>
<tr><td class=rowhead>Image Verification:</td><td align=left><img src="/captcha/captchac_code.php" id="captcha"></td></tr>
<tr><td class=rowhead>Image Verification:</td><td align=left><input type="text" name="Turing" value="" maxlength="100" size="10">
[ <a href="#" onclick=" document.getElementById('captcha').src = document.getElementById('captcha').src + '?' + (new Date()).getMilliseconds()">Refresh Image</a> ] [ <a href="/captcha/whatisturing.html" onClick="window.open('/captcha/whatisturing.html','_blank','width=400, height=300, left=' + (screen.width-450) + ', top=100');return false;">What's This?</a></td></tr>
<!--<tr><td class=rowhead>Duration:</td><td align=left><input type=checkbox name=logout value='yes' checked>Log me out after 15 minutes inactivity</td></tr>-->
<tr><td colspan="2" align="center"><input type="submit" class="groovybutton" value="Log in!" class=btn></td></tr>
</table>
<?

if (isset($returnto))
	echo("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($returnto) . "\" />\n");

?>
</form>
<p>Don't have an account? <a href="signup.php">Sign up</a> right now!</p>
<?

stdfoot();

?>