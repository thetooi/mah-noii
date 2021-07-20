<?php
require "include/functions.php";
dbconn(true);
require_once("include/pprotect.php");
referer();
if (get_user_class() < UC_MODERATOR) stderr("Error", "Permission denied");
stdhead("Unconfirmed Users");
begin_main_frame();
// ===================================
$unco = number_format(get_row_count("users", "WHERE status='pending'"));
begin_frame("Unconfirmed Users ($unco)", true);
begin_table();
?>
<form method="post" action="takeunco.php">
<tr><td class="colhead">ID</td><td class="colhead" align="left">Username</td><td class="colhead" align="left">e-mail</td><td class="colhead" align="left">Added</td><td class="colhead">Del</td></tr>
<?

$res=mysql_query("SELECT id,username,email,added FROM users WHERE status='pending' ORDER BY id") or print(mysql_error());
// ------------------
while ($arr = @mysql_fetch_assoc($res)) {
echo "<tr><td>" . $arr[id] . "</td><td align=\"left\"><b>" . $arr[username] . "</b></td><td align=\"left\"><a href=mailto:" . $arr[email] . ">" . $arr[email] . "</a></td><td align=\"left\">" . $arr[added] . "</td><td><input type=\"checkbox\" name=\"delusr[]\" value=\"" . $arr[id] . "\" /></td></tr>";
}
?>
<tr><td colspan="5" align="right"><input type="submit" value="Do it!" /></td></tr>
</form>
<?
// ------------------
    end_table();
    end_frame();
// ===================================
end_main_frame();
stdfoot();
?>