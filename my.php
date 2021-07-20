<?
require_once("include/functions.php");
dbconn(false);
loggedinorreturn();
//referer();
$res = mysql_query("SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND folder_in<>0") or print(mysql_error());
$arr = mysql_fetch_row($res);
$messages = $arr[0];
$res = mysql_query("SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND folder_in<>0 AND unread='yes'") or print(mysql_error());
$arr = mysql_fetch_row($res);
$unread = $arr[0];
$res = mysql_query("SELECT COUNT(*) FROM messages WHERE sender=" . $CURUSER["id"] . " AND folder_out<>0") or print(mysql_error());
$arr = mysql_fetch_row($res);
$outmessages = $arr[0];
stdhead($CURUSER["username"] . "'s private page", false);

if ($_GET["edited"]) {
	echo("<h1>Profile updated!</h1>\n");
	if ($_GET["mailsent"])
		echo("<h2>Confirmation email has been sent!</h2>\n");
}
elseif ($_GET["emailch"])
	echo("<h1>Email address changed!</h1>\n");





else
	echo("<h1>Welcome, <a href=userdetails.php?id=$CURUSER[id]>$CURUSER[username]</a>!</h1>\n");

?>
<table border="1" cellspacing="0" cellpadding="10" align="center" width="90%">
<tr>
<head>
	<style type="text/css" media="screen">@import "tabs.css";</style>
</head>

<body>
	<div id="header5">
	<ul id="primary">
		<li><a href="userdetails.php?id=<?=$CURUSER['id']?>">Userdetails</a></li>
		<li><a href="friends.php">My Friends</a></li>
		<li><span>My Profile</span></li>
		<li><a href="simpaty.php">My Liking</a></li>
	</ul>
	</div>

<td align="center" class="colhead" width="100%"></a></td>
</tr>
<tr>
<td colspan="3">
<form method="post" action="_takeprofedit.php">
<table border="1" cellspacing=0 cellpadding="5" width="100%">
<?

/***********************

$res = mysql_query("SELECT COUNT(*) FROM ratings WHERE user=" . $CURUSER["id"]);
$row = mysql_fetch_array($res);
tr("Ratings submitted", $row[0]);

$res = mysql_query("SELECT COUNT(*) FROM comments WHERE user=" . $CURUSER["id"]);
$row = mysql_fetch_array($res);
tr("Written comments", $row[0]);

****************/

$ss_r = mysql_query("SELECT * from stylesheets") or die;
$ss_sa = array();
while ($ss_a = mysql_fetch_array($ss_r))
{
  $ss_id = $ss_a["id"];
  $ss_name = $ss_a["name"];
  $ss_sa[$ss_name] = $ss_id;
}
ksort($ss_sa);
reset($ss_sa);
while (list($ss_name, $ss_id) = each($ss_sa))
{
  if ($ss_id == $CURUSER["stylesheet"]) $ss = " selected"; else $ss = "";
  $stylesheets .= "<option value=$ss_id$ss>$ss_name</option>\n";
}

$countries = "<option value=0>---- None selected ----</option>\n";
$ct_r = mysql_query("SELECT id,name FROM countries ORDER BY name") or die;
while ($ct_a = mysql_fetch_array($ct_r))
  $countries .= "<option value=$ct_a[id]" . ($CURUSER["country"] == $ct_a['id'] ? " selected" : "") . ">$ct_a[name]</option>\n";

function format_tz($a)
{
	$h = floor($a);
	$m = ($a - floor($a)) * 60;
	return ($a >= 0?"+":"-") . (strlen(abs($h)) > 1?"":"0") . abs($h) .
		":" . ($m==0?"00":$m);
}
tr("Account parked",
"<input type=radio name=parked" . ($CURUSER["parked"] == "yes" ? " checked" : "") . " value=yes>yes
<input type=radio name=parked" .  ($CURUSER["parked"] == "no" ? " checked" : "") . " value=no>no
<br><font class=small size=1>You can park your account to prevent it from being deleted because of inactivity if you go away on for example a vacation. When the account has been parked limits are put on the account, for example you cannot use the tracker and browse some of the pages.</font>"
,1);

tr("Accept PMs",



"<input type=radio name=acceptpms" . ($CURUSER["acceptpms"] == "yes" ? " checked" : "") . " value=yes>All (except blocks)
<input type=radio name=acceptpms" .  ($CURUSER["acceptpms"] == "friends" ? " checked" : "") . " value=friends>Friends only
<input type=radio name=acceptpms" .  ($CURUSER["acceptpms"] == "no" ? " checked" : "") . " value=no>Staff only"
,1);



tr("Delete PMs", "<input type=checkbox name=deletepms" . ($CURUSER["deletepms"] == "yes" ? " checked" : "") . "> (Default value for \"Delete PM on reply\")",1);
tr("Save PMs", "<input type=checkbox name=savepms" . ($CURUSER["savepms"] == "yes" ? " checked" : "") . "> (Default value for \"Save PM to Sentbox\")",1);

$r = mysql_query("SELECT id,name FROM categories ORDER BY name") or sqlerr();
//$categories = "Default browsing categories:<br>\n";
if (mysql_num_rows($r) > 0)
{
	$categories .= "<table><tr>\n";
	$i = 0;
	while ($a = mysql_fetch_assoc($r))
	{
	  $categories .=  ($i && $i % 2 == 0) ? "</tr><tr>" : "";
	  $categories .= "<td class=bottom style='padding-right: 5px'><input name=cat$a[id] type=\"checkbox\" " . (strpos($CURUSER['notifs'], "[cat$a[id]]") !== false ? " checked" : "") . " value='yes'>&nbsp;" . htmlspecialchars($a["name"]) . "</td>\n";
	  ++$i;
	}
	$categories .= "</tr></table>\n";
}

ksort($tzs);
reset($tzs);
while (list($key, $val) = each($tzs)) {
 if ($CURUSER["tzoffset"] == $key) {
    $timezone .= "<option value=\"$key\" selected>$val</option>\n";
 } else {
    $timezone .= "<option value=\"$key\">$val</option>\n";
 }
}

tr("Email notification", "<input type=checkbox name=pmnotif" . (strpos($CURUSER['notifs'], "[pm]") !== false ? " checked" : "") . " value=yes> Notify me when I have received a PM<br>\n" .
	 "<input type=checkbox name=emailnotif" . (strpos($CURUSER['notifs'], "[email]") !== false ? " checked" : "") . " value=yes> Notify me when a torrent is uploaded in one of <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; my default browsing categories.\n"
   , 1);
tr("Browse default<br>categories",$categories,1);
tr("Login Type",
"<input type=radio name=logintype" . ($CURUSER["logintype"] == "secure" ? " checked" : "") . " value=secure>Secure
<input type=radio name=logintype" .  ($CURUSER["logintype"] == "normal" ? " checked" : "") . " value=normal>Normal
<br><font class=small>Normal must be used to allow login from multiple locations</font>"
,1);
tr("Reset passkey","<input type=checkbox name=resetpasskey  value=1><br><font class=small>Any active torrents must be downloaded again to continue leeching/seeding.</font>", 1);
tr("Stylesheet", "<select name=stylesheet>\n$stylesheets\n</select>",1);
tr("Country", "<select name=country>\n$countries\n</select>",1);
tr("Time zone", "<select name=tzoffset>\n$timezone\n</select><br />Be sure to select the correct time zone and be aware of Daylight Savings Time.(In the toolbar/forum/inbox)",1);
tr("Gender", "<input type=radio name=gender" . ($CURUSER["gender"] == "Male" ? " checked" : "") . " value=Male>Male
<input type=radio name=gender" .  ($CURUSER["gender"] == "Female" ? " checked" : "") . " value=Female>Female"
,1);
tr("Avatar URL", "<input name=avatar size=50 value=\"" . htmlspecialchars($CURUSER["avatar"]) .
  "\"><br>\nWidth should be 150 pixels (please resize if necessary)\n<br>If you need a host for the picture, try the <a href=http://photobucket.com/>photobucket</a>.",1);
tr("View avatars", "<input type=checkbox name=avatars" . ($CURUSER["avatars"] == "yes" ? " checked" : "") . "> (Low bandwidth users might want to turn this off)",1);
tr("Signature", "<textarea name=signature cols=50 rows=4>" . $CURUSER["signature"] . "</textarea><br> May contain <a href=tags.php target=_new>BB codes</a>.", 1);
tr("Show signatures", "<input type=checkbox name=showsig" . ($CURUSER["showsig"] == "yes" ? " checked" : "") . "> (Default: Show signatures)",1);
tr("Torrents per page", "<input type=text size=10 name=torrentsperpage value=$CURUSER[torrentsperpage]> (0=use default setting)",1);
tr("Topics per page", "<input type=text size=10 name=topicsperpage value=$CURUSER[topicsperpage]> (0=use default setting)",1);
tr("Posts per page", "<input type=text size=10 name=postsperpage value=$CURUSER[postsperpage]> (0=use default setting)",1);
tr("Info", "<textarea name=info cols=50 rows=4>" . $CURUSER["info"] . "</textarea><br>Displayed on your public page. May contain <a href=tags.php target=_new>BB codes</a>.", 1);
tr("Your Music Style", "<textarea name=musicstyle cols=50 rows=4>" . $CURUSER["musicstyle"] . "</textarea><br>", 1);
tr("Website", "<input type=\"text\" name=\"website\" size=50 value=\"" . htmlspecialchars($CURUSER["website"]) . "\" />", 1);
tr("Show website", "<input type=radio name=showwebsite" . ($CURUSER["showwebsite"] == "yes" ? " checked" : "") . " value=yes>yes
<input type=radio name=showwebsite" .  ($CURUSER["showwebsite"] == "no" ? " checked" : "") . " value=no>no"
,1);
tr("Hide profile", "<input type=checkbox name=hideprofile" . ($CURUSER["hideprofile"] == "yes" ? " checked" : "") . "> (Hide profile - You profile is protected!)",1);
tr("Make Friends Public", "<input type=checkbox name=showfriends" . ($CURUSER["showfriends"] == "yes" ? " checked" : "") . "> (Allow my friends to be publicly shown?)",1);
tr("Email address", "<input type=\"text\" name=\"email\" size=50 value=\"" . htmlspecialchars($CURUSER["email"]) . "\" />", 1);
tr("Show email address", "<input type=radio name=showemail" . ($CURUSER["showemail"] == "yes" ? " checked" : "") . " value=yes>yes
<input type=radio name=showemail" .  ($CURUSER["showemail"] == "no" ? " checked" : "") . " value=no>no"
,1);
tr("Change password", "<input type=\"password\" name=\"chpassword\" size=\"50\" />", 1);
tr("Type password again", "<input type=\"password\" name=\"passagain\" size=\"50\" />", 1);

function priv($name, $descr) {
	global $CURUSER;
	if ($CURUSER["privacy"] == $name)
		return "<input type=\"radio\" name=\"privacy\" value=\"$name\" checked=\"checked\" /> $descr";
	return "<input type=\"radio\" name=\"privacy\" value=\"$name\" /> $descr";
}

/* tr("Privacy level",  priv("normal", "Normal") . " " . priv("low", "Low (email address will be shown)") . " " . priv("strong", "Strong (no info will be made available)"), 1); */

?>
<tr><td colspan="2" align="center"><input type="submit" class="groovybutton" value="Submit changes!" style='height: 25px'> <input type="reset" class="groovybutton" value="Revert changes!" style='height: 25px'></td></tr>
</table>
</form>
</td>
</tr>
</table>
<?
if ($messages){
  echo("<p><tr><td  colspan=4 align=center>You have $messages Message" . ($messages != 1 ? "en" : "") . ' ('.$unread.' new) in your <a href="messages.php?folder='.PM_FOLDERID_INBOX.'"><b>Inbox</b></a>, '."\n");
	if ($outmessages)
		echo('<br>und '.$outmessages.' Message' . ($outmessages != 1 ? "en" : "") . ' in your <a href="messages.php?folder='.PM_FOLDERID_OUTBOX.'"><b>Outgoing</b></a>.'."\n".'</td></tr>');
	else
		echo('<br>and your <a href="messages.php?folder='.PM_FOLDERID_OUTBOX.'"><b>Outgoing</b></a> is empty.</td></tr>');
}
else
{
  echo('<tr><td class=tablea colspan=4 align=center>Your <a href="messages.php?folder='.PM_FOLDERID_INBOX.'">'."<b>Inbox</b></a> is empty, \n");
	if ($outmessages)
		echo("<br>and you have $outmessages Message" . ($outmessages != 1 ? "en" : "") . ' in your <a href="messages.php?folder='.PM_FOLDERID_OUTBOX.'">'."<b>Outgoing</b></a>.\n</td></tr>");
	else
		echo('<br>and your <a href="messages.php?folder='.PM_FOLDERID_OUTBOX.'"><b>Outgoing</b></a> also.</td></tr>');
}

echo("<p><a href=users.php><b>Find User/Browse User List</b></a></p>");
stdfoot();



?>