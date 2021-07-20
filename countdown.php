<?php
require ("include/functions.php");
require_once("include/pprotect.php");
dbconn();
loggedinorreturn();

//referer();
if (get_user_class() < UC_SYSOP) stderr("Error", "Permission denied");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{if ($_POST["delete"])
mysql_query("DELETE FROM countdow");
header("Location: $BASEURL/countdown.php");

if ($_POST["month"] == "" || $_POST["day"] == "" || $_POST["year"] == "" || $_POST["countdow"] == "")
stderr("Error", "Missing form data.");

$month = htmlspecialchars($_POST["month"]);
$day = htmlspecialchars($_POST["day"]);
$year = htmlspecialchars($_POST["year"]);
$countdow = htmlspecialchars($_POST["countdow"]);
$sql = "INSERT INTO countdow (month, day, year, countdow) VALUES ('$month', '$day', '$year', '$countdow')";
$result = mysql_query($sql);
header("Location: $BASEURL/countdown.php");
die;
}
stdhead("Countdown");
$res = mysql_query("SELECT month, day, year, countdow FROM countdow") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) == 0)
echo("<h1>Add countdown</h1>
<form method=post action=countdown.php>
<table border=1 width=95% cellspacing=0 cellpadding=5>
<tr><td class=rowhead>Month of the countdown</td><td><input type=text name=month size=1></td></tr>
<tr><td class=rowhead>Day of the countdown</td><td><input type=text name=day size=1></td></tr>
<tr><td class=rowhead>Year of the countdown</td><td><input type=text name=year size=4></td></tr>
<tr><td class=rowhead>Countdown to</td><td><input type=text name=countdow size=70></td></tr></select></td></tr><tr><td colspan=2 align=center><input type=submit class='groovybutton' value='Okay' class=btn></td></tr>
</table>
</form>\n");
 else
  {
while ($arr = mysql_fetch_assoc($res))
 {echo("<table border=1 cellspacing=0 width=95% cellpadding=5>\n");
echo("<tr><td align=left><b>Month</b></td><td align=left><b>Day</b></td><td align=left><b>Year</b></td><td align=left><b>Countdow to</b></td></tr>\n");
echo("<tr class=tableb><td style=background-color:$color><font color=black>".htmlspecialchars($arr['month'])."</td><td style=background-color:$color><font color=black>".htmlspecialchars($arr['day'])."</td><td style=background-color:$color align=left><font color=black>".htmlspecialchars($arr['year'])."</font><td style=background-color:$color align=left><font color=black>".htmlspecialchars($arr['countdow'])."</font></font></font></td></tr>\n");
 }
 echo("</table><p></p>");
 echo("<form method=post action=countdown.php><tr><td colspan=2 align=center><input type=submit name='delete' class='groovybutton' value='Delete'></td></tr>");
}
?>
<?php stdfoot(); ?>