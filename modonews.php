<?
require_once("include/functions.php");
require_once("include/pprotect.php");
dbconn(false);
loggedinorreturn();
parked();
//referer();
if (get_user_class() < UC_MODERATOR) stderr("Error", "Permission denied");

if ($_GET["act"] == "newsect")
{
stdhead("Add section");
//echo("<td valign=top style=\"padding: 10px;\" colspan=2 align=center>");
begin_main_frame();

echo("<form method=\"post\" action=\"modonews.php?act=addsect\">");
echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
echo("<tr><td>Title:</td><td><input style=\"width: 400px;\" type=\"text\" name=\"title\"/></td></tr>\n");
echo("<tr><td class=rowhead style='padding: 3px'>News</td><td>");
?>
<textarea style="visibility:hidden;position:absolute;top:0;left:0;" name="text" id="bbcode_holder" rows="1" cols="1" tabindex="2"><?php print stripslashes($_POST[body]); ?></textarea>
				<style type='text/css'>@import url(richedit/styles/office2007/style.css);</style>
				<script language="JavaScript" type="text/javascript" src="richedit/editor.js?version=4.1"></script>
				<script language="JavaScript" type="text/javascript">
					var getdata =document.getElementById("bbcode_holder").value;
					Instantiate("max","editor", getdata , "430px", "200px");

					function get_hoteditor_data(){
						setCodeOutput();
						var bbcode_output=document.getElementById("hoteditor_bbcode_ouput_editor").value;//Output to BBCode
						document.getElementById("bbcode_holder").value = bbcode_output;
						document.form1.submit();
					}
					</script>
<?
echo("<tr><td colspan=\"2\" align=\"center\"><input type=\"radio\" name='public' value=\"yes\" checked>For everybody<input type=\"radio\" name='public' value=\"no\">Registered only (Class: <input type=\"text\" name='class' value=\"0\" size=1>)</td></tr>\n");
echo("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Add\" onclick=get_hoteditor_data(); style=\"width: 60px;\"></td></tr>\n");
echo("</table></form>");
stdfoot();
}
elseif ($_GET["act"]=="addsect"){
$title = sqlesc($_POST["title"]);
$text = sqlesc($_POST["text"]);
$public = sqlesc($_POST["public"]);
$class = sqlesc($_POST["class"]);
mysql_query("insert into onews (title, text, public, class) values($title, $text, $public, $class)") or sqlerr(__FILE__,__LINE__);
header("Refresh: 0; url=modonews.php");
}
elseif ($_GET["act"] == "edit"){
$id =htmlspecialchars( $_POST["id"]);
$res = @mysql_fetch_array(@mysql_query("select * from onews where id='$id'"));
stdhead("Edit news");
//echo("<td valign=top style=\"padding: 10px;\" colspan=2 align=center>");
begin_main_frame();

echo("<form method=\"post\" action=\"modonews.php?act=edited\">");
echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
echo("<tr><td>Title:</td><td><input style=\"width: 400px;\" type=\"text\" name=\"title\" value=\"$res[title]\" /></td></tr>\n");
echo("<tr><td class=rowhead style='padding: 3px'>News</td><td>");
?>
<textarea style="visibility:hidden;position:absolute;top:0;left:0;" name="text" id="bbcode_holder" rows="1" cols="1" tabindex="2"><?php print stripslashes($res[text]); ?></textarea>
				<style type='text/css'>@import url(richedit/styles/office2007/style.css);</style>
				<script language="JavaScript" type="text/javascript" src="richedit/editor.js?version=4.1"></script>
				<script language="JavaScript" type="text/javascript">
					var getdata =document.getElementById("bbcode_holder").value;
					Instantiate("max","editor", getdata , "430px", "200px");

					function get_hoteditor_data(){
						setCodeOutput();
						var bbcode_output=document.getElementById("hoteditor_bbcode_ouput_editor").value;//Output to BBCode
						document.getElementById("bbcode_holder").value = bbcode_output;
						document.form1.submit();
					}
					</script>
<?

echo("<tr><td colspan=\"2\" align=\"center\"><input type=\"radio\" name='public' value=\"yes\" ".($res["public"]=="yes"?"checked":"").">For everybody<input type=\"radio\" name='public' value=\"no\" ".($res["public"]=="no"?"checked":"").">Registered only (Class: <input type=\"text\" name='class' value=\"$res[class]\" size=1>)</td></tr>\n");
echo("<tr><td colspan=\"2\" align=\"center\"><input type=hidden value=$res[id] name=id><input name=B1 onclick=get_hoteditor_data(); type=\"submit\" value=\"Save\" style=\"width: 60px;\"></td></tr>\n");
echo("</table>");
stdfoot();
}
elseif ($_GET["act"]=="edited"){
$id = htmlspecialchars($_POST["id"]);
$title = sqlesc($_POST["title"]);
$text = sqlesc($_POST["text"]);
$public = sqlesc($_POST["public"]);
$class = sqlesc($_POST["class"]);
mysql_query("update onews set title=$title, text=$text, public=$public, class=$class where id=$id") or sqlerr(__FILE__,__LINE__);
header("Refresh: 0; url=modonews.php");
}
else{
$res = mysql_query("select * from onews order by id");
stdhead();
//echo("<td valign=top style=\"padding: 10px;\" colspan=2 align=center>");
echo("<br><table width=95% border=1 cellspacing=0 cellpadding=10>");
echo("<tr><td align=center><a href=modonews.php?act=newsect>Add Section</a></td></tr></table>\n");
while ($arr=mysql_fetch_assoc($res)){
echo("<br><table width=95% border=1 cellspacing=0 cellpadding=10>");
echo("<form method=post action=modonews.php?act=edit&id=><tr><td class=colhead>:: $arr[title]</td></tr><tr><td><ul>\n");
print(stripslashes(BBCodeToHTML($arr["text"])));
echo("</td></tr><tr><td><input type=hidden value=$arr[id] name=id><input type=submit value='Edit'></td></tr></form>");
end_frame();
}
//echo("");
stdfoot();
}
?>