<?
// DEFINE IMPORTANT CONSTANTS
define('IN_TRACKER', true);

require_once("conf.php");
require_once("secrets.php");
require_once("pmfunctions.php");
require_once("cleanup.php");
require_once("ctracker.php");

/**** validip/getip courtesy of manolete <manolete@myway.com> ****/

// IP Validation
function validip($ip)
{
	if (!empty($ip) && $ip == long2ip(ip2long($ip)))
	{
		// reserved IANA IPv4 addresses
		// http://www.iana.org/assignments/ipv4-address-space
		$reserved_ips = array (
				array('0.0.0.0','2.255.255.255'),
				array('10.0.0.0','10.255.255.255'),
				array('127.0.0.0','127.255.255.255'),
				array('169.254.0.0','169.254.255.255'),
				array('172.16.0.0','172.31.255.255'),
				array('192.0.2.0','192.0.2.255'),
				array('192.168.0.0','192.168.255.255'),
				array('255.255.255.0','255.255.255.255')
		);

		foreach ($reserved_ips as $r)
		{
				$min = ip2long($r[0]);
				$max = ip2long($r[1]);
				if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
		}
		return true;
	}
	else return false;
}

// Patched function to detect REAL IP address if it's valid
function getip() {
   if (isset($_SERVER)) {
     if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && validip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && validip($_SERVER['HTTP_CLIENT_IP'])) {
       $ip = $_SERVER['HTTP_CLIENT_IP'];
     } else {
       $ip = $_SERVER['REMOTE_ADDR'];
     }
   } else {
     if (getenv('HTTP_X_FORWARDED_FOR') && validip(getenv('HTTP_X_FORWARDED_FOR'))) {
       $ip = getenv('HTTP_X_FORWARDED_FOR');
     } elseif (getenv('HTTP_CLIENT_IP') && validip(getenv('HTTP_CLIENT_IP'))) {
       $ip = getenv('HTTP_CLIENT_IP');
     } else {
       $ip = getenv('REMOTE_ADDR');
     }
   }

   return $ip;
 }

function dbconn($autoclean = false)
{
    global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;

    if (!$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_pass))
    {
      switch ($mysqli->errno)
      {
        case 1040:
        case 2002:
            if ($_SERVER[REQUEST_METHOD] == "GET")
                die("<html><head><meta http-equiv=refresh content=\"5 $_SERVER[REQUEST_URI]\"></head><body><table border=0 width=100% height=100%><tr><td><h3 align=center>The server load is very high at the moment. Retrying, please wait...</h3></td></tr></table></body></html>");
            else
                die("Too many users. Please press the Refresh button in your browser to retry.");
        default:
            die("[" . $mysqli->errno . "] dbconn: mysql_connect: " . $mysqli->error);
      }
    }
    $mysqli->select_db($mysql_db)
        or die('dbconn: mysql_select_db: ' + $mysqli->error);

    userlogin();

    if ($autoclean)
        register_shutdown_function("autoclean");
}


function userlogin() {
    global $SITE_ONLINE;
    unset($GLOBALS["CURUSER"]);

    $ip = getip();
    $nip = ip2long($ip);
    $res = mysqli_query($mysqli,"SELECT * FROM bans WHERE $nip >= first AND $nip <= last") or sqlerr(__FILE__, __LINE__);
    if (mysqli_num_rows($res) > 0)
    {
      header("HTTP/1.0 403 Forbidden");
      echo("<html><body><h1>403 Forbidden</h1>Unauthorized IP address.</body></html>\n");
      die;
    }

    if (!$SITE_ONLINE || empty($_COOKIE["uid"]) || empty($_COOKIE["pass"]))
        return;
     $id = (int) $_COOKIE["uid"];
      if (!$id || !preg_match('/[a-f0-9]{32}/', $_COOKIE["pass"]) )
        return;
    $res = mysqli_query($mysqli,"SELECT * FROM users WHERE id = $id AND enabled='yes' AND status = 'confirmed'");// or die(mysqli_error($mysqli));
    $row = mysqli_fetch_array($res);
    if (!$row)
        return;
    $sec = hash_pad($row["secret"]);
    if ($_COOKIE["pass"] !== $row["passhash"])
        return;
    mysqli_query($mysqli,"UPDATE users SET last_access='" . get_date_time() . "', ip=".sqlesc($ip)." WHERE id=" . $row["id"]);// or die(mysqli_error($mysqli));
    $row['ip'] = $ip;
    $GLOBALS["CURUSER"] = $row;
}

function autoclean() {
    global $autoclean_interval;

    $now = time();
    $docleanup = 0;

    $res = mysqli_query($mysqli,"SELECT value_u FROM avps WHERE arg = 'lastcleantime'");
    $row = mysqli_fetch_array($res);
    if (!$row) {
        mysqli_query($mysqli,"INSERT INTO avps (arg, value_u) VALUES ('lastcleantime',$now)");
        return;
    }
    $ts = $row[0];
    if ($ts + $autoclean_interval > $now)
        return;
    mysqli_query($mysqli,"UPDATE avps SET value_u=$now WHERE arg='lastcleantime' AND value_u = $ts");
    if (!mysqli_affected_rows($mysqli))
        return;

    docleanup();
}

function unesc($x) {
    if (get_magic_quotes_gpc())
        return stripslashes($x);
    return $x;
}
function mksize($bytes)
{
    if ($bytes < 1000 * 1024)
        return number_format($bytes / 1024, 2, ".", ".") . " KB";
	    elseif ($bytes < 1000 * 1048576)
	        return number_format($bytes / 1048576, 2, ".", ".") . " MB";
		    elseif ($bytes < 1000 * 1073741824)
		        return number_format($bytes / 1073741824, 2, ".", ".") . " GB";
			    elseif ($bytes < 1000 * 1099511627776)
			        return number_format($bytes / 1099511627776, 2, ".", ".") . " TB";
				    else
				    return number_format($bytes / 1125899906842624, 2, ".", ".") . " PB";
					}

					function mksizeint($bytes)
					{
					$bytes = max(0, $bytes);
					if ($bytes < 1000)
					return number_format(floor($bytes), 0, ",", ".") . " B";
					elseif ($bytes < 1000 * 1024)
					return number_format(floor($bytes / 1024), 0, ",", ".") . " KB";
					elseif ($bytes < 1000 * 1048576)
					return number_format(floor($bytes / 1048576), 0, ",", ".") . " MB";
					elseif ($bytes < 1000 * 1073741824)
					return number_format(floor($bytes / 1073741824), 0, ",", ".") . " GB";
					elseif ($bytes < 1000 * 1099511627776)
					return number_format(floor($bytes / 1099511627776), 0, ",", ".") . " TB";
					else
					return number_format(floor($bytes / 1125899906842624), 0, ".". ".") . " PB";
					}
function deadtime() {
    global $announce_interval;
    return time() - floor($announce_interval * 1.3);
}

function mkprettytime($s) {
    if ($s < 0)
        $s = 0;
    $t = array();
    foreach (array("60:sec","60:min","24:hour","0:day") as $x) {
        $y = explode(":", $x);
        if ($y[0] > 1) {
            $v = $s % $y[0];
            $s = floor($s / $y[0]);
        }
        else
            $v = $s;
        $t[$y[1]] = $v;
    }

    if ($t["day"])
        return $t["day"] . "d " . sprintf("%02d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);
    if ($t["hour"])
        return sprintf("%d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);
//    if ($t["min"])
        return sprintf("%d:%02d", $t["min"], $t["sec"]);
//    return $t["sec"] . " secs";
}

function mkglobal($vars) {
    if (!is_array($vars))
        $vars = explode(":", $vars);
    foreach ($vars as $v) {
        if (isset($_GET[$v]))
            $GLOBALS[$v] = unesc($_GET[$v]);
        elseif (isset($_POST[$v]))
            $GLOBALS[$v] = unesc($_POST[$v]);
        else
            return 0;
    }
    return 1;
}

function tr($x,$y,$noesc=0) {
    if ($noesc)
        $a = $y;
    else {
        $a = htmlspecialchars($y);
        $a = str_replace("\n", "<br />\n", $a);
    }
    echo("<tr><td class=\"heading\" valign=\"top\" align=\"right\">$x</td><td valign=\"top\" align=left>$a</td></tr>\n");
}

function validfilename($name) {
    return preg_match('/^[^\0-\x1f:\\\\\/?*\xff#<>|]+$/si', $name);
}
function is_valid_type($type)
{
if($type == cat_name || $type == name || $type == numfiles || $type == comments || $type == rating || $type == added || $type == size || $type == times_completed || $type == seeders || $type == leechers || $type == username)
return true;
else
return false;
}

function is_valid_sort($sort)
{
if($sort == ASC || $sort == DESC)
return true;
else
return false;
}
function validemail($email)
{
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

function sqlesc($x) {
    return "'".mysql_real_escape_string($x)."'";
}

function sqlwildcardesc($x) {
    return str_replace(array("%","_"), array("\\%","\\_"), mysql_real_escape_string($x));
}

function urlparse($m) {
    $t = $m[0];
    if (preg_match(',^\w+://,', $t))
        return "<a href=\"$t\">$t</a>";
    return "<a href=\"http://$t\">$t</a>";
}

function parsedescr($d, $html) {
    if (!$html)
    {
      $d = htmlspecialchars($d);
      $d = str_replace("\n", "\n<br>", $d);
    }
    return $d;
}

function stdhead($title = "", $msgalert = true) {
    global $CURUSER, $SITE_ONLINE, $SYSOP_TESTING,$SITENAME,$TITLE ;
 if (!$SYSOP_TESTING){
      if (get_user_class() < UC_MODERATOR || !$CURUSER){
      die("<br><br><br><center><font color=red><b>Site is down for code upgrade/testing. Please check back later!</b></font></center>");
      }
  }
  if (!$SITE_ONLINE)
    die("Site is down for maintenance, please check back again later... thanks<br>");

    header("Content-Type: text/html; charset=iso-8859-1");
    //header("Pragma: No-cache");
    if ($title == "")
        $title = $SITENAME .(isset($_GET['tbv'])?" (".TBVERSION.")":'');
    else
        $title = $SITENAME .(isset($_GET['tbv'])?" (".TBVERSION.")":''). " :: " . htmlspecialchars($title);
 if ($CURUSER) {
        $ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `stylesheets` WHERE `id`=" . $CURUSER["stylesheet"]));
        if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"];
    }

    if (!$GLOBALS["ss_uri"]) {
        ($r = mysql_query("SELECT `uri` FROM `stylesheets` WHERE `default`='yes'")) or die(mysql_error());
        ($a = mysql_fetch_assoc($r)) or die(mysql_error());
        $GLOBALS["ss_uri"] = $a["uri"];
    }

    if ($msgalert && $CURUSER)
  {
    $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `folder_in`<>0 AND `receiver`=" . $CURUSER["id"] . " && `unread`='yes'") or die("OopppsY!");
    $arr = mysql_fetch_row($res);
    $unread = $arr[0];
  }
require_once("pic/" . $GLOBALS["ss_uri"]  . "/header.php");

if ($unread)
{
  echo("<p><table border=0 cellspacing=0 cellpadding=10 bgcolor=red><tr><td style='padding: 10px; background: red'>\n");
  echo("<b><font color=white>You have $messages " . ($messages != 1 ? "" : "s") . ' ('.$unread.' new)  </font></b><a href="messages.php?folder='.PM_FOLDERID_INBOX.'"><b><font color=white>Message</b></a> '."\n");
  echo("</td></tr></table></p>\n");
}

} // stdhead

function stdfoot() {
require_once("pic/" . $GLOBALS["ss_uri"]  . "/foter.php");
  }

function genbark($x,$y) {
    stdhead($y);
    print("<h2>" . safechar($y) . "</h2>\n");
    print("<p>" . safechar($x) . "</p>\n");
    stdfoot();
    exit();
}

function mksecret($length = 20) {
$set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
$str;
for($i = 1; $i <= $length; $i++) {
$ch = rand(0, count($set)-1);
$str .= $set[$ch];
}
return $str;
}

function httperr($code = 404) {
    header("HTTP/1.0 404 Not found");
    echo("<h1>Not Found</h1>\n");
    echo("<p>Sorry pal :(</p>\n");
    exit();
}

function gmtime()
{
    return strtotime(get_date_time());
}
function logincookie($id, $passhash, $updatedb = 1, $expires = 0x7fffffff)
{
	setcookie("uid", $id, $expires, "/");
	setcookie("pass", $passhash, $expires, "/");

  if ($updatedb)
  	mysql_query("UPDATE users SET last_login = NOW() WHERE id = $id");
}


function logoutcookie() {
    setcookie("uid", "", 0x7fffffff, "/");
    setcookie("pass", "", 0x7fffffff, "/");
}

function loggedinorreturn() {
    global $CURUSER;
    if (!$CURUSER) {
          header("Location: login.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]));
        exit();
    }
}

function deletetorrent($id) {
    global $torrent_dir;
    mysql_query("DELETE FROM torrents WHERE id = $id");
    mysql_query("DELETE FROM ratings WHERE id = $id");
    mysql_query("DELETE FROM bookmarks WHERE id = $id");
    mysql_query("DELETE FROM thanks WHERE id = $id");
    foreach(explode(".","peers.files.comments.ratings") as $x)
        mysql_query("DELETE FROM $x WHERE torrent = $id");
}
function pager($rpp, $count, $href, $opts = array()) {
    $pages = ceil($count / $rpp);

    if (!$opts["lastpagedefault"])
        $pagedefault = 0;
    else {
        $pagedefault = floor(($count - 1) / $rpp);
        if ($pagedefault < 0)

            $pagedefault = 0;
    }


    if (isset($_GET["page"])) {
       $page = (int) $_GET["page"];
        if ($page < 0)
            $page = $pagedefault;

    }

    else
        $page = $pagedefault;

    $pager = "";

    if(isset($_GET["sort"]))
{
$file=htmlspecialchars($_GET["sort"]);
$type=htmlspecialchars($_GET['d']);
$loc=htmlspecialchars($_GET['h']);
$sort="&sort=$file&h=$loc&d=$type";
}
else
$sort="";

    $mp = $pages - 1;
    $as = "<b>&lt;&lt;&nbsp;Prev</b>";
    if ($page >= 1) {
        $pager .= "<a href=\"{$href}page=" . ($page - 1) . "" . $sort . "\">";
        $pager .= $as;

        $pager .= "</a>";
    }
    else
        $pager .= $as;

$pager .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $as = "<b>Next&nbsp;&gt;&gt;</b>";
    if ($page < $mp && $mp >= 0) {
        $pager .= "<a href=\"{$href}page=" . ($page + 1) . "" . $sort . "\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;

    if ($count) {
        $pagerarr = array();
        $dotted = 0;
        $dotspace = 3;
        $dotend = $pages - $dotspace;
        $curdotend = $page - $dotspace;
        $curdotstart = $page + $dotspace;
        for ($i = 0; $i < $pages; $i++) {
            if (($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)) {
                if (!$dotted)
                    $pagerarr[] = "...";
                $dotted = 1;
                continue;
            }


            $dotted = 0;
            $start = $i * $rpp + 1;

            $end = $start + $rpp - 1;
            if ($end > $count)
                $end = $count;
            $text = "$start&nbsp;-&nbsp;$end";
            if ($i != $page)
                $pagerarr[] = "<a href=\"{$href}page=$i" . $sort . "\"><b>$text</b></a>";

            else


                $pagerarr[] = "<b>$text</b>";
        }
        $pagerstr = join(" | ", $pagerarr);
        $pagertop = "<p align=\"center\">$pager<br />$pagerstr</p>\n";
        $pagerbottom = "<p align=\"center\">$pagerstr<br />$pager</p>\n";
    }
    else {
        $pagertop = "<p align=\"center\">$pager</p>\n";

        $pagerbottom = $pagertop;
    }

    $start = $page * $rpp;

    return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");
}
function downloaderdata($res) {
    $rows = array();
    $ids = array();
    $peerdata = array();
    while ($row = mysql_fetch_assoc($res)) {
        $rows[] = $row;

        $id = $row["id"];
        $ids[] = $id;
        $peerdata[$id] = array(downloaders => 0, seeders => 0, comments => 0);
    }

    if (count($ids)) {
        $allids = implode(",", $ids);


        $res = mysql_query("SELECT COUNT(*) AS c, torrent, seeder FROM peers WHERE torrent IN ($allids) GROUP BY torrent, seeder");

        while ($row = mysql_fetch_assoc($res)) {
            if ($row["seeder"] == "yes")
                $key = "seeders";

            else
                $key = "downloaders";
            $peerdata[$row["torrent"]][$key] = $row["c"];
        }

        $res = mysql_query("SELECT COUNT(*) AS c, torrent FROM comments WHERE torrent IN ($allids) GROUP BY torrent");
        while ($row = mysql_fetch_assoc($res)) {
            $peerdata[$row["torrent"]]["comments"] = $row["c"];
        }
    }

    return array($rows, $peerdata);

}

function commenttable($rows)
{
	global $CURUSER, $pic_base_url;
	begin_main_frame();
	begin_frame();
	$count = 0;
	foreach ($rows as $row)
	{
		echo("<p class=sub>#" . $row["id"] . " by ");
    if (isset($row["username"]))
		{
			$title = $row["title"];
			if ($title == "")
				$title = get_user_class_name($row["class"]);
			else
				$title = htmlspecialchars($title);
        echo("<a name=comm". $row["id"] .
        	" href=userdetails.php?id=" . $row["user"] . "><b>" .
        	htmlspecialchars($row["username"]) . "</b></a>" . ($row["donor"] == "yes" ? "<img src=\"{$pic_base_url}star.gif\" alt='Donor'>" : "") . ($row["warned"] == "yes" ? "<img src=".
    			"\"{$pic_base_url}warned.gif\" alt=\"Warned\">" : "") . " ($title)\n");
		}
		else
   		echo("<a name=\"comm" . $row["id"] . "\"><i>(orphaned)</i></a>\n");

		echo(" at " . $row["added"] . " GMT" .
			($row["user"] == $CURUSER["id"] || get_user_class() >= UC_MODERATOR ? "- [<a href=comment.php?action=edit&amp;cid=$row[id]>Edit</a>]" : "") .
			(get_user_class() >= UC_MODERATOR ? "- [<a href=comment.php?action=delete&amp;cid=$row[id]>Delete</a>]" : "") .
			($row["editedby"] && get_user_class() >= UC_MODERATOR ? "- [<a href=comment.php?action=vieworiginal&amp;cid=$row[id]>View original</a>]" : "") . "</p>\n");
		$avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($row["avatar"]) : "");
		if (!$avatar)
			$avatar = "{$pic_base_url}default_avatar.gif";
		$text = format_comment($row["text"]);
    if ($row["editedby"])
    	$text .= "<p><font size=1 class=small>Last edited by <a href=userdetails.php?id=$row[editedby]><b>$row[username]</b></a> at $row[editedat] GMT</font></p>\n";
		begin_table(true);
		echo("<tr valign=top>\n");
		echo("<td align=center width=150 style='padding: 0px'><img width=150 src=\"{$avatar}\"></td>\n");
		echo("<td class=text>$text</td>\n");
		echo("</tr>\n");
     end_table();
  }
	end_frame();
	end_main_frame();
}

function searchfield($s) {
    return preg_replace(array('/[^a-z0-9]/si', '/^\s*/s', '/\s*$/s', '/\s+/s'), array(" ", "", "", " "), $s);
}

function genrelist() {
    $ret = array();
    $res = mysql_query("SELECT id, name FROM categories ORDER BY name");
    while ($row = mysql_fetch_array($res))
        $ret[] = $row;
    return $ret;
}


function linkcolor($num) {
    if (!$num)
        return "red";
//    if ($num == 1)
//        return "yellow";
    return "green";
}

function ratingpic($num) {
    global $pic_base_url;
    $r = round($num * 2) / 2;
    if ($r < 1 || $r > 5)
        return;
    return "<img src=\"{$pic_base_url}{$r}.gif\" border=\"0\" alt=\"rating: $num / 5\" />";
}
function torrenttable($records, $href, $variant = "index") {
	global $pic_base_url, $CURUSER;



	/*if ($CURUSER["class"] < UC_VIP)
  {

	  $gigs = $CURUSER["uploaded"] / (1024*1024*1024);


	  $ratio = (($CURUSER["downloaded"] > 0) ? ($CURUSER["uploaded"] / $CURUSER["downloaded"]) : 0);
	  if ($ratio < 0.5 || $gigs < 5) $wait = 0;

	  elseif ($ratio < 0.65 || $gigs < 6.5) $wait = 0;
	  elseif ($ratio < 0.8 || $gigs < 8) $wait = 0;
	  elseif ($ratio < 0.95 || $gigs < 9.5) $wait = 0;
	  else $wait = 0;
  }*/

     $sort[1] = '&d=ASC';
     $sort[2] = '&d=ASC';
     $sort[3] = '&d=DESC';
     $sort[4] = '&d=DESC';
     $sort[5] = '&d=DESC';
     $sort[6] = '&d=DESC';
     $sort[7] = '&d=DESC';
     $sort[8] = '&d=DESC';
     $sort[9] = '&d=DESC';
     $sort[10] = '&d=DESC';
     $sort[11] = '&d=DESC';
     $sort[12] = '&d=ASC';

if(isset($_GET["sort"]))

{
  $h = $_GET['h'];
  $order = $_GET['d'];
  $type= $_GET['sort'];
  	if($order == 'ASC')
	$sort[$h]='&d=DESC';
	else
	$sort[$h]='&d=ASC';

}


?>
<tr>
<head>
	<style type="text/css" media="screen">@import "tabs.css";</style>
</head>

<body>
	<div id="header5">
	<ul id="primary">
		<li><a href="bookmarks.php?id=<?=$CURUSER['id']?>&op=view&op=view">My Bookmarks</a></li>
		<li><a href="mytorrents.php">My Torrents</a></li>
		<li><span>Browse</span></li>

	</ul>
	</div>

<table border="1" width=710 cellspacing="0" cellpadding="5">
<tr>
<td class="colhead" align="center"><a href="<?=$href ?>sort=cat_name&h=1<?print $sort[1]?>">
Type</a></td>
<td class="colhead" align=left><a href="<?=$href ?>sort=name&h=2<?print $sort[2]?>">
Name</a></td>
<!--<td class="heading" align=left>DL</td>-->
<?
	if ($wait)
	{
		echo("<td class=\"colhead\" align=\"center\">Wait</td>\n");
	}

	if ($variant == "mytorrents")
  {
  	echo("<td class=\"colhead\" align=\"center\">Edit</td>\n");
    echo("<td class=\"colhead\" align=\"center\">Visible</td>\n");
	}

?>

<td class="colhead" align=right><a href="<?=$href ?>sort=numfiles&h=3<?print $sort[3]?>">
Files</a></td>

<td class="colhead" align=right><a href="<?=$href ?>sort=comments&h=4<?print $sort[4]?>">
Comm.</a></td>
<!--
<td class="colhead" align="center"><a href="<?=$href ?>sort=rating&h=5<?print $sort[5]?>">Rating</a></td>
-->
<td class="colhead" align="center"><a href="<?=$href ?>sort=added&h=6<?print $sort[6]?>">
Added</a></td>
<td class="colhead" align="center"><a href="<?=$href ?>sort=added&h=7<?print $sort[7]?>">
Time Alive</a></td>
<td class="colhead" align="center"><a href="<?=$href ?>sort=size&h=8<?print $sort[8]?>">
Size</a></td>
<!--
<td class="colhead" align=right>Views</td>
<td class="colhead" align=right>Hits</td>
-->
<td class="colhead" align="center"><a href="<?=$href ?>sort=times_completed&h=9<?print $sort[9]?>">
Snatched</a></td>

<td class="colhead" align=right><a href="<?=$href ?>sort=seeders&h=10<?print $sort[10]?>">
Seeders</a></td>
<td class="colhead" align=right><a href="<?=$href ?>sort=leechers&h=11<?print $sort[11]?>">
Leechers</a></td>



<?

    if ($variant == "index" && get_user_class() >= UC_POWER_USER)

        echo("<td class=\"colhead\" align=center><a href=".$href."sort=username&h=12$sort[12]$search>Upped&nbsp;by</a></td>\n");


    echo("</tr>\n");

    foreach ($records as $row) {
        $id = $row["id"];
        echo("<tr>\n");


        echo("<td align=center style='padding: 0px'>");
        if (isset($row["cat_name"])) {
            echo("<a href=\"browse.php?cat=" . $row["category"] . "\">");
            if (isset($row["cat_pic"]) && $row["cat_pic"] != "")

              echo("<img border=\"0\" src=\"{$pic_base_url}{$row['cat_pic']}\" alt=\"{$row['cat_name']}\" />");
            else
                print($row["cat_name"]);
            echo("</a>");
        }
        else
            echo("-");
        echo("</td>\n");

        $dispname = htmlspecialchars($row["name"]);
        $freeleech = mysql_result(mysql_query("SELECT freeleech FROM torrents WHERE id = '$id'"), 0);

        if ($freeleech == 1)
        {
            $dispname = htmlspecialchars($row["name"]) . " </a>&nbsp;&nbsp;<img src=\"pic/free.png\" />";
        }
        echo("<td align=left><a href=\"details.php?");
        if ($variant == "mytorrents")
            echo("returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;");
        echo("id=$id");
        if ($variant == "index")
            echo("&amp;hit=1");

$browse_res = mysql_query("SELECT last_browse FROM users WHERE id='".$CURUSER['id']."'");

$browse_arr = mysql_fetch_row($browse_res);
$last_browse = $browse_arr[0];
$download = "<img style=border:none alt=download src=pic/download.gif align=right>";
$time_now = gmtime();
if ($last_browse > $time_now) {
   $last_browse=$time_now;
}

        if (sql_timestamp_to_unix_timestamp($row["added"]) >= $last_browse)
                echo("\"><b>$dispname</b></a> <b>(<font color=red>NEW</font>)</b><a class=\"index\" href=\"download.php/$id/" . rawurlencode($row["filename"]) . "\">$download</a>");

        else
                echo("\"><b>$dispname</b></a><a class=\"index\" href=\"download.php/$id/" . rawurlencode($row["filename"]) . "\">$download</a>");

				if ($wait)
				{
				  $elapsed = floor((gmtime() - strtotime($row["added"])) / 3600);
	        if ($elapsed < $wait)
	        {

	          $color = dechex(floor(127*($wait - $elapsed)/48 + 128)*65536);
	          echo("<td align=center><nobr><a href=\"/faq.php#dl8\"><font color=\"$color\">" . number_format($wait - $elapsed) . " h</font></a></nobr></td>\n");

	        }
	        else
	          echo("<td align=center><nobr>None</nobr></td>\n");
        }

/*
        if ($row["nfoav"] && get_user_class() >= UC_POWER_USER)
          echo("<a href=viewnfo.php?id=$row[id]><img src=pic/viewnfo.gif border=0 alt='View NFO'></a>\n");
        if ($variant == "index")
            echo("<a href=\"download.php/$id/" . rawurlencode($row["filename"]) . "\"><img src=pic/download.gif border=0 alt=Download></a>\n");

        else */ if ($variant == "mytorrents")
            echo("<td align=\"center\"><a href=\"edit.php?returnto=" . urlencode($_SERVER["REQUEST_URI"]) . "&amp;id=" . $row["id"] . "\">edit</a>\n");
echo("</td>\n");
        if ($variant == "mytorrents") {
            echo("<td align=\"right\">");


            if ($row["visible"] == "no")
                echo("<b>no</b>");
            else


                echo("yes");
            echo("</td>\n");
        }


        if ($row["type"] == "single")
            echo("<td align=\"right\">" . $row["numfiles"] . "</td>\n");
        else {
            if ($variant == "index")
                echo("<td align=\"right\"><b><a href=\"details.php?id=$id&amp;hit=1&amp;filelist=1\">" . $row["numfiles"] . "</a></b></td>\n");
            else
                echo("<td align=\"right\"><b><a href=\"details.php?id=$id&amp;filelist=1#filelist\">" . $row["numfiles"] . "</a></b></td>\n");
        }


        if (!$row["comments"])
            echo("<td align=\"right\">" . $row["comments"] . "</td>\n");
        else {
            if ($variant == "index")


                echo("<td align=\"right\"><b><a href=\"details.php?id=$id&amp;hit=1&amp;tocomm=1\">" . $row["comments"] . "</a></b></td>\n");
            else
                echo("<td align=\"right\"><b><a href=\"details.php?id=$id&amp;page=0#startcomments\">" . $row["comments"] . "</a></b></td>\n");
        }


        /*echo("<td align=\"center\">");

        if (!isset($row["rating"]))
            echo("---");
        else {
            $rating = round($row["rating"] * 2) / 2;
            $rating = ratingpic($row["rating"]);
            if (!isset($rating))
                echo("---");
            else

                print($rating);

        }
        echo("</td>\n");*/
       $timezone = display_date_time($row["utadded"] , $CURUSER[tzoffset] );
        echo("<td align=center><nobr>" . str_replace(" ", "<br />", $timezone) . "</nobr></td>\n");
		$ttl = floor((gmtime() - sql_timestamp_to_unix_timestamp($row["added"])) / 3600);



		if ($ttl == 1) $ttl .= "<br>hour"; else $ttl .= "<br>hours";
        echo("<td align=center>$ttl</td>\n");
        echo("<td align=center>" . str_replace(" ", "<br>", mksize($row["size"])) . "</td>\n");
//        echo("<td align=\"right\">" . $row["views"] . "</td>\n");
//        echo("<td align=\"right\">" . $row["hits"] . "</td>\n");
        $_s = "";
        if ($row["times_completed"] != 1)
          $_s = "s";


        echo("<td align=center>" . number_format($row["times_completed"]) . "<br>time$_s</td>\n");




        if ($row["seeders"]) {
            if ($variant == "index")
            {
		if (get_user_class() >= UC_POWER_USER)
		{
               		if ($row["leechers"]) $ratio = $row["seeders"] / $row["leechers"]; else $ratio = 1;
               	 	echo("<td align=right><b><a href=details.php?id=$id&amp;hit=1&amp;toseeders=1><font color=" . get_slr_color($ratio) . ">" . $row["seeders"] . "</font></a></b></td>\n");
		}
		else
		echo("<td align=\"right\"><span class=\"" . linkcolor($row["seeders"]) . "\">" . $row["seeders"] . "</span></td>\n");
            }
            else
            {
		if (get_user_class() >= UC_POWER_USER)
                   echo("<td align=\"right\"><b><a class=\"" . linkcolor($row["seeders"]) . "\" href=\"details.php?id=$id&amp;dllist=1#seeders\">" . $row["seeders"] . "</a></b></td>\n");
		else
                   echo("<td align=\"right\"><span class=\"" . linkcolor($row["seeders"]) . "\">" . $row["seeders"] . "</span></td>\n");
	   }
        }
        else
            echo("<td align=\"right\"><span class=\"" . linkcolor($row["seeders"]) . "\">" . $row["seeders"] . "</span></td>\n");

        if ($row["leechers"]) {
            if ($variant == "index")
            {
		if (get_user_class() >= UC_POWER_USER)
		{
                echo("<td align=right><b><a href=details.php?id=$id&amp;hit=1&amp;todlers=1>" .
                   number_format($row["leechers"]) . ($peerlink ? "</a>" : "") .
                   "</b></td>\n");

		}
		else
                echo("<td align=right>" . number_format($row["leechers"]) . ($peerlink ? "" : "") . "</td>\n");
            }
            else
            {
		if (get_user_class() >= UC_POWER_USER)

		{
                echo("<td align=\"right\"><b><a class=\"" . linkcolor($row["leechers"]) . "\" href=\"details.php?id=$id&amp;dllist=1#leechers\">" .
                  $row["leechers"] . "</a></b></td>\n");
		}
		else
                echo("<td align=\"right\">" . $row["leechers"] . "</td>\n");
            }
        }
        else
            echo("<td align=\"right\">0</td>\n");

        if ($variant == "index" && get_user_class() >= UC_POWER_USER)
            echo("<td align=center>" . (isset($row["username"]) ? ("<a href=userdetails.php?id=" . $row["owner"] . "><b>" . htmlspecialchars($row["username"]) . "</b></a>") : "<i>(unknown)</i>") . "</td>\n");

        echo("</tr>\n");
    }

    echo("</table>\n");

    return $rows;
}

function hash_pad($hash) {
    return str_pad($hash, 20);
}

function hash_where($name, $hash) {
    $shhash = preg_replace('/ *$/s', "", $hash);
    return "($name = " . sqlesc($hash) . " OR $name = " . sqlesc($shhash) . ")";
}

function get_user_icons($arr, $big = false)
{
	global $pic_base_url;
	if ($big)
	{
		$donorpic = "starbig.gif";
		$warnedpic = "warnedbig.gif";
		$disabledpic = "disabledbig.gif";
		$style = "style='margin-left: 4pt'";
	}
	else
	{
		$donorpic = "star.gif";
		$warnedpic = "warned.gif";
		$disabledpic = "disabled.gif";
		$style = "style=\"margin-left: 2pt\"";
	}
	$pics = $arr["donor"] == "yes" ? "<img src=\"{$pic_base_url}{$donorpic}\" alt='Donor' border=0 $style>" : "";
	if ($arr["enabled"] == "yes")
		$pics .= $arr["warned"] == "yes" ? "<img src=\"{$pic_base_url}{$warnedpic}\" alt=\"Warned\" border=0 $style>" : "";
	else
		$pics .= "<img src=\"{$pic_base_url}{$disabledpic}\" alt=\"Disabled\" border=0 $style>\n";
	return $pics;
}
function unsafeChar($var)
{
    return str_replace(array("&gt;", "&lt;", "&quot;", "&amp;"), array(">", "<", "\"", "&"), $var);
}
function safechar($var)
{
    return htmlspecialchars(unsafeChar($var));
}
function makeSafeText($arr) {
    foreach ($arr as $k => $v) {
        if (is_array($v))
            $arr[$k] = makeSafeText($v);
        else
            $arr[$k] = safeChar($v);
    }
    return $arr;
}
function usercommenttable($rows)
{
	global $CURUSER, $pic_base_url;
	begin_main_frame();
	begin_frame();
	$count = 0;
	foreach ($rows as $row)
	{
		echo("<p class=sub>#" . $row["id"] . " by ");
    if (isset($row["username"]))
		{
			$title = $row["title"];
			if ($title == "")
				$title = get_user_class_name($row["class"]);
			else
				$title = htmlspecialchars($title);
        echo("<a name=comm". $row["id"] .
        	" href=userdetails.php?id=" . $row["user"] . "><b>" .
        	htmlspecialchars($row["username"]) . "</b></a>" . ($row["donor"] == "yes" ? "<img src=\"{$pic_base_url}star.gif\" alt='Donor'>" : "") . ($row["warned"] == "yes" ? "<img src=".
    			"\"{$pic_base_url}warned.gif\" alt=\"Warned\">" : "") . " ($title)\n");
		}
		else
   		echo("<a name=\"comm" . $row["id"] . "\"><i>(orphaned)</i></a>\n");

		echo(" at " . $row["added"] . " GMT" .
			($row["user"] == $CURUSER["id"] || get_user_class() >= UC_MODERATOR ? "- [<a href=usercomment.php?action=edit&amp;cid=$row[id]>Edit</a>]" : "") .
			(get_user_class() >= UC_MODERATOR ? "- [<a href=usercomment.php?action=delete&amp;cid=$row[id]>Delete</a>]" : "") .
			($row["editedby"] && get_user_class() >= UC_MODERATOR ? "- [<a href=usercomment.php?action=vieworiginal&amp;cid=$row[id]>View original</a>]" : "") . "</p>\n");
		$avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($row["avatar"]) : "");
		if (!$avatar)
			$avatar = "{$pic_base_url}default_avatar.gif";
		$text = format_comment($row["text"]);
    if ($row["editedby"])
    	$text .= "<p><font size=1 class=small>Last edited by <a href=userdetails.php?id=$row[editedby]><b>$row[username]</b></a> at $row[editedat] GMT</font></p>\n";
		begin_table(true);
		echo("<tr valign=top>\n");
		echo("<td align=center width=150 style='padding: 0px'><img width=150 src=\"{$avatar}\"></td>\n");
		echo("<td class=text>$text</td>\n");
		echo("</tr>\n");
     end_table();
  }
	end_frame();
	end_main_frame();
}
function failedloginscheck () {
global $maxloginattempts;
$total = 0;
$ip = sqlesc(getip());
$Query = mysql_query("SELECT SUM(attempts) FROM loginattempts WHERE ip=$ip") or sqlerr(__FILE__, __LINE__);
list($total) = mysql_fetch_array($Query);
if ($total >= $maxloginattempts) {
mysql_query("UPDATE loginattempts SET banned = 'yes' WHERE ip=$ip") or sqlerr(__FILE__, __LINE__);
stderr("Login Locked!", "You have been <b>exceed maximum login attempts</b>, therefore your ip address <b>(".htmlspecialchars($ip).")</b> has been banned.");
}
}
function failedlogins () {
$ip = sqlesc(getip());
$added = sqlesc(get_date_time());
$a = (@mysql_fetch_row(@mysql_query("select count(*) from loginattempts where ip=$ip"))) or sqlerr(__FILE__, __LINE__);
if ($a[0] == 0)
mysql_query("INSERT INTO loginattempts (ip, added, attempts) VALUES ($ip, $added, 1)") or sqlerr(__FILE__, __LINE__);
else
mysql_query("UPDATE loginattempts SET attempts = attempts + 1 where ip=$ip") or sqlerr(__FILE__, __LINE__);

stderr("Login failed!","<b>Error</b>: Username or password incorrect<br>Don't remember your password? <b><a href=recover.php>Recover</a></b> your password!");
}
function parked()
{
    global $CURUSER;
    if ($CURUSER["parked"] == "yes")
        stderr("Error", "your account is parked.");
}
function do_cache($fname, $expire, $sql, $CACHE_ENABLED =1)

	 {



		if ( $CACHE_ENABLED == 2 ||

			($CACHE_ENABLED   && file_exists($fname) && filemtime($fname) > (time() - $expire)))

		    return unserialize(file_get_contents($fname));



		$data = array();

		$res = db_query($sql, MYSQL_ASSOC);

		if($res != DB_NOT_FOUND)	{

			while ($r = mysql_fetch_array($res) )

			       $data[] = $r;

	    }

		if ($CACHE_ENABLED )	{

	    	$fp = fopen($fname,"w");

		    fputs($fp, serialize($data));

			fclose($fp);

		}

		return $data;

	 }

	 function do_html_cache($fname, $expire, $include, $CACHE_ENABLED =1)

	 	{



		if ( $CACHE_ENABLED == 2 ||

			($CACHE_ENABLED   && file_exists($fname) && filemtime($fname) > (time() - $expire)))

		    return (file_get_contents($fname));



		ob_start();

		include $include;

		$data = ob_get_contents();

		ob_end_clean();



		if ($CACHE_ENABLED )	{

	    	$fp = fopen($fname,"w");

		    fputs($fp, ($data));

			fclose($fp);

		}

		return $data;

	 }
function db_query($query)

   {

     if ($GLOBALS['QUERY_LOG'])	$GLOBALS['QUERY'][]= $query;

     $result = mysql_query($query) or sqlerr(__FILE__, __LINE__, $query);

	 if (mysql_num_rows($result)==0)

	 	return DB_NOT_FOUND;

	 return $result;

   }

function sql_query ($query)
  {
    if (!defined ('DEBUGMODE'))
    {
      $query_start = array_sum (explode (' ', microtime ()));
    }

    $return = mysql_query ($query);
    if (!defined ('DEBUGMODE'))
    {
      $query_end = round (array_sum (explode (' ', microtime ())) - $query_start, 4);
      $_SESSION['queries'][] = array ('id' => intval ($_SESSION['totalqueries']), 'query_time' => substr ($query_end, 0, 8), 'query' => safechar($query));
      ++$_SESSION['totalqueries'];
    }

    return $return;
  }
////////////end modified sqlquery handler/////////////////
function get_user_class_color2($class, $username)
{
    switch ($class)
    {
        case UC_POWER_USER: return "4F3157";
        case UC_VIP: return "FF6600";
        case UC_UPLOADER: return "9A6258";
        case UC_MODERATOR: return "6B001A";
        case UC_ADMINISTRATOR: return "FF0000";
        case UC_SYSOP: return "FF0000";
    }
      return "$username";
}
 function get_user_class_color($class)
{
    switch ($class)
    {
        case UC_POWER_USER: return "4F3157";
        case UC_VIP: return "FF6600";
        case UC_UPLOADER: return "9A6258";
        case UC_MODERATOR: return "6B001A";
        case UC_ADMINISTRATOR: return "FF0000";
        case UC_SYSOP: return "FF0000";
    }
    return "";
}
function referer() {
   global $domain;
	$refer  = $_SERVER['HTTP_REFERER'];
    $ip = $_SERVER['REMOTE_ADDR'];
	if (($refer) and (!strstr($refer, $domain))) {
      $sql = "INSERT INTO referer (url,ip) VALUES ('$refer','$ip')";
	   $result = mysql_query($sql);

	}

}
function whois($domainName) {
    $whoisServer = "whois.geektools.com";//server where the query is sent
    $output = "";

    $connection = fsockopen($whoisServer, 43);//connect to  server
    //return error if could not connect to server
    if (!$connection) {
        $output = "Sorry, we could not connect to the server. Please try again later.";
    }
    else {
        fwrite($connection, $domainName . "\r\n");//send query to server
        //catch server reply
        while (!feof($connection)) {
            $output .= fgets($connection);
        }
        fclose($connection);
    }

    $output = str_replace("\n", "<br />\n", $output);
    return $output;
}
if (!function_exists("htmlspecialchars_uni")) {
	function htmlspecialchars_uni($message) {
		$message = preg_replace("#&(?!\#[0-9]+;)#si", "&amp;", $message); // Fix & but allow unicode
		$message = str_replace("<","&lt;",$message);
		$message = str_replace(">","&gt;",$message);
		$message = str_replace("\"","&quot;",$message);
		$message = str_replace("  ", "&nbsp;&nbsp;", $message);
		return $message;
	}
}
function int_check($value,$stdhead = false, $stdfood = true, $die = true, $log = true) {
	global $CURUSER;
	$msg = "Invalid ID Attempt: Username: ".$CURUSER["username"]." - UserID: ".$CURUSER["id"]." - UserIP : ".getip();
	if ( is_array($value) ) {
        foreach ($value as $val) int_check ($val);
    } else {
	    if (!is_valid_id($value)) {
		    if ($stdhead) {
			    if ($log)
		    		write_log($msg);
		    	stderr("ERROR","Invalid ID! For security reason, we have been logged this action.");
	    }else {
			    Print ("<h2>Error</h2><table width=100% border=1 cellspacing=0 cellpadding=10><tr><td class=text>");
				Print ("Invalid ID! For security reason, we have been logged this action.</td></tr></table>");
				if ($log)
					write_log($msg);
	    }

		    if ($stdfood)
		    	stdfoot();
		    if ($die)
		    	die;
	    }
	    else
	    	return true;
    }
}
// Prevent any possible XSS attacks via $_GET.
foreach ($_GET as $check_url) {
	if (!is_array($check_url)) {
		$check_url = str_replace("\"", "", $check_url);
		if ((preg_match("#<[^>]*script*\"?[^>]*>#", $check_url)) || (preg_match("#<[^>]*object*\"?[^>]*>#", $check_url)) ||
			(preg_match("#<[^>]*iframe*\"?[^>]*>#", $check_url)) || (preg_match("#<[^>]*applet*\"?[^>]*>#", $check_url)) ||
			(preg_match("#<[^>]*meta*\"?[^>]*>#", $check_url)) || (preg_match("#<[^>]*style*\"?[^>]*>#", $check_url)) ||
			(preg_match("#<[^>]*form*\"?[^>]*>#", $check_url)) || (preg_match("#\([^>]*\"?[^)]*\)#", $check_url))) {
		die ();
		}
	}
}
require_once "global.php";
require_once "html.php";
?>