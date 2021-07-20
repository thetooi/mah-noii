<?
require "include/functions.php";
if (!mkglobal("id"))
	die();

$id = (int) $id;
if (!$id)
	die();
dbconn();
loggedinorreturn();
//referer();
parked();
$res = mysql_query("SELECT * FROM torrents WHERE id = $id");
$row = mysql_fetch_array($res);
if (!$row)
	die();

stdhead("Edit torrent \"" . $row["name"] . "\"");

if (!isset($CURUSER) || ($CURUSER["id"] != $row["owner"] && get_user_class() < UC_MODERATOR)) {
	echo("<h1>Can't edit this torrent</h1>\n");
	echo("<p>You're not the rightful owner, or you're not <a href=\"login.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;nowarn=1\">logged in</a> properly.</p>\n");
}
else {
	echo("<form name=editupload method=post action=takeedit.php enctype=multipart/form-data>\n");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
	if (isset($_GET["returnto"]))
	echo("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($_GET["returnto"]) . "\" />\n");
	 echo("<i>Note torrent details page update are 1 minutes</i>");
	echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\">\n");
	tr("Torrent name", "<input type=\"text\" name=\"name\" value=\"" . htmlspecialchars($row["name"]) . "\" size=\"80\" />", 1);
	tr("NFO file", "<input type=radio name=nfoaction value='keep' checked>Keep current<br>".
	"<input type=radio name=nfoaction value='update'>Update:<br><input type=file name=nfo size=80>", 1);
if ((strpos($row["ori_descr"], "<") === false) || (strpos($row["ori_descr"], "&lt;") !== false))
  $c = "";
else
  $c = " checked";
echo("<tr><td class=rowhead style='padding: 10px'>Description</td><td align=center style='padding: 3px'>");
 textbbcode("editupload","descr","$row[ori_descr]");
echo("</td>\n");
	$s = "<select name=\"type\">\n";

	$cats = genrelist();
	foreach ($cats as $subrow) {
		$s .= "<option value=\"" . $subrow["id"] . "\"";
		if ($subrow["id"] == $row["category"])
			$s .= " selected=\"selected\"";
		$s .= ">" . htmlspecialchars($subrow["name"]) . "</option>\n";
	}

	$s .= "</select>\n";
	tr("Type", $s, 1);
	tr("Visible", "<input type=\"checkbox\" name=\"visible\"" . (($row["visible"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> Visible on main page<br /><table border=0 cellspacing=0 cellpadding=0 width=420><tr><td class=embedded>Note that the torrent will automatically become visible when there's a seeder, and will become automatically invisible (dead) when there has been no seeder for a while. Use this switch to speed the process up manually. Also note that invisible (dead) torrents can still be viewed or searched for, it's just not the default.</td></tr></table>", 1);

if (get_user_class() > UC_MODERATOR)
{
tr("Force Visible", "<input type=\"checkbox\" name=\"forcevisible\"" . (($row["forcevisible"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> Visible on main page<br /><table border=0 cellspacing=0 cellpadding=0 width=420><tr><td class=embedded>Note that the torrent will be forced visible when there are no seeders, and will never become invisible (dead) when there has been no seeder for a while. Please remember to turn this option off! This is a temporary feature that was requested. It is pretty much worthless so I will probably remove it soon. </td></tr></table>", 1);
}
	if ($CURUSER["admin"] == "yes")
		tr("Banned", "<input type=\"checkbox\" name=\"banned\"" . (($row["banned"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" /> Banned", 1);

	echo("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" class=groovybutton value='Edit it!' style='height: 25px; width: 100px'> <input type=reset class=groovybutton value='Revert changes' style='height: 25px; width: 100px'></td></tr>\n");
	echo("</table>\n");
	echo("</form>\n");
	echo("<p>\n");
	echo("<form method=\"post\" action=\"delete.php\">\n");
  echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
  echo("<tr><td class=colhead style='background-color: #F5F4EA;padding-bottom: 5px' colspan=\"2\"><b>Delete torrent.</b> Reason:</td></tr>");
  echo("<td><input name=\"reasontype\" type=\"radio\" value=\"1\">&nbsp;Dead </td><td> 0 seeders, 0 leechers = 0 peers total</td></tr>\n");
  echo("<tr><td><input name=\"reasontype\" type=\"radio\" value=\"2\">&nbsp;Dupe</td><td><input type=\"text\" size=\"40\" name=\"reason[]\"></td></tr>\n");
  echo("<tr><td><input name=\"reasontype\" type=\"radio\" value=\"3\">&nbsp;Nuked</td><td><input type=\"text\" size=\"40\" name=\"reason[]\"></td></tr>\n");
  echo("<tr><td><input name=\"reasontype\" type=\"radio\" value=\"4\">&nbsp;TB rules</td><td><input type=\"text\" size=\"40\" name=\"reason[]\">(req)</td></tr>");
  echo("<tr><td><input name=\"reasontype\" type=\"radio\" value=\"5\" checked>&nbsp;Other:</td><td><input type=\"text\" size=\"40\" name=\"reason[]\">(req)</td></tr>\n");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
	if (isset($_GET["returnto"]))
		echo("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($_GET["returnto"]) . "\" />\n");
  echo("<td colspan=\"2\" align=\"center\"><input type=submit class=groovybutton value='Delete it!' style='height: 25px'></td></tr>\n");
  echo("</table>");
	echo("</form>\n");
	echo("</p>\n");
}

stdfoot();
?>