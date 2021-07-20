<?php
require "include/functions.php";
dbconn(false);
loggedinorreturn();
parked();
//referer();
$userid = isset($_GET['id']) ? (int)$_GET['id'] : '';
$id = isset($CURUSER['id']) ? (int)$CURUSER['id'] : '';

if (!$userid)
	$userid = $CURUSER['id'];

if (!is_valid_id($userid))
	stderr("Error", "Invalid ID.");

$res = mysql_query("SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_array($res) or stderr("Error", "No user with ID.");

$r = mysql_query("SELECT id, friendid FROM friends WHERE userid=$userid AND friendid=$id AND confirmed = 'yes'") or sqlerr(__FILE__, __LINE__);
$friend = mysql_num_rows($r);
$r = mysql_query("SELECT id FROM blocks WHERE userid=$userid AND blockid=$id") or sqlerr(__FILE__, __LINE__);
$block = mysql_num_rows($r);
if ((!$friend) || $block)
{
if ($user["showfriends"] != "yes" && $CURUSER["id"] != $user["id"] && (get_user_class() < UC_MODERATOR))
 stderr("<br />Sorry", "This members friends list is private.");
}

stdhead("Friends list for " . $user['username']);

echo("<p><table class=main width=700 border=0 cellspacing=0 cellpadding=0>".
"<tr><td class=embedded><h1 style='margin:0px'> Friends list for $user[username]</h1></td></tr></table></p>\n");
if ($CURUSER['id'] != $user['id'])
    echo('<h3><a href=\'userdetails.php?id='.$userid.'\'>Go to '.$user['username'].'\'s Profile</a></h3><br />');

echo("<table class=main width=700 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>");

$fcount = number_format(get_row_count("friends", "WHERE userid='".$userid."' AND confirmed = 'yes'"));

echo("<h2 align=left><a name=\"friends\">".$user['username']." has ".$fcount." Friends</a></h2>\n");

echo("<table width=700 border=1 cellspacing=0 cellpadding=5><tr><td>");

$i = 0;
$res = mysql_query("SELECT f.friendid as id, u.username AS name, u.class, u.avatar, u.title, u.donor, u.warned, u.enabled, u.last_access FROM friends AS f LEFT JOIN users as u ON f.friendid = u.id WHERE userid=$userid AND f.confirmed='yes' ORDER BY name") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) == 0)
	$friends = "<em>".$user['username']." has no friends.</em>";
else
	while ($friend = mysql_fetch_array($res))
	{
$pm_pic = "<img src=".$pic_base_url."button_pm.gif alt='Send PM' border=0>";
$dt = gmtime() - 180;
$online = ($friend["last_access"] >= ''. get_date_time($dt). '' ? '&nbsp;<img src='.$pic_base_url.'button_online.gif border=0 alt=Online>' : '<img src='.$pic_base_url.'button_offline.gif border=0 alt=Offline>');
    $title = htmlspecialchars($friend["title"]);
		if (!$title)
	    $title = get_user_class_name($friend["class"]);
    $body1 = "<a href=userdetails.php?id=" . $friend['id'] . "><b>" . $friend['name'] . "</b></a>" .
    	get_user_icons($friend) . " ($title) $online<br /><br />last seen on " . $friend['last_access'] .
    	"<br />(" . get_elapsed_time(sql_timestamp_to_unix_timestamp($friend['last_access'])) . " ago)";

		$body2 = (($id == $CURUSER['id'])? "" :"<br /><a href=friends.php?id=$CURUSER[id]&action=add&type=friend&targetid=" . $friend['id'] . ">Add Friend</a>" .
			"<br /><br /><a href=messages.php?action=send&receiver=" . $friend['id'] . ">".$pm_pic."</a>");
    $avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($friend["avatar"]) : "");
//		if (!$avatar)
//			$avatar = "".$pic_base_url."default_avatar.gif";
    if ($i % 2 == 0)
    	echo("<table width=500 style='padding: 0px'><tr><td class=bottom style='padding: 5px' width=50% align=center>");
    else
    	echo("<td class=bottom style='padding: 5px' width=50% align=center>");
    echo("<table class=main width=350 height=75px>");
    echo("<tr valign=top><td width=75 align=center style='padding: 0px'>" .
			($avatar ? "<div style='width:75px;height:75px;overflow: hidden'><img width=75px src=\"$avatar\"></div>" : ""). "</td><td>\n");
    echo("<table class=main>");
    echo("<tr><td class=embedded style='padding: 5px' width=80%>$body1</td>\n");
    echo("<td class=embedded style='padding: 5px' width=20%>$body2</td></tr>\n");
    echo("</table>");
		echo("</td></tr>");
		echo("</td></tr></table>\n");
    if ($i % 2 == 1)
			echo("</td></tr></table>\n");
		else
			echo("</td>\n");
		$i++;
	}
if ($i % 2 == 1)
	echo("<td class=bottom width=50%>&nbsp;</td></tr></table>\n");
if (isset($friends))
echo($friends);
echo("</td></tr></table>\n");
echo("</td></tr></table>\n");
//
echo("<h1>Comments for <a href=userdetails.php?id=$userid>" . $user["username"] . "</a></h1>\n");


	echo("<p><a name=\"startcomments\"></a></p>\n");

	$commentbar = "<p align=center><a class=index href=usercomment.php?action=add&amp;userid=$userid>Add a comment</a></p>\n";
    echo("<i>Note comment update are 3 minutes</i>");
	$subres = mysql_query("SELECT COUNT(*) FROM usercomments WHERE userid = $userid");
	$subrow = mysql_fetch_array($subres,MYSQL_NUM);
	$count = $subrow[0];

	if (!$count) {
		echo("<h2>No comments yet</h2>\n");
	}
	else {
		$pager = pager(20, $count, "userfriends.php?id=$userid&", array('lastpagedefault' => 1));
        $file2 = "$CACHE/users/ufcom.txt";
$expire = 3*60; // 3 minutes
if (file_exists($file2) && filemtime($file2) > (time() - $expire)) {
$ufcom = unserialize(file_get_contents($file2));
} else {
		$subres = mysql_query("SELECT usercomments.id, text, user, usercomments.added, editedby, editedat, avatar, warned, ".
                  "username, title, class, donor FROM usercomments LEFT JOIN users ON usercomments.user = users.id WHERE userid = " .
                  "$userid ORDER BY usercomments.id ".$pager['limit']) or sqlerr(__FILE__, __LINE__);
		$allrows = array();
		while ($subrow = mysql_fetch_array($subres) ) {
        $ufcom[] = $subrow;
    }
    $OUTPUT = serialize($ufcom);
    $fp = fopen($file2,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
} // end else
foreach ($ufcom as $subrow)
		$allrows[] = $subrow;

		echo($commentbar);
		echo($pager['pagertop']);

		usercommenttable($allrows);

		echo($pager['pagerbottom']);
	}

	echo($commentbar);
//
echo("<p><a href=users.php><b>Find User/Browse User List</b></a></p>");
stdfoot();
?>