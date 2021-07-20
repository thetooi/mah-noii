<?php
////respect mod by hellix
require "include/functions.php";
dbconn(false);
loggedinorreturn();
parked();
//referer();
$userid = (int) $_GET['id'];
$action = htmlspecialchars($_GET['action']);

if (!$userid)
	$userid = $CURUSER['id'];

if (!is_valid_id($userid))
	stderr("Error", "Bad ID.");

if ($userid != $CURUSER["id"])
	stderr("Error", "Access denied.");

$res = mysql_query("SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_assoc($res) or stderr("Error", "No user with that ID.");

// action: add -------------------------------------------------------------

if ($action == 'add')
{
	$targetid = (int) $_GET['targetid'];
	$type = htmlentities($_GET['type']);

  if (!is_valid_id($targetid))
		stderr("Error", "Bad ID.");

  if ($type == 'respect')
  {
  	$table_is = $frag = 'respect';
    $field_is = 'respect';
  }
	elseif ($type == 'block')
  {
		$table_is = $frag = 'respect';
    $field_is = 'respect';
  }
	else
		stderr("Error", "Invalid ID.");

   die;
}

// action: delete ----------------------------------------------------------

if ($action == 'delete')
{
	$targetid = (int) $_GET['targetid'];
	$sure = (int) $_GET['sure'];
	$type = htmlentities($_GET['type']);

  if (!is_valid_id($targetid))
		stderr("Error", "Invalid ID.");

  if (!$sure)
    stderr("Delete","Do you really want to delete a Click?\n" .
    	"<a href=?id=$userid&action=delete&type=$type&targetid=$targetid&sure=1>here</a>");

  if ($type == 'respect')
  {
   mysql_query("UPDATE users SET good = good - 1 WHERE id=$targetid") or sqlerr();
    mysql_query("DELETE FROM respect WHERE userid=$userid AND respect=$targetid") or sqlerr(__FILE__, __LINE__);
    if (mysql_affected_rows() == 0)
      stderr("Error", "Bad ID");
    $frag = "simpaty";
  }
  elseif ($type == 'block')
  {
   mysql_query("UPDATE users SET bad = bad - 1 WHERE id=$targetid") or sqlerr();
    mysql_query("DELETE FROM respect WHERE userid=$userid AND respect=$targetid") or sqlerr(__FILE__, __LINE__);
    if (mysql_affected_rows() == 0)
      stderr("Error", "Bad ID");
    $frag = "blocks";
  }
  else
    stderr("Error", "Invalid ID.");

  header("Location: $BASEURL/simpaty.php?id=$userid#$frag");
  die;
}

// main body  -----------------------------------------------------------------

stdhead("List for " . $user['username']);

if ($user["donor"] == "yes") $donor = "<td class=embedded><img src=\"{$pic_base_url}starbig.gif\" alt='Donor' style='margin-left: 4pt'></td>";
if ($user["warned"] == "yes") $warned = "<td class=embedded><img src=\"{$pic_base_url}warnedbig.gif\" alt='Warned' style='margin-left: 4pt'></td>";

echo("<p><table class=main border=0 cellspacing=0 cellpadding=0>".
"<tr><td class=embedded><h1 style='margin:0px'><font color=red> </font></h1></td></tr></table></p>\n");
$country = '';
$res = mysql_query("SELECT name,flagpic FROM countries WHERE id=".$user['country']." LIMIT 1") or sqlerr();
if (mysql_num_rows($res) == 1)
{
  $arr = mysql_fetch_assoc($res);
	$country = "<td class=embedded><img src=\"".$pic_base_url."flag/".$arr['flagpic']."\" alt=\"". htmlspecialchars($arr['name']) ."\" style='margin-left: 8pt'></td>";
}
echo("<p><table class=main border=0 cellspacing=0 cellpadding=0>".
"<tr><td class=embedded><h1 style='margin:0px'> Personal lists for $user[username]</h1>$donor$warned$country</td></tr></table></p>\n");
?>


<head>
	<style type="text/css" media="screen">@import "tabs.css";</style>
</head>

<body>
	<div id="header5">
	<ul id="primary">
		<li><a href="userdetails.php?id=<?=$CURUSER['id']?>">Userdetails</a></li>
		<li><a href="friends.php">My Friends</a></li>
		<li><a href="my.php">My Profile</a></li>
		<li><span>My Liking</span></li>
	</ul>
	</div>
<?

echo("<table width=90% border=1 cellspacing=0 cellpadding=5><tr><td>");

$i = 0;

$res = mysql_query("SELECT f.respect as id, u.username AS name, u.class,f.good,f.bad, u.avatar, u.title, u.donor, u.warned, u.enabled, u.last_access FROM respect AS f LEFT JOIN users as u ON f.respect = u.id WHERE  f.good='1'and  userid=$userid  ORDER BY name") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) == 0)
	$respect = "<em>Your liking list is empty.</em>";
else
	while ($respect = mysql_fetch_assoc($res))
	{
    $title = $respect["title"];
		if (!$title)
	    $title = get_user_class_name($respect["class"]);
    $body1 = "<a href=userdetails.php?id={$respect['id']}><b>{$respect['name']}</b></a>" .
    	get_user_icons($respect) . " ($title)<br><br>last seen on " . $respect['last_access'] .
    	"<br>(" . get_elapsed_time(sql_timestamp_to_unix_timestamp($respect[last_access])) . " ago)";
		$body2 = "<br><a href=simpaty.php?id=$userid&action=delete&type=respect&targetid=" . $respect['id'] . "><img src=pic/deletepm.gif border=0 alt='Remove'></a>" .
			"<br><br><a href=messages.php?action=send&receiver={$respect['id']}><img src=/pic/button_pm.gif border=0  alt='PM'></a>";
    $avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($respect["avatar"]) : "");
		if (!$avatar)
			$avatar = "{$pic_base_url}default_avatar.gif";
    if ($i % 2 == 0)
    	echo("<table width=100% style='padding: 0px'><tr><td class=bottom style='padding: 5px' width=50% align=center>");
    else
    	echo("<td class=bottom style='padding: 5px' width=50% align=center>");
    echo("<table class=main width=100% height=75px>");
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


print($respect);
echo("</td></tr></table>\n");

$res = mysql_query("SELECT b.respect as id, u.username AS name, u.donor, u.warned, u.enabled, u.last_access FROM respect AS b LEFT JOIN users as u ON b.respect = u.id WHERE  b.bad='1' and userid=$userid ORDER BY name") or sqlerr(__FILE__, __LINE__);
if(mysql_num_rows($res) == 0)
	$blocks = "<em>Your liking list is empty.</em>";
else
{
	$i = 0;
	$blocks = "<table width=100% cellspacing=0 cellpadding=0>";
	while ($block = mysql_fetch_assoc($res))
	{
		if ($i % 6 == 0)
			$blocks .= "<tr>";
    	$blocks .= "<td style='border: none; padding: 4px; spacing: 0px;'>[<font class=small><a href=simpaty.php?id=$userid&action=delete&type=block&targetid=" .
				$block['id'] . "><img src=pic/deletepm.gif border=0 alt='Remove'></a></font>] <a href=userdetails.php?id={$block['id']}><b>{$block['name']}</b></a>" .
				get_user_icons($block) . "</td>";
		if ($i % 6 == 5)
			$blocks .= "</tr>";
		$i++;
	}
	echo("</table>\n");
}
echo("<br><br>");
echo("<table class=main width=700 border=0 cellspacing=0 cellpadding=10><tr><td class=embedded>");
echo("<h2 align=left><a name=\"blocks\">Negative liking to</a></h2></td></tr>");
echo("<tr><td style='padding: 10px;background-color: #ECE9D8'>");
echo("$blocks\n");
echo("</td></tr></table>\n");
echo("</td></tr></table>\n");
echo("<p><a href=users.php><b>Find User/Browse User List</b></a></p>");
stdfoot();
?>