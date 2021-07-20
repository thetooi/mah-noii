<?php
//Referer based on site log by norris  modified by hellix
require "include/functions.php";
require_once("include/pprotect.php");
dbconn(false);
loggedinorreturn();
parked();


if (get_user_class() < UC_ADMINISTRATOR)
stderr("Error", "Permission denied.");
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
if ($_POST["delete"])
mysql_query("DELETE FROM referer");
header("Location: $BASEURL/referer.php");
die;
}
stdhead();
$secs = 1*86400;
mysql_query("DELETE FROM referer WHERE " . gmtime() . " - UNIX_TIMESTAMP(date) > $secs") or sqlerr(__FILE__, __LINE__);
$res = mysql_query("SELECT COUNT(*) FROM referer");
$row = mysql_fetch_array($res);
$count = $row[0];
$pg = 30;
list($pagertop, $pagerbottom, $limit) = pager(20, $count, "referer.php?");
$res = mysql_query("SELECT date, url,ip FROM referer ORDER BY date DESC $limit") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) == 0)
    echo("<b>Referer is empty</b>\n");
  else
  {
echo $pagertop;
 echo("<table border=1 cellspacing=0 width=95% cellpadding=5>\n");
  echo("<tr><td class=tabletitle align=left><b>Date</b></td><td class=tabletitle align=left><b>Time</b></td><td class=tabletitle align=left><b>Url</b></td><td class=tabletitle align=left><b>Ip</b></td></tr>\n");
 while ($arr = mysql_fetch_assoc($res))
 {
   $date = substr($arr['date'], 0, strpos($arr['date'], " "));
   $time = substr($arr['date'], strpos($arr['date'], " ") + 1);
   echo("<tr class=tableb><td><font color=black>$date</td><td><font color=black>$time</td><td align=left><font color=black>".htmlspecialchars($arr['url'])."</font><td align=left><font color=black>".htmlspecialchars($arr['ip'])."</font></font></font></td></tr>\n");
 }
 echo("</table><p></p>");
  echo("<form method=post action=referer.php><tr><td colspan=2 align=center><input type=submit name='delete' class='groovybutton' value='Delete'></td></tr>");
}

echo $pagerbottom;
echo("<p>Times are in GMT.</p>\n");
stdfoot();

?>