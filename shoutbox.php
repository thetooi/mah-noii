<?
require_once("include/functions.php");
dbconn(false);
loggedinorreturn();
parked();
referer();
//deleting messages

if (isset($_GET['del']))
{
if (is_numeric($_GET['del']))
{
$query = "SELECT * FROM shoutbox WHERE id=".$_GET['del'];
$result = mysql_query($query);
}
else {
echo "<center>Invalid message ID</center>";
exit;}

$row = mysql_fetch_row($result);

if ( (get_user_class() >= UC_USER) )
{
$query = "DELETE FROM shoutbox WHERE id=".$_GET['del'];
mysql_query($query);
}
}

?>
<html><head>
<title>ShoutBox</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META HTTP-EQUIV=REFRESH CONTENT="120; URL=shoutbox.php">
<style type="text/css">
A {color: #000000; font-weight: bold; }
A:hover {color: #FF0000;}
.small {font-size: 8pt; font-family: verdana; }
.date {font-size: 7pt;}
</style>
<STYLE>BODY {
SCROLLBAR-3DLIGHT-COLOR: #004E98;
SCROLLBAR-ARROW-COLOR: #004E98;
SCROLLBAR-DARKSHADOW-COLOR: white;
SCROLLBAR-BASE-COLOR: white
}
</STYLE>
</head>
<body bgcolor=#F5F4EA>
<?

/*
if ($CURUSER["chatpost"] == 'no')
{
print("<h2><br><center>You are banned.</center></h2>");
exit;
}
else
{
*/

if(isset($_GET["sent"])=="yes")
if(!$_GET["shbox_text"])
{
	$userid=$CURUSER["id"];
}
else
{
$userid=$CURUSER["id"];
$username=$CURUSER["username"];
$date=sqlesc(time());
$text=($_GET["shbox_text"]);
$text = ($text);

mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ('id'," . sqlesc($userid) . ", " . sqlesc($username) . ", $date, " . sqlesc($text) . ")") or sqlerr(__FILE__, __LINE__);
print "<script type=\"text/javascript\">parent.document.forms[0].shbox_text.value='';</script>";
}

$res = mysql_query("SELECT * FROM shoutbox ORDER BY date DESC LIMIT 70") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) == 0)
print("\n");
else
{
print("<table border=0 cellspacing=0 cellpadding=2 width='100%' align='left' class='small'>\n");

while ($arr = mysql_fetch_assoc($res))
{
$res2 = mysql_query("SELECT username,class,avatar,donor, title,enabled,warned FROM users WHERE id=$arr[userid]") or sqlerr(__FILE__, __LINE__);
$arr2 = mysql_fetch_assoc($res2);

$resowner = mysql_query("SELECT id, username, class FROM users WHERE id=$arr[userid]") or print(mysql_error());
$rowowner = mysql_fetch_array($resowner);

if ($rowowner["class"] == "7")
$usercolor= "<font color=#FF0000>" .htmlspecialchars($rowowner["username"]). "</font>";
if ($rowowner["class"] == "6")
$usercolor= "<font color=#FF0000>" .htmlspecialchars($rowowner["username"]). "</font>";
if ($rowowner["class"] == "5")
$usercolor= "<font color=#6B001A>" .htmlspecialchars($rowowner["username"]). "</font>";
if ($rowowner["class"] == "4")
$usercolor= "<font color=#9A6258>" .htmlspecialchars($rowowner["username"]). "</font>";
if ($rowowner["class"] == "3")
$usercolor= "<font color=#FF6600>" .htmlspecialchars($rowowner["username"]). "</font>";
elseif ($rowowner["class"] == "2")
$usercolor= "<font color=#4F3157>" .htmlspecialchars($rowowner["username"]). "</font>";
elseif ($rowowner["class"] == "1")
$usercolor= "<font color=#000000>" .htmlspecialchars($rowowner["username"]). "</font>";
elseif ($rowowner["class"] == "0")
$usercolor= "<font color=#000000>" .htmlspecialchars($rowowner["username"]). "</font>";
if($arr[userid] == '0')
$usercolor = "<font color=#000000>System</font>";

if (get_user_class() >= UC_MODERATOR) {
$del="[<a href=/shoutbox.php?del=".$arr[id]."><b>Del</b></a>]";
}
if ($CURUSER)
print("<tr><td><font color=gray><span class='date'>".strftime("%d.%m %H:%M",$arr["date"]).":.</font>
$del
</span>
<a href='userdetails.php?id=".$arr["userid"]."' target='_blank'>$usercolor</a>" .
($arr2["donor"] == "yes" ? "<img src=pic/star.gif alt='Donor'>" : "") .
($arr2["warned"] == "yes" ? "<img src="."/pic/warned.gif alt=\"Warned\">" : "") .format_comment(
" $arr[text]
"));
else
print("<tr><td><font color=gray><span class='date'>".strftime("%d.%m %H:%M",$arr["date"]).":.</font>
$del
</span>
<b>$usercolor</b>" .
($arr2["donor"] == "yes" ? "<img src=pic/star.gif alt='Donor'>" : "") .
($arr2["warned"] == "yes" ? "<img src="."/pic/warned.gif alt=\"Warned\">" : "") .format_comment(
" $arr[text]
"));
}
print("</table>");


}


?>
</body>
</html>