<?
require_once "include/functions.php";
dbconn(false);
loggedinorreturn();
parked();
//referer();
if ($CURUSER)
{
 $ss_a = @mysql_fetch_array(@mysql_query("select uri from stylesheets where id=" . $CURUSER["stylesheet"]));
 if ($ss_a) $ss_uri = $ss_a["uri"];
}
if (!$ss_uri)
{
 ($r = mysql_query("SELECT uri FROM stylesheets WHERE id=1")) or die(mysql_error());
 ($a = mysql_fetch_array($r)) or die(mysql_error());
 $ss_uri = $a["uri"];
}
?>

<html>
<head>
<script language=javascript>

function SmileIT(smile,form,text){
    window.opener.document.forms[form].elements[text].value = window.opener.document.forms[form].elements[text].value+" "+smile+" ";
    window.opener.document.forms[form].elements[text].focus();
}
</script>
<title>Clickable Smilies</title>
<link rel="stylesheet" href="/<?=$ss_uri?>" type="text/css">
</head>

<table width="100%" border=1 cellspacing="2" cellpadding="2">
<h2>Smilies</h2>
<tr align=center>
<?
$ctr=0;
global $smilies;
while ((list($code, $url) = each($smilies))) {
   if ($count % 3==0)
      print("\n<tr>");
      print("<td align=center><a href=\"javascript: SmileIT('".str_replace("'","\'",$code)."','".$_GET["form"]."','".$_GET["text"]."')\"><img border=0 src=pic/smilies/".$url."></a></td>");
      $count++;

   if ($count % 3==0)
      print("\n</tr>");
}
?>
</tr>
</table>
<div align="center">
<a class=altlink_green href="javascript: window.close()"><? echo CLOSE; ?></a>
</div>
<?
stdfoot();