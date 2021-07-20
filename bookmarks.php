<?
require "include/functions.php";
function bark($msg) {
  stdmsg("Error!", $msg);
 stdfoot();
 exit;
}
dbconn();
loggedinorreturn();
parked();
//referer();
$option = unesc($_GET["op"]);
if ($option == "view")
{
stdhead("Bookmarks :.");
?>
<head>
	<style type="text/css" media="screen">@import "tabs.css";</style>
</head>

<body>


	<div id="header5">
	<ul id="primary">
		<li><span>My Bookmarks</span></li>
		<li><a href="mytorrents.php">My Torrents</a></li>
		<li><a href="browse.php">Browse</a></li>
	</ul>
	</div><tr>



<?
$id =(int)$_GET["id"];
$res = mysql_query("SELECT userid FROM bookmarks WHERE id = $id");
$row = mysql_fetch_array($res);
if (!$row)
if ($CURUSER["id"] != $id )
bark("Fuck off!!!!!!!! ");
$order = "bookmarks.id DESC";
$limit = "10";
$res = mysql_query("SELECT torrents.id, torrents.name, torrents.size, torrents.category, torrents.filename, torrents.added, torrents.seeders, torrents.leechers, torrents.owner, torrents.times_completed AS complete, bookmarks.id AS bid, bookmarks.torrentid, bookmarks.userid FROM bookmarks,torrents WHERE bookmarks.userid = '$id' AND torrents.id = bookmarks.torrentid ORDER BY $order") or sqlerr();
if (mysql_num_rows($res) > 0)
{
$bookmarks = "" .
"<tr><td class=colhead align=center>Type</td><td class=colhead align=center>Name</td><td class=colhead align=center>Added</td><td class=colhead align=center>Size</td><td class=colhead align=center>Time Alive</td><td class=colhead align=center>Snatched</td><td class=colhead align=center>Seeders</td><td class=colhead align=center>Leechers</td><td class=colhead align=center><img src=pic/warned2.gif border=0 alt='Delete'></td></tr>";
while ($a = mysql_fetch_array($res))
{
$r1 = mysql_query("SELECT id, username FROM users WHERE id=$a[owner]") or sqlerr(__FILE__, __LINE__);
$a1 = mysql_fetch_assoc($r1);
$owner = "<a href=userdetails.php?id=$a1[id]><b>$a1[username]</b></a>";
$r2 = mysql_query("SELECT name, image FROM categories WHERE id=$a[category]") or sqlerr(__FILE__, __LINE__);
$a2 = mysql_fetch_assoc($r2);
$cat = "<img src=\"pic/$a2[image]\" alt=\"$a2[name]\" >";
$ttl = (180*24) - floor((gmtime() - sql_timestamp_to_unix_timestamp($a["added"])) / 3600);
if ($ttl == 1) $ttl .= "<br>hour"; else $ttl .= "<br>hour.";
$bookmarks .= "<tr>" .
"</tr><tr><td align=center >$cat</td><td><a href=details.php?id=$a[id]><b>" . htmlspecialchars($a["name"]) . "</b>" .
"<td align=center >" . str_replace(" ", "<br />", $a["added"]) . "</td><td align=center >" . str_replace(" ", "<br>", mksize($a["size"])) . "</td><td align=center >$ttl</td>".
"<td align=center >$a[complete]</td><td align=right >$a[seeders]</td><td align=right >$a[leechers]</td><td style='padding: 3px' align=center ><a href=bookmarks.php?id=$a[bid]&op=delete><img src=pic/warned5.gif border=0 alt='Удалить закладку'></a></tr>\n";
}
$bookmarks .= "</table>";
}
$ret1 = mysql_query("SELECT username FROM users WHERE id=$id") or sqlerr(__FILE__, __LINE__);
$arr1 = mysql_fetch_assoc($ret1);
$user = "<b>$arr1[username]</b>";
echo("<table width=90% border=1 cellspacing=0 cellpadding=5>");
if (!$bookmarks)
echo("<tr valign=top><td align=left class=colhead><center><b>Nothing selected</b></center></td></tr>");
else {
echo("$bookmarks</td></tr>");
}
echo("</table>\n");
stdfoot();
die();
}
if ($option == "add")
{
$returnto = $HTTP_SERVER_VARS["HTTP_REFERER"];

// Check if user has already marked it
$torrentid =(int) $_GET["id"];
$userid = (int) $CURUSER["id"];
$res = mysql_query("SELECT torrentid, userid FROM bookmarks WHERE torrentid='$torrentid' AND userid='$CURUSER[id]'") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res);
$marked = $arr;

if ($marked) {

stdhead("Already bookmarked torrent!");
bark("Already bookmarked torrent!");
stdfoot();
die();
}
else {
mysql_query("INSERT INTO bookmarks (userid, torrentid) VALUES('$CURUSER[id]', '$torrentid')") or sqlerr();
header("Refresh: 0; url=bookmarks.php?id=$userid&op=view");
}
}
if ($option == "delete")
{
$res = mysql_query("SELECT * FROM bookmarks WHERE id=$id") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_array($res);
$userid = $CURUSER[id];

@mysql_query("DELETE FROM bookmarks WHERE id=$id");

header("Refresh: 0; url=bookmarks.php?id=$userid&op=view");
}

?>