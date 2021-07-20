<?
require_once("include/functions.php");
require_once("include/pprotect.php");
dbconn(false);
loggedinorreturn();
parked();
//referer();

if (get_user_class() < UC_MODERATOR) stderr("Error", "Permission denied");

$action =htmlspecialchars($_GET["action"]);

// View applications

if (!$action || $action == "show") {

if ($action == "show")
$hide = "[<a href=/uploadapps.php>Hide accepted/rejected</a>]";
else {
$hide = "[<a href=/uploadapps.php?action=show>Show accepted/rejected</a>]";
$where = "WHERE status = 'pending'";
$where1 = "WHERE uploadapp.status = 'pending'";
}

$res = mysql_query("SELECT count(id) FROM uploadapp $where") or sqlerr(__FILE__, __LINE__);
$row = mysql_fetch_array($res);
$url = " .$_SERVER[PHP_SELF]?";
$count = $row[0];
$perpage = 25;
list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $url);

stdhead("Uploader applications");
echo("<h1 align=center>Uploader applications</h1>");
if ($count == 0) {
echo("<table class=main width=730 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>\n");
echo("<div align=right><p><font class=small>$hide</font></p></div>");
echo("<table width=100% border=1 cellspacing=0 cellpadding=5><tr><td>");
echo("<p align=center>There are currently no uploader applications</p>");
echo("</td></tr></table>");
echo("</td></tr></table>");
} else {
echo("<table class=main width=730 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>\n");
echo $pagertop;
echo("<div align=right><p><font class=small>$hide</font></p></div>");
echo("<table width=100% border=1 cellspacing=0 cellpadding=5 align=center>\n");
echo("<tr>\n");
echo("<td class=colhead align=left>Applied</td>\n");
echo("<td class=colhead align=left>Application</td>\n");
echo("<td class=colhead align=left>Username</td>\n");
echo("<td class=colhead align=left>Member for</td>\n");
echo("<td class=colhead align=left>Class</td>\n");
echo("<td class=colhead align=left>Uploaded</td>\n");
echo("<td class=colhead align=left>Ratio</td>\n");
echo("<td class=colhead align=left>Status</td>\n");
echo("<td class=colhead align=left>Delete</td>\n");
echo("</tr>\n");
echo("<form method=post action=?action=takeappdelete>");

$res = mysql_query("SELECT uploadapp.*, users.id AS uid, users.username, users.class, users.added, users.uploaded, users.downloaded FROM uploadapp INNER JOIN users on uploadapp.userid = users.id $where1 $limit") or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res))
{
if ($arr["status"] == "accepted")
$status = "<font color=green>Accepted</font>";
elseif ($arr["status"] == "rejected")
$status = "<font color=red>Rejected</font>";
else
$status = "<font color=blue>Pending</font>";
$membertime = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));
$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["applied"]));
$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["applied"]));
if ($arr["downloaded"] > 0) {
    $ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
  } elseif ($arr["uploaded"] > 0)
    $ratio = "Inf.";
  else
    $ratio = "---";

echo("<tr>");
echo("<td>$elapsed ago</td>");
echo("<td><a href=?action=viewapp&id=$arr[id]>View application</a></td>\n");
echo("<td><a href=userdetails.php?id=$arr[uid]>$arr[username]</a></td>\n");
echo("<td>$membertime</td>\n");
echo("<td>".get_user_class_name($arr["class"])."</td>\n");
echo("<td>".mksize($arr["uploaded"])."</td>\n");
echo("<td>$ratio</td>\n");
echo("<td>$status</td>\n");
echo("<td><input type=\"checkbox\" name=\"deleteapp[]\" value=\"" . $arr[id] . "\" /></td>\n");
echo("</tr>\n");
}
echo("</table>\n");
echo("<p align=right><input type=submit value=Delete></p>");
echo("</form>");
echo $pagerbottom;
echo("</td></tr></table>\n");
}
stdfoot();
}

// View application

if ($action == "viewapp") {

$id =htmlspecialchars( $_GET["id"]);
$res = mysql_query("SELECT uploadapp.*, users.id AS uid, users.username, users.class, users.added, users.uploaded, users.downloaded FROM uploadapp INNER JOIN users on uploadapp.userid = users.id WHERE uploadapp.id=$id") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res);
$membertime = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));
stdhead("Uploader applications");
echo("<h1 align=center>Uploader application</h1>");
echo("<table width=730 border=1 cellspacing=0 cellpadding=5>");
echo("<tr><td class=rowhead width=25%>My username is</td><td><a href=userdetails.php?id=$arr[uid]>$arr[username]</a></td></tr>");
echo("<tr><td class=rowhead>I have joined at</td><td>$arr[added] ($membertime ago)</td></tr>");
echo("<tr><td class=rowhead>My upload amount is</td><td>".mksize($arr["uploaded"])."</td></tr>");
echo("<tr><td class=rowhead>My download amount is</td><td>".mksize($arr["downloaded"])."</td></tr>");
echo("<tr><td class=rowhead>My ratio is </td><td>$ratio</td></tr>");
echo("<tr><td class=rowhead>I am connectable</td><td>$arr[connectable]</td></tr>");
echo("<tr><td class=rowhead>My current userclass is</td><td>".get_user_class_name($arr["class"])."</td></tr>");
echo("<tr><td class=rowhead>I have applied at</td><td>$arr[applied] ($elapsed ago)</td></tr>");
echo("<tr><td class=rowhead>My upload speed is</td><td>$arr[speed]</td></tr>");
echo("<tr><td class=rowhead>What I have to offer</td><td>$arr[offer]</td></tr>");
echo("<tr><td class=rowhead>Why I should be promoted</td><td>$arr[reason]</td></tr>");
echo("<tr><td class=rowhead>I am uploader at other sites</td><td>$arr[sites]</td></tr>");
if ($arr["sitenames"] != "")
echo("<tr><td class=rowhead>Those sites are</td><td>$arr[sitenames]</td></tr>");
echo("<tr><td class=rowhead>I have scene access</td><td>$arr[scene]</td></tr>");
echo("<tr><td colspan=2>I know how to create, upload and seed torrents: <b>$arr[creating]</b><br>I understand that I have to keep seeding my torrents until there are at least two other seeders: <b>$arr[seeding]</b></td></tr>");
if ($arr["status"] == "pending")
echo("<tr><td align=center colspan=2><form method=post action=?action=acceptapp><input name=id type=hidden value=$arr[id]><b>Note: (optional)</b><br><input type=text name=note size=40> <input type=submit value=Accept style='height: 20px'></form><br><form method=post action=?action=rejectapp><input name=id type=hidden value=$arr[id]><b>Reason: (optional)</b><br><input type=text name=reason size=40> <input type=submit value=Reject style='height: 20px'></form></td></tr>");
else
echo("<tr><td colspan=2 align=center>Application ".($arr["status"] == "accepted" ? "accepted" : "rejected")." by <b>$arr[moderator]</b><br>Comment: $arr[comment]</td></tr>");
echo("</table>");
echo("<p align=center><a href=uploadapps.php>Return to uploader applications page</a></p>");
stdfoot();
}

// Accept application

if ($action == "acceptapp") {

$id =(int)$_POST["id"];
if (!is_valid_id($id))
stderr("Error", "It appears that there is no uploader application with that ID.");

$res = mysql_query("SELECT uploadapp.id, users.id AS uid FROM uploadapp INNER JOIN users on uploadapp.userid = users.id WHERE uploadapp.id=$id") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res);

$note = htmlspecialchars($_POST["note"]);

$msg = "Congratulations, your uploader application has been accepted! You have been promoted to Uploader and you are now able to upload torrents. Please make sure you have read the guidlines on uploading before you do.\n\nNote: $note";
$dt = sqlesc(get_date_time());
mysql_query("UPDATE uploadapp SET status = 'accepted', comment = ".sqlesc($note).", moderator = ".sqlesc($CURUSER["username"])." WHERE id=$id") or sqlerr(__FILE__, __LINE__);
mysql_query("UPDATE users SET class = 4 WHERE id=$arr[uid]") or sqlerr(__FILE__, __LINE__);
sendPersonalMessage(0, $arr["uid"], "Uploader application has been accepted! ", $msg, PM_FOLDERID_SYSTEM, 0);
stderr("Application accepted", "The application was succesfully accepted. The user has been promoted and has been sent a PM notification. Click <a href=uploadapps.php>here</a> to return to the upload applications page.");
}

// Reject application

if ($action == "rejectapp") {

$id = (int) $_POST["id"];
if (!is_valid_id($id))
stderr("Error", "It appears that there is no uploader application with that ID.");

$res = mysql_query("SELECT uploadapp.id, users.modcomment, users.id AS uid FROM uploadapp INNER JOIN users on uploadapp.userid = users.id WHERE uploadapp.id=$id") or sqlerr(__FILE__, __LINE__);
  $arr = mysql_fetch_assoc($res);

$reason = htmlspecialchars($_POST["reason"]);

$msg = "Sorry, your uploader application has been reject. It appears that you are not qualified enough to become uploader.\n\nReason: $reason";
$dt = sqlesc(get_date_time());
mysql_query("UPDATE uploadapp SET status = 'rejected', comment = ".sqlesc($reason).", moderator = ".sqlesc($CURUSER["username"])." WHERE id=$id") or sqlerr(__FILE__, __LINE__);
sendPersonalMessage(0, $arr["uid"], "Uploader application has been reject! ", $msg, PM_FOLDERID_SYSTEM, 0);
stderr("Application rejected", "The application was succesfully rejected. The user has been sent a PM notification. Click <a href=uploadapps.php>here</a> to return to the upload applications page.");
}

// Delete applications

if ($action == "takeappdelete") {

$res = mysql_query("SELECT id FROM uploadapp WHERE id IN (" . implode(", ", $_POST[deleteapp]) . ")") or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res))
mysql_query("DELETE FROM uploadapp WHERE id=$arr[id]") or sqlerr(__FILE__, __LINE__);
stderr("Deleted", "The upload applications were succesfully deleted. Click <a href=uploadapps.php>here</a> to return to the upload applications page.");
}

?>