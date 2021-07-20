<?php
require_once("include/functions.php");
dbconn(false);
loggedinorreturn();
parked();
//referer();
stdhead("Upload");
if (get_user_class() < UC_PEASANT)
{
  stdmsg("Sorry...", "Down for maintenance.");
  stdfoot();
  exit;
}
?>
<div align=Center>
<form name=upload enctype="multipart/form-data" action="takeupload.php" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_torrent_size?>" />
<p>The tracker's announce url is <b><?= $announce_urls[0] ?>?passkey=<?= $CURUSER['passkey'] ?></b></p>
<p><b>Description (required if there is no .NFO file)</b></p>
<table border="1" cellspacing="0" cellpadding="10">
<?
tr("Torrent file", "<input type=file name=file size=80>\n", 1);
tr("Torrent name", "<input type=\"text\" name=\"name\" size=\"80\" /><br />(Taken from filename if not specified. <b>Please use descriptive names.</b>)\n", 1);
tr("NFO file", "<input type=file name=nfo size=80><br>\n", 1);
echo("<tr><td class=rowhead style='padding: 3px'>Description</td><td>");
 textbbcode("upload","descr",($quote?(("[quote=".htmlspecialchars($arr["username"])."]".htmlspecialchars(unesc($arr["body"]))."[/quote]")):""));
echo("</td></tr>\n");

$s = "<select name=\"type\">\n<option value=\"0\">(choose one)</option>\n";

$cats = genrelist();
foreach ($cats as $row)
	$s .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";

$s .= "</select>\n";
tr("Type", $s, 1);

?>
<tr><td align="center" colspan="2"><input class=groovybutton type="submit" class=btn value="Do it!" /></td></tr>
</table>
</form>
<?

stdfoot();

?>