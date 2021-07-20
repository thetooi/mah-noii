<?
require_once("include/functions.php");
dbconn(false);
loggedinorreturn();
parked();
//referer();
// Fill in application

if ($_POST["form"] != "1") {

$res = mysql_query("SELECT status FROM uploadapp WHERE userid = $CURUSER[id]") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res);
if ($CURUSER["class"] >= UC_UPLOADER)
stderr("Access denied", "It appears you are allready part of our uploading team.");
elseif ($arr["status"] == "pending")
stderr("Access denied", "It appears you are currently pending confirmation of your uploader application.");
elseif ($arr["status"] == "rejected")
stderr("Access denied", "It appears you have applied for uploader before and have been rejected. If you would like a second chance please contact an administrator.");

else {
stdhead("Uploader application");
echo("<h1 align=center>Uploader application</h1><p></p>");
echo("<table width=730 border=1 cellspacing=0 cellpadding=10><tr><td>");
echo("<form action=uploadapp.php method=post enctype=multipart/form-data>");
echo("<table border=1 cellspacing=0 cellpadding=5 align=center>");

if ($CURUSER["downloaded"] > 0)
$ratio = $CURUSER['uploaded'] / $CURUSER['downloaded'];
elseif ($CURUSER["uploaded"] > 0)
$ratio = 1;
else
$ratio = 0;

$res = mysql_query("SELECT connectable FROM peers WHERE userid=$CURUSER[id]")or sqlerr(__FILE__, __LINE__);
if ($row = mysql_fetch_row($res)) {
$connect = $row[0];
if ($connect == "yes")
$connectable = "Yes";
else
$connectable = "No";
} else
$connectable = "Pending";

echo("<tr><td class=rowhead>My username is</td><td><input name=userid type=hidden value=".$CURUSER['id'].">".$CURUSER['username']."</td></tr>");
echo("<tr><td class=rowhead>I have joined at</td><td>".$CURUSER['added']." (".get_elapsed_time(sql_timestamp_to_unix_timestamp($CURUSER["added"]))." ago)</td></tr>");
echo("<tr><td class=rowhead>I have a positive ratio</td><td>".($ratio >= 1 ? "Yes" : "No")."</td></tr>");
echo("<tr><td class=rowhead>I am connectable</td><td><input name=connectable type=hidden value=$connectable>$connectable</td></tr>");
echo("<tr><td class=rowhead>My upload speed is</td><td><input type=text name=speed size=19></td></tr>");
echo("<tr><td class=rowhead>What I have to offer</td><td><textarea name=offer cols=80 rows=1 wrap=VIRTUAL></textarea></td></tr>");
echo("<tr><td class=rowhead>Why I should be promoted</td><td><textarea name=reason cols=80 rows=2 wrap=VIRTUAL></textarea></td></tr>");
echo("<tr><td class=rowhead>I am uploader at other sites</td><td><input type=radio name=sites value=yes>Yes
<input name=sites type=radio value=no checked>No</td></tr>");
echo("<tr><td class=rowhead>Those sites are</td><td><textarea name=sitenames cols=80 rows=1 wrap=VIRTUAL></textarea></td></tr>");
echo("<tr><td class=rowhead>I have scene access</td><td><input type=radio name=scene value=yes>Yes
<input name=scene type=radio value=no checked>No</td></tr>");
echo("<tr><td colspan=2>");
echo("<br> I know how to create, upload and seed torrents");
echo("<br><input type=radio name=creating value=yes>Yes
<input name=creating type=radio value=no checked>No");
echo("<br><br> I understand that I have to keep seeding my torrents until there are at least two other seeders");
echo("<br><input type=radio name=seeding value=yes>Yes
<input name=seeding type=radio value=no checked>No");
echo("<br><br><input name=form type=hidden value=1>");
echo("</td></tr>");
echo("</table>");
echo("<p align=center><input type=submit class=groovybutton name=Submit value=Send></p>");
echo("</table></form>");
echo("</td></tr></table>");
stdfoot();
}

// Process application

} else {

$userid = (int)$_POST["userid"];
$connectable = mysql_escape_string( htmlspecialchars($_POST["connectable"]));
$speed = mysql_escape_string( htmlspecialchars($_POST["speed"]));
$offer = mysql_escape_string( htmlspecialchars($_POST["offer"]));
$reason = mysql_escape_string( htmlspecialchars($_POST["reason"]));
$sites = mysql_escape_string( htmlspecialchars($_POST["sites"]));
$sitenames = mysql_escape_string( htmlspecialchars($_POST["sitenames"]));
$scene = mysql_escape_string( htmlspecialchars($_POST["scene"]));
$creating = mysql_escape_string( htmlspecialchars($_POST["creating"]));
$seeding = mysql_escape_string( htmlspecialchars($_POST["seeding"]));

if (!is_valid_id($userid))
stderr("Error", "It appears something went wrong while sending your application. Please <a href=uploadapp.php>try again</a>.");
if (!$speed)
stderr("Error", "It appears you have left the field with your upload speed blank.");
if (!$offer)
stderr("Error", "It appears you have left the field with the things you have to offer blank.");
if (!$reason)
stderr("Error", "It appears you have left the field with the reason why we should promote you blank.");
if ($sites == "yes" && !$sitenames)
stderr("Error", "It appears you have left the field with the sites you are uploader at blank.");

$res = mysql_query("INSERT INTO uploadapp(userid,applied,connectable,speed,offer,reason,sites,sitenames,scene,creating
,seeding) VALUES($userid, ".implode(",",array_map("sqlesc",array(get_date_time(), $connectable, $speed, $offer, $reason, $sites, $sitenames, $scene, $creating, $seeding))).")");
if (!$res) {
if (mysql_errno() == 1062)
stderr("Error", "It appears you tried to send your application twice.");
else
stderr("Error", "It appears something went wrong while sending your application. Please <a href=uploadapp.php>try again</a>.");
} else
stderr("Application sent", "Your application has succesfully been sent to the staff.");
}
?>