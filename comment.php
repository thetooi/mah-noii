<?
require_once("include/functions.php");
$valid_actions = array('add', 'edit', 'delete', 'vieworiginal');
$action = in_array($_GET["action"], $valid_actions) ? $_GET['action'] : '';
dbconn(false);
loggedinorreturn();
parked();
//referer();
if ($action == "add")
{
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $torrentid = (int) $_POST["tid"];
	  if (!is_valid_id($torrentid))
			stderr("Error", "Invalid ID $torrentid.");

		$res = mysql_query("SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__,__LINE__);
		$arr = mysql_fetch_array($res);
		if (!$arr)
		  stderr("Error", "No torrent with ID $torrentid.");

	  $text = trim($_POST["text"]);
	  if (!$text)
			stderr("Error", "Comment body cannot be empty!");

	  mysql_query("INSERT INTO comments (user, torrent, added, text, ori_text) VALUES (" .
	      $CURUSER["id"] . ",$torrentid, '" . get_date_time() . "', " . sqlesc($text) .
	       "," . sqlesc($text) . ")");

	  $newid = mysql_insert_id();

	  mysql_query("UPDATE torrents SET comments = comments + 1 WHERE id = $torrentid");

	  header("Refresh: 0; url=details.php?id=$torrentid&viewcomm=$newid#comm$newid");

	  die;
	}

  $torrentid = (int) $_GET["tid"];
  if (!is_valid_id($torrentid))
		stderr("Error", "Invalid ID $torrentid.");

	$res = mysql_query("SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__,__LINE__);
	$arr = mysql_fetch_array($res);
	if (!$arr)
	  stderr("Error", "No torrent with ID $torrentid.");

	stdhead("Add a comment to \"" . htmlspecialchars($arr["name"]) . "\"");

	echo("<h1>Add a comment to \"" . htmlspecialchars($arr["name"]) . "\"</h1>\n");
	echo("<p><form name=comment method=\"post\" action=\"comment.php?action=add\">\n");
	echo("<input type=\"hidden\" name=\"tid\" value=\"$torrentid\"/>\n");
echo("<table width=600 cellspacing=0 cellpadding=5>\n");
echo("<tr><td class=rowhead style='padding: 3px'>Body</td><td align=center style='padding: 3px'>");
 textbbcode("comment","text",($quote?(("[quote=".htmlspecialchars($arr["username"])."]".htmlspecialchars(unesc($arr["body"]))."[/quote]")):""));
echo("</td></table>\n");

	echo("<p><input type=submit  class=groovybutton value='Submit'></p></form>\n");
	$res = mysql_query("SELECT comments.id, text, UNIX_TIMESTAMP(comments.added) as utadded, UNIX_TIMESTAMP(editedat) as uteditedat, comments.added, username, users.id as user, users.class, users.avatar FROM comments LEFT JOIN users ON comments.user = users.id WHERE torrent = $torrentid ORDER BY comments.id DESC LIMIT 5");

	$allrows = array();
	while ($row = mysql_fetch_array($res))
	  $allrows[] = $row;

	if (count($allrows)) {
	  echo("<h3>Most recent comments, in reverse order</h3>\n");
	echo("<p align=center><a href=tags.php target=_blank>Tags</a> | <a href=smilies.php target=_blank>Smilies</a></p>\n");
	  commenttable($allrows);
	}


  stdfoot();
	die;
}
elseif ($action == "edit")
{
  $commentid = (int) $_GET["cid"];
  if (!is_valid_id($commentid))
		stderr("Error", "Invalid ID $commentid.");

  $res = mysql_query("SELECT c.*, t.name FROM comments AS c LEFT JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
  $arr = mysql_fetch_array($res);
  if (!$arr)
  	stderr("Error", "Invalid ID $commentid.");

	if ($arr["user"] != $CURUSER["id"] && get_user_class() < UC_MODERATOR)
		stderr("Error", "Permission denied.");

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	  $text =htmlspecialchars( $_POST["text"]);
    $returnto = htmlspecialchars($_POST["returnto"]);

	  if ($text == "")
	  	stderr("Error", "Comment body cannot be empty!");

	  $text = sqlesc($text);

	  $editedat = sqlesc(get_date_time());

	  mysql_query("UPDATE comments SET text=$text, editedat=$editedat, editedby=$CURUSER[id] WHERE id=$commentid") or sqlerr(__FILE__, __LINE__);

		if ($returnto)
	  	header("Location: $returnto");
		else
		  header("Location: $BASEURL/");      // change later ----------------------

		die;
	}

 	stdhead("Edit comment to \"" . htmlspecialchars($arr["name"]) . "\"");

	echo("<h1>Edit comment to \"" . htmlspecialchars($arr["name"]) . "\"</h1><p>\n");
	echo("<form method=\"post\" action=\"comment.php?action=edit&amp;cid=$commentid\">\n");
	echo("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($_SERVER["HTTP_REFERER"]) . "\" />\n");
	echo("<input type=\"hidden\" name=\"cid\" value=\"$commentid\" />\n");
	echo("<textarea name=\"text\" rows=\"10\" cols=\"60\">" . htmlspecialchars($arr["text"]) . "</textarea></p>\n");
	echo("<p><input type=\"submit\" class=groovybutton class=btn value=\"Do it!\" /></p></form>\n");

	stdfoot();
	die;
}
elseif ($action == "delete")
{
	if (get_user_class() < UC_MODERATOR)
		stderr("Error", "Permission denied.");

  $commentid = (int) $_GET["cid"];

  if (!is_valid_id($commentid))
		stderr("Error", "Invalid ID $commentid.");

   $sure = (int) $_GET["sure"];

  if (!$sure)
  {
 		$referer = htmlspecialchars($_SERVER["HTTP_REFERER"]);
		stderr("Delete comment", "You are about to delete a comment. Click\n" .
			"<a href=?action=delete&cid=$commentid&sure=1" .
			($referer ? "&returnto=" . urlencode($referer) : "") .
			">here</a> if you are sure.");
  }


	$res = mysql_query("SELECT torrent FROM comments WHERE id=$commentid")  or sqlerr(__FILE__,__LINE__);
	$arr = mysql_fetch_array($res);
	if ($arr)
		$torrentid = $arr["torrent"];

	mysql_query("DELETE FROM comments WHERE id=$commentid") or sqlerr(__FILE__,__LINE__);
	if ($torrentid && mysql_affected_rows() > 0)
		mysql_query("UPDATE torrents SET comments = comments - 1 WHERE id = $torrentid");

	$returnto = htmlspecialchars($_GET["returnto"]);

	if ($returnto)
	  header("Location: $returnto");
	else
	  header("Location: $BASEURL/");      // change later ----------------------



	die;
}
elseif ($action == "vieworiginal")
{
	if (get_user_class() < UC_MODERATOR)
		stderr("Error", "Permission denied.");

  $commentid = (int) $_GET["cid"];

  if (!is_valid_id($commentid))
		stderr("Error", "Invalid ID $commentid.");

  $res = mysql_query("SELECT c.*, t.name FROM comments AS c LEFT JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__,__LINE__);
  $arr = mysql_fetch_array($res);
  if (!$arr)
  	stderr("Error", "Invalid ID $commentid.");

  stdhead("Original comment");
  echo("<h1>Original contents of comment #$commentid</h1><p>\n");
  echo("<table width=500 border=1 cellspacing=0 cellpadding=5>");
  echo("<tr><td class=comment>\n");
  echo htmlspecialchars($arr["ori_text"]);
  echo("</td></tr></table>\n");

   $returnto = htmlspecialchars($_SERVER["HTTP_REFERER"]);

//	$returnto = "details.php?id=$torrentid&amp;viewcomm=$commentid#$commentid";

	if ($returnto)
 		echo("<p><font size=small>(<a href=$returnto>back</a>)</font></p>\n");

	stdfoot();
	die;
}
else
	stderr("Error", "Unknown action $action");

die;
?>