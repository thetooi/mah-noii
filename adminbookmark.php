<?php
require "include/functions.php";
require_once("include/pprotect.php");
dbconn(true);
loggedinorreturn();
//referer();
if (get_user_class() < UC_MODERATOR) stderr("Error", "Permission denied");
stdhead("Staff Bookmarks");
begin_main_frame();

$addbookmark = number_format(get_row_count("users", "WHERE addbookmark='yes'"));
begin_frame("In total ($addbookmark)", true);
begin_table();
?>
<table cellpadding="4" cellspacing="1" border="0" style="width:720px" class="tableinborder" ><tr><td class="tabletitle">ID</td><td class="tabletitle" align="left">Username</td><td class="tabletitle" align="left">Suspicion</td><td class="tabletitle" align="left">Uploaded</td><td class="tabletitle" align="left">Downloaded</td><td class="tabletitle" align="left">Ratio</td></tr>
<?

$res=mysql_query("SELECT id,username,bookmcomment,uploaded,downloaded FROM users WHERE addbookmark='yes' ORDER BY id") or print(mysql_error());


while ($arr = @mysql_fetch_assoc($res)) {
if($arr["downloaded"] != 0){
$ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
} else {
$ratio="---";
}
$ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";
$uploaded = mksize($arr["uploaded"]);
$downloaded = mksize($arr["downloaded"]);
$uploaded = str_replace(" ", "<br>", mksize($arr["uploaded"]));
$downloaded = str_replace(" ", "<br>", mksize($arr["downloaded"]));

echo "<tr><td class=tablea >" . $arr[id] . "</td><td class=tablea align=\"left\"><b><a href=userdetails.php?id=" . $arr[id] . ">". $arr[username] . "</b></td><td class=tablea align=\"left\">" . $arr[bookmcomment] . "</a></td><td class=tablea align=\"left\">" . $uploaded . "</td></a></td><td class=tablea align=\"left\">" .$downloaded. "</td><td class=tablea align=\"left\">$ratio</td></tr>";
}
end_frame();
end_table();
end_main_frame();
  stdfoot();

?>
