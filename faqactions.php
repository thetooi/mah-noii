<?
ini_set("magic_quotes_gpc", "1");
require "include/functions.php";
dbconn();
loggedinorreturn();
//referer();
if (get_user_class() < UC_SYSOP) {
stdhead("FAQ Management");
begin_main_frame();
echo("<h1>Only Administrators and above can modify the FAQ, sorry.</h1>");
end_main_frame();
stdfoot();
die();
}

// ACTION: reorder - reorder sections and items
if ($_GET[action] == "reorder") {
foreach($_POST[order] as $id => $position) mysql_query("UPDATE `faq` SET `order`='$position' WHERE id='$id'") or sqlerr();
header("Refresh: 0; url=faqmanage.php");
}

// ACTION: edit - edit a section or item
elseif ($_GET[action] == "edit" && isset($_GET[id])) {
stdhead("FAQ Management");
begin_main_frame();
echo("<h1 align=\"center\">Edit Section or Item</h1>");

$res = mysql_query("SELECT * FROM `faq` WHERE `id`='$_GET[id]' LIMIT 1");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) {
 $arr[question] = htmlspecialchars($arr[question]);
 $arr[answer] = htmlspecialchars($arr[answer]);
 if ($arr[type] == "item") {
 echo("<form method=\"post\" action=\"faqactions.php?action=edititem\">");
 echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
 echo("<tr><td>ID:</td><td>$arr[id] <input type=\"hidden\" name=\"id\" value=\"$arr[id]\" /></td></tr>\n");
 echo("<tr><td>Question:</td><td><input style=\"width: 300px;\" type=\"text\" name=\"question\" value=\"$arr[question]\" /></td></tr>\n");
 echo("<tr><td style=\"vertical-align: top;\">Answer:</td><td><textarea style=\"width: 300px; height=100px;\" name=\"answer\">$arr[answer]</textarea></td></tr>\n");
  if ($arr[flag] == "0")echo("<tr><td>Status:</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\" selected=\"selected\">Hidden</option><option value=\"1\" style=\"color: #000000;\">Normal</option><option value=\"2\" style=\"color: #0000FF;\">Updated</option><option value=\"3\" style=\"color: #008000;\">New</option></select></td></tr>");
  elseif ($arr[flag] == "2")echo("<tr><td>Status:</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">Hidden</option><option value=\"1\" style=\"color: #000000;\">Normal</option><option value=\"2\" style=\"color: #0000FF;\" selected=\"selected\">Updated</option><option value=\"3\" style=\"color: #008000;\">New</option></select></td></tr>");
  elseif ($arr[flag] == "3")echo("<tr><td>Status:</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">Hidden</option><option value=\"1\" style=\"color: #000000;\">Normal</option><option value=\"2\" style=\"color: #0000FF;\">Updated</option><option value=\"3\" style=\"color: #008000;\" selected=\"selected\">New</option></select></td></tr>");
  elseecho("<tr><td>Status:</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">Hidden</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">Normal</option><option value=\"2\" style=\"color: #0000FF;\">Updated</option><option value=\"3\" style=\"color: #008000;\">New</option></select></td></tr>");
 echo("<tr><td>Category:</td><td><select style=\"width: 300px;\" name=\"categ\" />");
  $res2 = mysql_query("SELECT `id`, `question` FROM `faq` WHERE `type`='categ' ORDER BY `order` ASC");
  while ($arr2 = mysql_fetch_array($res2, MYSQL_BOTH)) {
   $selected = ($arr2[id] == $arr[categ]) ? " selected=\"selected\"" : "";
  echo("<option value=\"$arr2[id]\"". $selected .">$arr2[question]</option>");
  }
 echo("</td></tr>\n");
 echo("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"edit\" value=\"Edit\" style=\"width: 60px;\"></td></tr>\n");
 echo("</table>");
 }
 elseif ($arr[type] == "categ") {
 echo("<form method=\"post\" action=\"faqactions.php?action=editsect\">");
 echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
 echo("<tr><td>ID:</td><td>$arr[id] <input type=\"hidden\" name=\"id\" value=\"$arr[id]\" /></td></tr>\n");
 echo("<tr><td>Title:</td><td><input style=\"width: 300px;\" type=\"text\" name=\"title\" value=\"$arr[question]\" /></td></tr>\n");
  if ($arr[flag] == "0")echo("<tr><td>Status:</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\" selected=\"selected\">Hidden</option><option value=\"1\" style=\"color: #000000;\">Normal</option></select></td></tr>");
  elseecho("<tr><td>Status:</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">Hidden</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">Normal</option></select></td></tr>");
 echo("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"edit\" value=\"Edit\" style=\"width: 60px;\"></td></tr>\n");
 echo("</table>");
 }
}

end_main_frame();
stdfoot();
}

// subACTION: edititem - edit an item
elseif ($_GET[action] == "edititem" && $_POST[id] != NULL && $_POST[question] != NULL && $_POST[answer] != NULL && $_POST[flag] != NULL && $_POST[categ] != NULL) {
$question =($_POST[question]);
$answer = ($_POST[answer]);
mysql_query("UPDATE `faq` SET `question`='$question', `answer`='$answer', `flag`='$_POST[flag]', `categ`='$_POST[categ]' WHERE id='$_POST[id]'") or sqlerr();
header("Refresh: 0; url=faqmanage.php");
}

// subACTION: editsect - edit a section
elseif ($_GET[action] == "editsect" && $_POST[id] != NULL && $_POST[title] != NULL && $_POST[flag] != NULL) {
$title = htmlspecialchars($_POST[title]);
mysql_query("UPDATE `faq` SET `question`='$title', `answer`='', `flag`='$_POST[flag]', `categ`='0' WHERE id='$_POST[id]'") or sqlerr();
header("Refresh: 0; url=faqmanage.php");
}

// ACTION: delete - delete a section or item
elseif ($_GET[action] == "delete" && isset($_GET[id])) {
if ($_GET[confirm] == "yes") {
 mysql_query("DELETE FROM `faq` WHERE `id`='$_GET[id]' LIMIT 1") or sqlerr();
 header("Refresh: 0; url=faqmanage.php");
}
else {
 stdhead("FAQ Management");
 begin_main_frame();
echo("<h1 align=\"center\">Confirmation required</h1>");
echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" width=\"95%\">\n<tr><td align=\"center\">Please click <a href=\"faqactions.php?action=delete&id=$_GET[id]&confirm=yes\">here</a> to confirm.</td></tr>\n</table>\n");
 end_main_frame();
 stdfoot();
}
}

// ACTION: additem - add a new item
elseif ($_GET[action] == "additem" && $_GET[inid]) {
stdhead("FAQ Management");
begin_main_frame();
echo("<h1 align=\"center\">Add Item</h1>");
echo("<form method=\"post\" action=\"faqactions.php?action=addnewitem\">");
echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
echo("<tr><td>Question:</td><td><input style=\"width: 300px;\" type=\"text\" name=\"question\" value=\"\" /></td></tr>\n");
echo("<tr><td style=\"vertical-align: top;\">Answer:</td><td><textarea style=\"width: 300px; height=100px;\" name=\"answer\"></textarea></td></tr>\n");
echo("<tr><td>Status:</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">Hidden</option><option value=\"1\" style=\"color: #000000;\">Normal</option><option value=\"2\" style=\"color: #0000FF;\">Updated</option><option value=\"3\" style=\"color: #008000;\" selected=\"selected\">New</option></select></td></tr>");
echo("<tr><td>Category:</td><td><select style=\"width: 300px;\" name=\"categ\" />");
$res = mysql_query("SELECT `id`, `question` FROM `faq` WHERE `type`='categ' ORDER BY `order` ASC");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) {
 $selected = ($arr[id] == $_GET[inid]) ? " selected=\"selected\"" : "";
echo("<option value=\"$arr[id]\"". $selected .">$arr[question]</option>");
}
echo("</td></tr>\n");
echo("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"edit\" value=\"Add\" style=\"width: 60px;\"></td></tr>\n");
echo("</table>");
}

// ACTION: addsection - add a new section
elseif ($_GET[action] == "addsection") {
stdhead("FAQ Management");
begin_main_frame();
echo("<h1 align=\"center\">Add Section</h1>");
echo("<form method=\"post\" action=\"faqactions.php?action=addnewsect\">");
echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\">\n");
echo("<tr><td>Title:</td><td><input style=\"width: 300px;\" type=\"text\" name=\"title\" value=\"\" /></td></tr>\n");
echo("<tr><td>Status:</td><td><select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">Hidden</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">Normal</option></select></td></tr>");
echo("<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"edit\" value=\"Add\" style=\"width: 60px;\"></td></tr>\n");
echo("</table>");
}

// subACTION: addnewitem - add a new item to the db
elseif ($_GET[action] == "addnewitem" && $_POST[question] != NULL && $_POST[answer] != NULL && $_POST[flag] != NULL && $_POST[categ] != NULL) {
$question =($_POST[question]);
$answer =($_POST[answer]);
$res = mysql_query("SELECT MAX(`order`) FROM `faq` WHERE `type`='item' AND `categ`='$_POST[categ]'");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) $order = $arr[0] + 1;
mysql_query("INSERT INTO `faq` (`type`, `question`, `answer`, `flag`, `categ`, `order`) VALUES ('item', '$question', '$answer', '$_POST[flag]', '$_POST[categ]', '$order')") or sqlerr();
header("Refresh: 0; url=faqmanage.php");
}

// subACTION: addnewsect - add a new section to the db
elseif ($_GET[action] == "addnewsect" && $_POST[title] != NULL && $_POST[flag] != NULL) {
$title =($_POST[title]);
$res = mysql_query("SELECT MAX(`order`) FROM `faq` WHERE `type`='categ'");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) $order = $arr[0] + 1;
mysql_query("INSERT INTO `faq` (`type`, `question`, `answer`, `flag`, `categ`, `order`) VALUES ('categ', '$title', '', '$_POST[flag]', '0', '$order')") or sqlerr();
header("Refresh: 0; url=faqmanage.php");
}

else header("Refresh: 0; url=faqmanage.php");
?>