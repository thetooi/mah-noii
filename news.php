<?php
require "include/functions.php";
require_once("include/pprotect.php");
dbconn();
loggedinorreturn();
parked();
//referer();
if (get_user_class() < UC_ADMINISTRATOR) stderr("Error", "Permission denied");
$action = isset($_GET["action"]) ?$_GET["action"] : '';
////////////////////Delete news//////////////////////////////////////////////////////
if ($action == 'delete')
{
$newsid = (int)$_GET["newsid"];
if (!is_valid_id($newsid))
stderr("Error", "Invalid ID.");
$returnto = htmlentities($_GET["returnto"]);
isset($_GET['sure']) && $sure = safechar($_GET['sure']);
if (!$sure)
stderr("Confirm Delete","Do you really want to delete this news entry? Click\n" .
"<a href=?newsid=$newsid&action=delete&sure=1&h=$hash>here</a> if you are sure.", FALSE);
mysql_query("DELETE FROM news WHERE id=$newsid") or sqlerr(__FILE__, __LINE__);
if ($returnto != "")
header("Location: $returnto");
else
$warning = "News item was deleted successfully.";
}
//   Add News Item    /////////////////////////////////////////////////////////

if ($action == 'add')
{
$body =mysql_escape_string( htmlspecialchars( $_POST["body"]));
if (!$body)
stderr("Error","The news item cannot be empty!");
$added =mysql_escape_string( htmlspecialchars( $_POST["added"]));
if (!$added)
$added = sqlesc(get_date_time());
mysql_query("INSERT INTO news (userid, added, body) VALUES (".
 $CURUSER['id'] . ", $added, " . sqlesc($body) . ")") or sqlerr(__FILE__, __LINE__);
mysql_affected_rows() == 1 ?$warning = "News entry was added successfully." : stderr("oopss","Something's wrong !! .");
}
//   Edit News Item    ////////////////////////////////////////////////////////

if ($action == 'edit')
{
$newsid = (int)$_GET["newsid"];
if (!is_valid_id($newsid))
stderr("Error","Invalid news item ID.");
$res = mysql_query("SELECT * FROM news WHERE id=$newsid") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) != 1)
stderr("Error", "No news item with that ID .");
$arr = mysql_fetch_assoc($res);
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
$body =mysql_escape_string( htmlspecialchars( $_POST['body']));
if ($body == "")
stderr("Error", "Body cannot be empty!");
$body = sqlesc($body);
$editedat = sqlesc(get_date_time());
mysql_query("UPDATE news SET body=$body WHERE id=$newsid") or sqlerr(__FILE__, __LINE__);
$returnto = htmlentities($_POST['returnto']);
if ($returnto != "")
header("Location: $returnto");
else
$warning = "News item was edited successfully.";
}
else
{
$returnto = htmlentities($_GET['returnto']);
stdhead();
echo("<h1>Edit News Item</h1>\n");
echo("<form method=post action=?action=edit&newsid=$newsid>\n");
echo("<table border=1 cellspacing=0 cellpadding=5>\n");
echo("<tr><td style='padding: 10px'>\n");
?>
<textarea style="visibility:hidden;position:absolute;top:0;left:0;" name="body" id="bbcode_holder" rows="1" cols="1" tabindex="2"><?php print stripslashes($arr[body]); ?></textarea>
<style type='text/css'>@import url(richedit/styles/office2007/style.css);</style>
<script language="JavaScript" type="text/javascript" src="richedit/editor.js?version=4.1"></script>
<script language="JavaScript" type="text/javascript">
var getdata =document.getElementById("bbcode_holder").value;
Instantiate("max","editor", getdata , "530px", "200px");
function get_hoteditor_data(){
setCodeOutput();
var bbcode_output=document.getElementById("hoteditor_bbcode_ouput_editor").value;//Output to BBCode
document.getElementById("bbcode_holder").value = bbcode_output;
document.form1.submit();
}
</script>
<?
echo("<tr><td align=center><input type=submit value='Ok' class=groovybutton name=B1 onclick=get_hoteditor_data(); class=btn></td></tr>\n");
echo("</table></form><br><br>\n");
stdfoot();
die;
  }
}
//   Other Actions and followup    ////////////////////////////////////////////
stdhead("Site News");
echo("<h1>Submit News Item</h1>\n");
if ($warning)
echo("<p><font size=-3>($warning)</font></p>");
echo("<form method=post action=?action=add>\n");
echo("<table border=1 cellspacing=0 cellpadding=5>\n");
echo("<tr><td style='padding: 10px'>\n");
?>
<textarea style="visibility:hidden;position:absolute;top:0;left:0;" name="body" id="bbcode_holder" rows="1" cols="1" tabindex="2"><?php print stripslashes($_POST[body]); ?></textarea>
				<style type='text/css'>@import url(richedit/styles/office2007/style.css);</style>
				<script language="JavaScript" type="text/javascript" src="richedit/editor.js?version=4.1"></script>
				<script language="JavaScript" type="text/javascript">
					var getdata =document.getElementById("bbcode_holder").value;
					Instantiate("max","editor", getdata , "530px", "200px");

					function get_hoteditor_data(){
						setCodeOutput();
						var bbcode_output=document.getElementById("hoteditor_bbcode_ouput_editor").value;//Output to BBCode
						document.getElementById("bbcode_holder").value = bbcode_output;
						document.form1.submit();
					}
					</script>
<?
echo("<tr><td align=center><input type=submit value='Ok' class=groovybutton name=B1 onclick=get_hoteditor_data(); class=btn></td></tr>\n");
echo("</table></form><br><br>\n");
$res = mysql_query("SELECT * FROM news ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0)
{
begin_main_frame();
begin_frame();
while ($arr = mysql_fetch_assoc($res))
{
$newsid = $arr["id"];
$body = $arr["body"];
$userid = $arr["userid"];
$added = $arr["added"] . " GMT (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]))) . " ago)";
$res2 = mysql_query("SELECT username, donor FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__);
$arr2 = mysql_fetch_assoc($res2);
$postername = $arr2["username"];
if ($postername == "")
$by = "unknown[$userid]";
else
$by = "<a href=userdetails.php?id=$userid><b>$postername</b></a>" .
($arr2["donor"] == "yes" ? "<img src=\"{$pic_base_url}star.gif\" alt='Donor'>" : "");
echo("<p class=sub><table border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>");
echo("$added&nbsp;---&nbsp;by&nbsp$by");
echo(" - [<a href=?action=edit&newsid=$newsid><b>Edit</b></a>]");
echo(" - [<a href=?action=delete&newsid=$newsid><b>Delete</b></a>]");
echo("</td></tr></table></p>\n");
begin_table(true);
print stripslashes(BBCodeToHTML($body));
end_table();
}
end_frame();
end_main_frame();
}
else
 stdmsg("Sorry", "No recent news entrys available!!");
stdfoot();
die;
?>