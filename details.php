<?

ob_start("ob_gzhandler");

require_once("include/functions.php");
//referer();

// get agent
function getagent($httpagent)
{
return ($httpagent != "" ? $httpagent : "---");
}


function dltable($name, $arr, $torrent)
{

	global $CURUSER;
	$s = "<b>" . count($arr) . " $name</b>\n";
	if (!count($arr))
		return $s;
	$s .= "\n";
	$s .= "<table width=90% class=main border=1 cellspacing=0 cellpadding=5>\n";
	$s .= "<tr><td class=colhead>User/IP</td>" .
          "<td class=colhead align=center>Connectable</td>".
          "<td class=colhead align=right>Uploaded</td>".
          "<td class=colhead align=right>Rate</td>".
          "<td class=colhead align=right>Downloaded</td>" .
          "<td class=colhead align=right>Rate</td>" .
          "<td class=colhead align=right>Ratio</td>" .
          "<td class=colhead align=right>Complete</td>" .
          "<td class=colhead align=right>Connected</td>" .
          "<td class=colhead align=right>Idle</td>" .
          "<td class=colhead align=left>Client</td></tr>\n";
	$now = time();
	$moderator = (isset($CURUSER) && get_user_class() >= UC_MODERATOR);
$mod = get_user_class() >= UC_MODERATOR;
	foreach ($arr as $e) {


                // user/ip/port
                // check if anyone has this ip
                ($unr = mysql_query("SELECT username, privacy FROM users WHERE id=$e[userid] ORDER BY last_access DESC LIMIT 1")) or die;
                $una = mysql_fetch_array($unr);
				if ($una["privacy"] == "strong") continue;
		$s .= "<tr>\n";
                if ($una["username"])
                  $s .= "<td><a href=userdetails.php?id=$e[userid]><b>$una[username]</b></a></td>\n";
                else
                  $s .= "<td>" . ($mod ? $e["ip"] : preg_replace('/\.\d+$/', ".xxx", $e["ip"])) . "</td>\n";
		$secs = max(1, ($now - $e["st"]) - ($now - $e["la"]));
		$revived = $e["revived"] == "yes";
        $s .= "<td align=center>" . ($e[connectable] == "yes" ? "Yes" : "<font color=red>No</font>") . "</td>\n";
		$s .= "<td align=right>" . mksize($e["uploaded"]) . "</td>\n";
		$s .= "<td align=right><nobr>" . mksize(($e["uploaded"] - $e["uploadoffset"]) / $secs) . "/s</nobr></td>\n";
		$s .= "<td align=right>" . mksize($e["downloaded"]) . "</td>\n";
		if ($e["seeder"] == "no")
			$s .= "<td align=right><nobr>" . mksize(($e["downloaded"] - $e["downloadoffset"]) / $secs) . "/s</nobr></td>\n";
		else
			$s .= "<td align=right><nobr>" . mksize(($e["downloaded"] - $e["downloadoffset"]) / max(1, $e["finishedat"] - $e[st])) .	"/s</nobr></td>\n";
                if ($e["downloaded"])
				{
                  $ratio = floor(($e["uploaded"] / $e["downloaded"]) * 1000) / 1000;
                    $s .= "<td align=\"right\"><font color=" . get_ratio_color($ratio) . ">" . number_format($ratio, 3) . "</font></td>\n";
				}
	               else
                  if ($e["uploaded"])
                    $s .= "<td align=right>Inf.</td>\n";
                  else
                    $s .= "<td align=right>---</td>\n";
		$s .= "<td align=right>" . sprintf("%.2f%%", 100 * (1 - ($e["to_go"] / $torrent["size"]))) . "</td>\n";
		$s .= "<td align=right>" . mkprettytime($now - $e["st"]) . "</td>\n";
		$s .= "<td align=right>" . mkprettytime($now - $e["la"]) . "</td>\n";
		$s .= "<td align=left>" . htmlspecialchars(getagent($e["agent"])) . "</td>\n";
		$s .= "</tr>\n";
	}
	$s .= "</table>\n";
	return $s;
}

dbconn(false);
loggedinorreturn();
parked();
$id = (int) $_GET["id"];
if (!is_valid_id($id))
stderr("Error", "Invalid ID");
$id = (int) $id;
if (!isset($id) || !$id)
	die();
///////////// start cashe details by hellix
$file2 = "$CACHE/browse/details.txt";
$expire = 1*60; // 1 minutes
if (file_exists($file2) && filemtime($file2) > (time() - $expire)) {
$details = unserialize(file_get_contents($file2));
} else {
$res = mysql_query("SELECT UNIX_TIMESTAMP(torrents.added) AS ts, torrents.completed_by, torrents.seeders,torrents.nfo, torrents.banned, torrents.leechers, torrents.info_hash, torrents.filename, LENGTH(torrents.nfo) AS nfosz, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(torrents.last_action) AS lastseed, torrents.numratings, torrents.name, IF(torrents.numratings < $minvotes, NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, torrents.owner, torrents.save_as, torrents.descr, torrents.visible, torrents.size, torrents.added, torrents.views, torrents.hits, torrents.times_completed, torrents.id, torrents.type, torrents.numfiles, categories.name AS cat_name, users.username FROM torrents LEFT JOIN categories ON torrents.category = categories.id LEFT JOIN users ON torrents.owner = users.id WHERE torrents.id = $id")
	or sqlerr();
while ($row = mysql_fetch_array($res) ) {
        $details[] = $row;
    }
    $OUTPUT = serialize($details);
    $fp = fopen($file2,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
} // end else
foreach ($details as $row)
///////////// end cashe details by hellix
$owned = $moderator = 0;
	if (get_user_class() >= UC_MODERATOR)
		$owned = $moderator = 1;
	elseif ($CURUSER["id"] == $row["owner"])
		$owned = 1;
//}

if (!$row || ($row["banned"] == "yes" && !$moderator))
	stderr("Error", "No torrent with ID $id.");
else {
	if ($_GET["hit"]) {
		mysql_query("UPDATE torrents SET views = views + 1 WHERE id = $id");
		if ($_GET["tocomm"])
			header("Location: $BASEURL/details.php?id=$id&page=0#startcomments");
		elseif ($_GET["filelist"])
			header("Location: $BASEURL/details.php?id=$id&filelist=1#filelist");
		elseif ($_GET["toseeders"])
			header("Location: $BASEURL/details.php?id=$id&dllist=1#seeders");
		elseif ($_GET["todlers"])
			header("Location: $BASEURL/details.php?id=$id&dllist=1#leechers");
		else
			header("Location: $BASEURL/details.php?id=$id");
		hit_end();
		exit();
	}

	if (!isset($_GET["page"])) {
		stdhead("Details for torrent \"" . $row["name"] . "\"");

		if ($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_MODERATOR)
			$owned = 1;
		else
			$owned = 0;

		$spacer = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

		if ($_GET["uploaded"]) {
			echo("<h3>Successfully uploaded!</h3>\n");
			echo("<p>You can start seeding now. <b>Note</b> that the torrent won't be visible until you do that!</p>\n");
		}
		elseif ($_GET["edited"]) {
			echo("<h3>Successfully edited!</h3>\n");
			  echo("<i>Note details update are 1 minutes</i>");
			if (isset($_GET["returnto"]))
				echo("<p><b>Go back to <a href=\"" . htmlspecialchars($_GET["returnto"]) . "\">whence you came</a>.</b></p>\n");
		}
		elseif (isset($_GET["searched"])) {
			echo("<h3>Your search for \"" . htmlspecialchars($_GET["searched"]) . "\" gave a single result:</h3>\n");
		}
		elseif ($_GET["rated"])
			echo("<h3>Rating added!</h3>\n");

$s=$row["name"];
        echo("<h1>$s</h1><p></p>\n");
                echo("<table width=720 border=\"1\" cellspacing=\"0\" cellpadding=\"5\">\n");

		$url = "edit.php?id=" . $row["id"];
		if (isset($_GET["returnto"])) {
			$addthis = "&amp;returnto=" . urlencode($_GET["returnto"]);
			$url .= $addthis;
			$keepget .= $addthis;
		}
		$editlink = "a href=\"$url\" class=\"sublink\"";

//		$s = "<b>" . htmlspecialchars($row["name"]) . "</b>";
//		if ($owned)
//			$s .= " $spacer<$editlink>[Edit torrent]</a>";
//		tr("Name", $s, 1);

		echo("<tr><td class=rowhead width=1%>Download</td><td width=99% align=left><a class=\"index\" href=\"download.php/$id/" . rawurlencode($row["filename"]) . "\">" . htmlspecialchars($row["filename"]) . "</a>&nbsp;&nbsp;&nbsp;<a class=index href=bookmarks.php?op=add&id=$id <i>[Add To Bookmarks]</i></a></td></tr>");
//		tr("Downloads&nbsp;as", $row["save_as"]);

		function hex_esc($matches) {
			return sprintf("%02x", ord($matches[0]));
		}
		tr("Info hash", preg_replace_callback('/./s', "hex_esc", hash_pad($row["info_hash"])));
if (!empty($row["descr"])){
$row["descr"] = preg_replace("/[^\\x20-\\x7e\\x0a\\x0d]/", " ", $row["descr"]);
echo("<tr valign=top><td class=rowhead>Description</td><td align=left>" . format_comment(htmlspecialchars($row["descr"])) . "</td></tr>\n");
} else {
require_once("nfodescr.php");
   }
if (!empty($row["descr"]))
  echo("<tr><td class=rowhead>NFO</td><td align=left><a href=viewnfo.php?id=$row[id]><b>View NFO</b></a> (" .
     mksize($row["nfosz"]) . ")</td></tr>\n");
		if ($row["visible"] == "no")
			tr("Visible", "<b>no</b> (dead)", 1);
		if ($moderator)
			tr("Banned", $row["banned"]);

		if (isset($row["cat_name"]))
			tr("Type", $row["cat_name"]);
		else
			tr("Type", "(none selected)");

		tr("Last&nbsp;seeder", "Last activity " . mkprettytime($row["lastseed"]) . " ago");
		tr("Size",mksize($row["size"]) . " (" . number_format($row["size"]) . " bytes)");



$timezone = display_date_time($row["ts"] , $CURUSER[tzoffset] );
		tr("Added", $timezone);
		tr("Views", $row["views"]);
		tr("Hits", $row["hits"]);
if (get_user_class() >= UC_POWER_USER)
{
		tr("Snatched", $row["times_completed"] . " time(s)");

      /////// completed_by hack /////////////

      /*if ($row["times_completed"] != 0)
      {
          echo("<tr><td class=rowhead width=1%>The last 10 downloaders</td><td>");

          $compl = $row["completed_by"];
          $compl_list = explode(" ", $compl);
          $arr = array();

          foreach($compl_list as $array_list)
              $arr[] = $array_list;

          $compl_arr = array_reverse($arr, TRUE);

          $i = 0;
          foreach($compl_arr as $user_id)
          {

              $compl_user = mysql_query("SELECT id, username FROM users WHERE id='$user_id' ORDER BY username");
              $compl_users = mysql_fetch_array($compl_user);
              echo("<b><a href=userdetails.php?id=" . $compl_users["id"] . ">" . $compl_users["username"] . "</a></b>&nbsp;&nbsp;");
      //        echo("</td><td valign=top><table border=0 width=100 cellspacing=0 cellpadding=0><tr><td class=alt5 align=center><b>Snatched By</b></td></tr></table></td><td width=100%><a href=account-details.php?id=" . $compl_users["id"] . ">" . $compl_users["username"] . "</a></td></tr>");

              if ($i == "9")
                  break;
              $i++;
          }
              echo ("</td></tr>");
      }*/
}
      ///// end /////

		$keepget = "";
		if (get_user_class() >= UC_POWER_USER)
            $uprow = (isset($row["username"]) ? ("<a href=userdetails.php?id=" . $row["owner"] . "><b>" . htmlspecialchars($row["username"]) . "</b></a>") : "<i>unknown</i>");
else
$uprow = ("<img border=0 src=pic/anonymousbutton.gif width=80 height=15>");
		if ($owned)
			$uprow .= " $spacer<$editlink><b>[Edit this torrent]</b></a>";
		tr("Upped by", $uprow, 1);

              if ($row["type"] == "multi") {
                if (!$_GET["filelist"])
                tr("Num files<br /><a href=\"details.php?id=$id&amp;filelist=1$keepget#filelist\" class=\"sublink\">[See full list]</a>", $row["numfiles"] . " files", 1);
                else {
                tr("Num files", $row["numfiles"] . " files", 1);

                $s = "<table width=600 class=colorss class=main border=\"1\" cellspacing=0 cellpadding=\"5\">\n";

                $subres = sql_query("SELECT * FROM files WHERE torrent = $id ORDER BY id");

                $s.="<tr><td class=colhead>Type</td><td class=colhead>Path</td><td class=colhead align=right>Size</td></tr>\n";
                while ($subrow = mysql_fetch_array($subres)) {
                     preg_match('/\\.([A-Za-z0-9]+)$/', $subrow["filename"], $ext);
                        $ext = strtolower($ext[1]);
                        if (!file_exists("pic/fileicons/".$ext.".png")) $ext = "Unknown.png";
                $s .= "<tr><td align\"center\"><center><img align=center  src=\"pic/fileicons/".$ext.".png\" alt=\"$ext file\"></center></td><td class=tableb width=700>" . safechar($subrow["filename"]) ."</td><td align=\"right\">" . mksize($subrow["size"]) . "</td></tr>\n";
                }

                $s .= "</table>\n";
                tr("<a name=\"filelist\">File list</a><br /><a href=\"details.php?id=$id$keepget\" class=\"sublink\">[Hide list]</a>", $s, 1);
            }
        }

		if (!$_GET["dllist"]) {
			/*
			$subres = mysql_query("SELECT seeder, COUNT(*) FROM peers WHERE torrent = $id GROUP BY seeder");
			$resarr = array(yes => 0, no => 0);
			$sum = 0;
			while ($subrow = mysql_fetch_array($subres)) {
				$resarr[$subrow[0]] = $subrow[1];
				$sum += $subrow[1];
			}
			tr("Peers<br /><a href=\"details.php?id=$id&amp;dllist=1$keepget#seeders\" class=\"sublink\">[See full list]</a>", $resarr["yes"] . " seeder(s), " . $resarr["no"] . " leecher(s) = $sum peer(s) total", 1);
			*/
if (get_user_class() >= UC_POWER_USER)
    {
			tr("Peers<br /><a href=\"details.php?id=$id&amp;dllist=1$keepget#seeders\" class=\"sublink\">[See full list]</a>", $row["seeders"] . " seeder(s), " . $row["leechers"] . " leecher(s) = " . ($row["seeders"] + $row["leechers"]) . " peer(s) total", 1);
}
		}
		else {
			$downloaders = array();
			$seeders = array();
			$subres = mysql_query("SELECT seeder, finishedat, downloadoffset, uploadoffset, ip, port, uploaded, downloaded, to_go, UNIX_TIMESTAMP(started) AS st, connectable, agent, UNIX_TIMESTAMP(last_action) AS la, userid FROM peers WHERE torrent = $id") or sqlerr();
			while ($subrow = mysql_fetch_array($subres)) {
				if ($subrow["seeder"] == "yes")
					$seeders[] = $subrow;
				else
					$downloaders[] = $subrow;
			}

			function leech_sort($a,$b) {
                                if ( isset( $_GET["usort"] ) ) return seed_sort($a,$b);
                                $x = $a["to_go"];
				$y = $b["to_go"];
				if ($x == $y)
					return 0;
				if ($x < $y)
					return -1;
				return 1;
			}
			function seed_sort($a,$b) {
				$x = $a["uploaded"];
				$y = $b["uploaded"];
				if ($x == $y)
					return 0;
				if ($x < $y)
					return 1;
				return -1;
			}

			usort($seeders, "seed_sort");
			usort($downloaders, "leech_sort");
if (get_user_class() >= UC_POWER_USER)
    {
			tr("<a name=\"seeders\">Seeders</a><br /><a href=\"details.php?id=$id$keepget\" class=\"sublink\">[Hide list]</a>", dltable("Seeder(s)", $seeders, $row), 1);
			tr("<a name=\"leechers\">Leechers</a><br /><a href=\"details.php?id=$id$keepget\" class=\"sublink\">[Hide list]</a>", dltable("Leecher(s)", $downloaders, $row), 1);
}
		}
        $torrentid = (int) $_GET["id"];
$thanked_sql = sql_query("SELECT thanks.userid, users.username, users.class FROM thanks INNER JOIN users ON thanks.userid = users.id WHERE thanks.torrentid = $torrentid");
$count = mysql_num_rows($thanked_sql);

if ($count == 0) {
     $thanksby =" None yet";
} else {

     //$thanked_sql = sql_query("SELECT thanks.userid, users.username FROM thanks INNER JOIN users ON thanks.userid = users.id WHERE thanks.torrentid = $torrentid");
     while ($thanked_row = mysql_fetch_assoc($thanked_sql)) {
          if ($thanked_row["userid"] == $CURUSER["id"])
               $can_not_thanks = true;
          $userid = $thanked_row["userid"];
          $username = $thanked_row["username"];
          $class = $thanked_row["class"];
          $thanksby .= "<a href=\"userdetails.php?id=$userid\">".get_user_class_color2($class, $username)."</a>, ";
     }
     if ($thanksby)
          $thanksby = substr($thanksby, 0, -2);
}
if ($row["owner"] == $CURUSER["id"])
$can_not_thanks = true;
$thanksby = "<div id=\"ajax\"><form action=\"thanks.php\" method=\"post\">
<input type=\"submit\" name=\"submit\" onclick=\"send(); return false;\" value=\"".Thanks."\"".($can_not_thanks == true ? " disabled" : "").">
<input type=\"hidden\" name=\"torrentid\" value=\"$torrentid\">".$thanksby."
</form></div>";
?>
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript">
function send() {
     var ajax = new tbdev_ajax();
     ajax.onShow ('');
     var varsString = "";
     ajax.requestFile = "thanks.php";
     ajax.setVar("torrentid", <?=$torrentid;?>);
     ajax.setVar("ajax", "yes");
     ajax.method = 'POST';
     ajax.element = 'ajax';
     ajax.sendAJAX(varsString);
}
</script>
<div id="loading-layer" style="display:none;font-family: Verdana;font-size: 11px;width:200px;height:50px;background:#FFF;padding:10px;text-align:center;border:1px solid #000">
     <div style="font-weight:bold" id="loading-layer-text">Loading. Please, wait...</div><br />
     <img src="pic/loading.gif" border="0" />
</div>
<?

tr("Thanks by:",$thanksby,1);
  $rezultat = mysql_num_rows(mysql_query("SELECT * FROM torrents WHERE id = '$id' AND freeleech = '1'"));

            if ($rezultat == 1)
 tr("<img src=\"pic/free.png\" />","This torrent is freeleech so only upload counts!");
		echo("</table></p>\n");
	}
	else {
		stdhead("Comments for torrent \"" . $row["name"] . "\"");
		echo("<h1>Comments for <a href=details.php?id=$id>" . $row["name"] . "</a></h1>\n");
//		echo("<p><a href=\"details.php?id=$id\">Back to full details</a></p>\n");
	}

	echo("<p><a name=\"startcomments\"></a></p>\n");
     echo("<i>Note comment update are 2 minutes</i>");
	$commentbar = "<p align=center><a class=index href=comment.php?action=add&amp;tid=$id>Add a comment</a></p>\n";


	$subres = mysql_query("SELECT COUNT(*) FROM comments WHERE torrent = $id");
	$subrow = mysql_fetch_array($subres);
	$count = $subrow[0];

	if (!$count) {
		echo("<h3>No comments yet</h3>\n");
	}
	else {
		list($pagertop, $pagerbottom, $limit) = pager(20, $count, "details.php?id=$id&", array(lastpagedefault => 1));
///////////// start cashe comments by hellix
         $file2 = "$CACHE/users/comments.txt";
$expire = 2*60; // 3 minutes
if (file_exists($file2) && filemtime($file2) > (time() - $expire)) {
$comments = unserialize(file_get_contents($file2));
} else {
		$subres = mysql_query("SELECT comments.id, text, user, comments.added, UNIX_TIMESTAMP(comments.added) as utadded, UNIX_TIMESTAMP(editedat) as uteditedat, editedby, editedat, avatar, warned, ".
                  "username, title, class, donor FROM comments LEFT JOIN users ON comments.user = users.id WHERE torrent = " .
                  "$id ORDER BY comments.id $limit") or sqlerr(__FILE__, __LINE__);
		$allrows = array();
		 while ($subrow = mysql_fetch_array($subres) ) {
        $comments[] = $subrow;
    }
    $OUTPUT = serialize($comments);
    $fp = fopen($file2,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
} // end else
foreach ($comments as $subrow)
/////////end cashe
			$allrows[] = $subrow;

		echo($commentbar);
		echo($pagertop);

		commenttable($allrows);

		echo($pagerbottom);
	}

	echo($commentbar);
}

stdfoot();
?>