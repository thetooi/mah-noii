<?
require_once("include/functions.php");
$id = (int) $HTTP_GET_VARS["id"];
$md5 = $HTTP_GET_VARS["secret"];

if (!$id)
	httperr();

dbconn();
//referer();
$res = mysql_query("SELECT COUNT(*) FROM users") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
if ($arr[0] >= $invites)
	stderr("Sorry", "The current user account limit (" . number_format($invites) . ") has been reached. Inactive accounts are pruned all the time, please check back again later...");

$res = mysql_query("SELECT passhash, editsecret, secret, status FROM users WHERE id = $id");
$row = mysql_fetch_array($res);

if (!$row)
	httperr();

if ($row["status"] != "pending") {
	header("Refresh: 0; url=../../ok.php?type=confirmed");
	exit();
}

$sec = hash_pad($row["editsecret"]);
if ($md5 != md5($sec))
	httperr();

$secret = $row["secret"];
$psecret = md5($row["editsecret"]);
stdhead("Confirm Invite");
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

Note: You need cookies enabled to sign up or log in.
<p>
<form method="post" action="takeconfirminvite.php?id=<?= $id?>&secret=<?= $psecret ?>">
<table border="1" cellspacing=0 cellpadding="10">
<tr><td align="right" class="heading">Desired username:</td><td align=left><input type="text" size="40" name="wantusername" /></td></tr>
<tr><td align="right" class="heading">Pick a password:</td><td align=left><input type="password" size="40" name="wantpassword" /></td></tr>
<tr><td align="right" class="heading">Enter password again:</td><td align=left><input type="password" size="40" name="passagain" /></td></tr>
<? tr("Gender",
"<input type=radio name=gender" . ($CURUSER["gender"] == "Male" ? " checked" : "") . " value=Male>Male
<input type=radio name=gender" .  ($CURUSER["gender"] == "Female" ? " checked" : "") . " value=Female>Female <font color=red>&nbsp;*</font>"
,1);
 $countries = "<option value=75>---- None selected ----</option>n";
$ct_r = mysql_query("SELECT id,name FROM countries ORDER BY name") or die;
while ($ct_a = mysql_fetch_array($ct_r))
$countries .= "<option value=$ct_a[id]" . ($CURUSER["country"] == $ct_a['id'] ? " selected" : "") . ">$ct_a[name]</option>n";
tr("Country<font color=red>&nbsp;*</font>", "<select name=country>n$countries</select>", 1);
tr("Your birthday:<font color=red>&nbsp;*</font>", $year . $month . $day ,1);
tr("What's Your Music Style?  ", "<textarea name=musicstyle cols=30 rows=4></textarea><br>Displayed on your public page.", 1);
tr("Website (optional)", "<input type=\"text\" name=\"website\" size=40 value=\"" . htmlspecialchars($CURUSER["website"]) . "\" /> ", 1); ?>
</td></tr>
<tr><td align="right" class="heading"></td><td align=left><input type=checkbox name=rulesverify value=yes> I have read the site <a href=/rules.php/ target=_blank font color=red>rules</a> page.<br>
<input type=checkbox name=faqverify value=yes> I agree to read the <a href=/faq.php/ target=_blank font color=red>FAQ</a> before asking questions.<br>
<input type=checkbox name=ageverify value=yes> I am at least 13 years old.</td></tr>
<tr><td colspan="2" align="center"><input type=submit value="Sign up! (PRESS ONLY ONCE)" style='height: 25px'></td></tr>
</table>
</form>
<?

stdfoot();

?>
