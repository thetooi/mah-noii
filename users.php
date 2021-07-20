<?php
require "include/functions.php";
dbconn();
loggedinorreturn();
parked();
//referer();
$search = isset($_GET['search']) ? strip_tags(trim($_GET['search'])) : '';
$class = isset($_GET['class']) ? $_GET['class'] : '-';
if (!is_valid_id($class))
{
	if($class != '-')
	{

	}

	$class = '';
}

if ($search != '' || $class)
{
$query = "username LIKE " . sqlesc("%$search%") . " AND status='confirmed'";
if ($search)
$q = "search=" . safechar($search);
}
else
{
$letter = isset($_GET['letter']) ? trim((string)$_GET["letter"]) : '';
if ($letter == "" || strpos("abcdefghijklmnopqrstuvwxyz", $letter) === false)
$letter = "All";
if (strlen($letter) == 3)
{
$query = "status='confirmed'";
$q = "letter=$letter";
}
elseif (strlen($letter) == 1)
{
$query = " username LIKE '$letter%' AND status='confirmed'";
$q = "letter=$letter";
}
else{
die;}
}

if ($class)
{
$query .= " AND class=$class";
$q .= ($q ? "&amp;" : "") . "class=$class";
}


stdhead("Users");

echo("<h1>Users</h1>\n");


echo("<form method=get action=?>\n");
echo("Search: <input type=text size=30 name=search>\n");
echo("<select name=class>\n");
echo("<option value='-'>(any class)</option>\n");
    $maxclass = UC_MODERATOR;
for ($i = 0;$i< $maxclass;$i++) {
if ($c = get_user_class_name($i))
echo("<option value=\"$i\" " . ($class && $class == $i? " selected=\"selected\"" : "") . ">$c</option>\n");
}
echo("</select>\n");
echo("<input type=submit value='Okay'>\n");
echo("</form>\n");

echo("<p>\n");

echo("<p><a href=\"?letter=All\"><b>Show all users</b></a>\n");

echo("</p>\n");



for ($i = 97; $i < 123; ++$i)

{

$l = chr($i);

$L = chr($i - 32);

if ($l == $letter)

echo("<b>$L</b>\n");

else

echo("<a href=\"users.php?letter=$l\"><b>$L</b></a>\n");

}

echo("</p>\n");

$res = mysql_query("SELECT COUNT(*) FROM users WHERE $query") or sqlerr(__FILE__,__LINE__);
$arr = mysql_fetch_array($res);
$count = $arr[0];
$usersperpage = 100;
list($pagertopo, $pagerbottomo, $limito) = pager($usersperpage, $count, "users.php?$q&");


if($arr[0] > 0) {
$res = mysql_query("SELECT users.username, users.id, users.donor, users.warned, users.enabled, users.last_access, users.class, users.added, countries.name, countries.flagpic FROM users FORCE INDEX ( username ) LEFT JOIN countries ON country = countries.id WHERE $query ORDER BY username ASC $limito") or sqlerr(__FILE__,__LINE__);

$num = mysql_num_rows($res);
if ($num != 0) {

print($pagertopo);

echo("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");
echo("<tr><td class=\"colhead\" align=\"center\">User</td><td class=\"colhead\" align=\"center\">Registered</td><td class=\"colhead\" align=\"center\">Last seen</td><td class=\"colhead\" align=\"center\">Class</td><td class=\"colhead\" align=\"center\">Country</td><td class=\"colhead\" align=\"center\">PM</td><td class=\"colhead\" align=\"center\"><font class=small>Status</font></td></tr>\n");

}

while($arr = mysql_fetch_assoc($res))
{

$country = ($arr['name'] != NULL) ? "<td style='padding: 0px' align=center><img src=\"{$pic_base_url}flag/{$arr['flagpic']}\" alt=\"". safechar($arr['name']) ."\"></td>" : "<td align=center>---</td>";


if ($arr['added'] == '0000-00-00 00:00:00')

$arr['added'] = '-';

if ($arr['last_access'] == '0000-00-00 00:00:00')

$arr['last_access'] = '-';

$dt = gmtime() - 180;
$dt = sqlesc(get_date_time($dt));
if ($arr['class'] == '7')
$clas_pic ="<img src=/pic/rank_founder.gif>";
if ($arr['class'] == '6')
$clas_pic ="<img src=/pic/rank_admin.gif>";
if ($arr['class'] == '5')
$clas_pic ="<img src=/pic/rank_moderator.gif>";
if ($arr['class'] == '4')
$clas_pic ="<img src=/pic/uploader.gif>";
if ($arr['class'] == '3')
$clas_pic ="<img src=/pic/rank_vip.gif>";
if ($arr['class'] == '3')
$clas_pic ="<img src=/pic/rank_vip.gif>";
if ($arr['class'] == '2')
$clas_pic ="<img src=/pic/poweruser.gif>";
if ($arr['class'] == '1')
$clas_pic ="<img src=/pic/member.gif>";
if ($arr['class'] == '0')
$clas_pic ="<img src=/pic/peasant.gif>";

$usr[] = "<tr><td align=\"left\"><a href=\"userdetails.php?id=$arr[id]\"><b>$arr[username]</b></a>". get_user_icons($arr) ."</td>" .

"<td align=\"center\">$arr[added]</td><td align=\"center\">$arr[last_access]</td><td align=\"center\">$clas_pic</td>".

"$country <td align=\"center\"><a href=messages.php?action=send&receiver=$arr[id]><b><img src=pic/button_pm.gif border=0 align=center alt=\"PM\"></b></a></td> <td align=\"center\">".("'".$arr['last_access']."'">$dt?"<img src=".$pic_base_url."button_online.gif border=0 alt=\"Online\">":"<img src=".$pic_base_url."button_offline.gif border=0 alt=\"Offline\">" )."</td></tr> \n";

}
}


if ($usr != 0) {
echo implode("\n",$usr);
unset($usr);

echo("</table>\n");

print($pagerbottomo);

}
else
stdmsg("Error", "No users!");



stdfoot();
die;

?>
