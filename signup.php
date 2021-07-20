<?
require_once("include/functions.php");
dbconn();
referer();
if ($CURUSER)
{
stderr("Sorry", "You have already loged in $SITENAME!.");
die();
}
failedloginscheck ();
$res = mysql_query("SELECT COUNT(*) FROM users") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
if ($arr[0] >= $maxusers)
stderr("Sorry", "We are a private site now and require an invite to join. Please do not request to be invited on non-invite forums, thanks.");
stdhead("Signup");
$year .= "<select name=year>";
$year .= "<option value=0000>---</option>";
$i = "2005";
while($i >= 1950){
$year .= "<option value=".$i.">".$i."</option>";
$i--;
}
$year .= "</select>";


$month .= "<select name=month>";
$month .= "<option value=00>---</option>";
$month .= "<option value=01>January</option>";
$month .= "<option value=02>February</option>";
$month .= "<option value=03>March</option>";
$month .= "<option value=04>April</option>";
$month .= "<option value=05>May</option>";
$month .= "<option value=06>June</option>";
$month .= "<option value=07>July</option>";
$month .= "<option value=08>August</option>";
$month .= "<option value=09>September</option>";
$month .= "<option value=10>October</option>";
$month .= "<option value=11>November</option>";
$month .= "<option value=12>December</option>";
$month .= "</select>";


$day .= "<select name=day>";
$day .= "<option value=00>---</option>";
$i = 1;
while($i <= 31){
if($i < 10){
$day .= "<option value=0".$i.">0".$i."</option>";
}else{
$day .= "<option value=".$i.">".$i."</option>";
}
$i++;
}
if ($valid == true)

?>
<!--
<table width=500 border=1 cellspacing=0 cellpadding=10><tr><td align=left>
<h2 align=center>Proxy check</h2>
<b><font color=red>Important - please read:</font></b> We do not accept users connecting through public proxies. When you
submit the form below we will check whether any commonly used proxy ports on your computer is open. If you have a firewall it may alert of you of port
scanning activity. This is only our proxy-detector in action.
<b>The check takes up to 30 seconds to complete, please be patient.</b> The IP address we will test is <b><?= $HTTP_SERVER_VARS["REMOTE_ADDR"]; ?></b>.
By proceeding with submitting the form below you grant us permission to scan certain ports on this computer.
</td></tr></table>
<p>
-->
Note: You need cookies enabled to sign up or log in.
<p>
<form method="post" action="takesignup.php">
<table border="1" cellspacing=0 cellpadding="10">
<tr><td align="right" class="heading">Desired username:<font color=red>&nbsp;*</font></td><td align=left><input type="text" size="40" name="wantusername" /></td></tr>
<tr><td align="right" class="heading">Pick a password:<font color=red>&nbsp;*</font></td><td align=left><input type="password" size="40" name="wantpassword" /></td></tr>
<tr><td align="right" class="heading">Enter password again:<font color=red>&nbsp;*</font></td><td align=left><input type="password" size="40" name="passagain" /></td></tr>

<tr valign=top><td align="right" class="heading">Email address:<font color=red>&nbsp;*</font></td><td align=left><input type="text" size="40" name="email" />
<table width=250 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded><font class=small>The email address must be valid.
You will receive a confirmation email which you need to respond to. The email address won't be publicly shown anywhere.</td></tr>
</font></td></tr></table>
<? tr("Gender<font color=red>&nbsp;*</font>",
"<input type=radio name=gender" . ($CURUSER["gender"] == "Male" ? " checked" : "") . " value=Male>Male
<input type=radio name=gender" .  ($CURUSER["gender"] == "Female" ? " checked" : "") . " value=Female>Female"
,1);
 $countries = "<option value=75>---- None selected ----</option>n";
$ct_r = mysql_query("SELECT id,name FROM countries ORDER BY name") or die;
while ($ct_a = mysql_fetch_array($ct_r))
$countries .= "<option value=$ct_a[id]" . ($CURUSER["country"] == $ct_a['id'] ? " selected" : "") . ">$ct_a[name]</option>n";
tr("Country<font color=red>&nbsp;*</font>", "<select name=country>n$countries</select>", 1);
tr("Website <font color=red>&nbsp;*</font>", "<input type=\"text\" name=\"website\" size=40 value=\"" . htmlspecialchars($CURUSER["website"]) . "\" /> ", 1);
tr("Your birthday:<font color=red>&nbsp;*</font>", $year . $month . $day ,1);
tr("What's Your Music Style? <font color=red>&nbsp;*</font>", "<textarea name=musicstyle cols=30 rows=4></textarea><br>Displayed on your public page.", 1);
?>
<tr><td align="right" class="heading">Image Verification:<font color=red>&nbsp;*</font></td><td align=left><img src="/captcha/captchac_code.php" id="captcha"></td></tr>

<tr><td class=rowhead>Image Verification:<font color=red>&nbsp;*</font></td><td align=left><input type="text" name="Turing" value="" maxlength="100" size="10">
[ <a href="#" onclick=" document.getElementById('captcha').src = document.getElementById('captcha').src + '?' + (new Date()).getMilliseconds()">Refresh Image</a> ] [ <a href="/captcha/whatisturing.html" onClick="window.open('/captcha/whatisturing.html','_blank','width=400, height=300, left=' + (screen.width-450) + ', top=100');return false;">What's This?</a></td></tr>
</td></tr>
<tr><td align="right" class="heading"></td><td align=left><input type=checkbox name=rulesverify value=yes> I have read the site <a href=/rules.php target=_blank font color=red>rules</a> page.<br>
<input type=checkbox name=faqverify value=yes> I agree to read the <a href=/faq.php target=_blank font color=red>FAQ</a> before asking questions.<br>
<input type=checkbox name=ageverify value=yes> I agree to read the <a href=/useragreement.php target=_blank font color=red>User agreement</a> page.</td></tr>
<tr><td colspan="2" align="center"><input type=submit class="groovybutton" value="Sign up! (PRESS ONLY ONCE)" style='height: 25px'></td></tr>
</table>
</form>
<?

stdfoot();

?>