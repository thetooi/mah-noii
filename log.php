<?php
 require "include/functions.php";
dbconn(false);
loggedinorreturn();
parked();
if (get_user_class() < UC_UPLOADER) stderr("Error", "Permission denied");
//referer();
stdhead();
$secs = 24 * 60 * 60;
mysql_query("DELETE FROM sitelog WHERE " . gmtime() . " - UNIX_TIMESTAMP(added) > $secs") or sqlerr(__FILE__, __LINE__);
$res = mysql_query("SELECT COUNT(*) FROM sitelog");
$row = mysql_fetch_array($res);
$count = $row[0];
$pg = 30;
list($pagertop, $pagerbottom, $limit) = pager(20, $count, "log.php?");
$res = mysql_query("SELECT added, txt FROM sitelog ORDER BY added DESC $limit") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) == 0)
    echo("<b>Log is empty</b>\n");
  else
  {
echo $pagertop;
 echo("<table border=1 cellspacing=0 width=95% cellpadding=5>\n");
 echo("<tr><td class=tabletitle align=left>Date</td><td class=tabletitle align=left>Time</td><td class=tabletitle align=left>Event</td></tr>\n");
 while ($arr = mysql_fetch_assoc($res))
 {
$color = 'white';
if (strpos($arr['txt'],'was created')) $color = "#CC9966";
if (strpos($arr['txt'],'was invited by')) $color = "#CC9966";
if (strpos($arr['txt'],'was invited to the site.')) $color = "#CC9966";
if (strpos($arr['txt'],'was deleted by')) $color = "#CC6666";
if (strpos($arr['txt'],'was updated by')) $color = "#6699FF";
if (strpos($arr['txt'],'was edited by')) $color = "#BBaF9B";
   $date = substr($arr['added'], 0, strpos($arr['added'], " "));
   $time = substr($arr['added'], strpos($arr['added'], " ") + 1);
   echo("<tr class=tableb><td style=background-color:$color><font color=black>$date</td><td style=background-color:$color><font color=black>$time</td><td style=background-color:$color align=left><font color=black>".$arr['txt']."</font></font></font></td></tr>\n");
 }
 echo("</table>");
}
echo $pagerbottom;
echo("<p>Times are in GMT.</p>\n");
stdfoot();

?>