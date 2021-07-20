<?
ob_start("ob_gzhandler");
require_once("include/functions.php");
dbconn(false);
//referer();
loggedinorreturn();
parked();
$cats = genrelist();
$searchstr = unesc($_GET["search"]);
$cleansearchstr = searchfield($searchstr);
if (empty($cleansearchstr))
	unset($cleansearchstr);

if(isset($_GET["sort"]))
{
  $type = $_GET['sort'];
	  if (!is_valid_type($type))
	  {
		$msg = sqlesc("Invalid type: $type. Username: $CURUSER[username]\n");
		$dt = sqlesc(get_date_time());
  		mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(" . $CURUSER["id"] . ", 10, '" . get_date_time() . "' , $msg, 0 )") or sqlerr(__FILE__, __LINE__);
		stderr("Error", "Invalid type: $type.");
	  }

$sort =htmlspecialchars( $_GET['d']);
	  if (!is_valid_sort($sort))
	  {
		$msg = sqlesc("Invalid sort: $sort. Username: $CURUSER[username]\n");
		$dt = sqlesc(get_date_time());
  		mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(" . $CURUSER["id"] . ", 10, '" . get_date_time() . "' , $msg, 0 )") or sqlerr(__FILE__, __LINE__);
		stderr("Error", "Invalid sort: $sort.");
	  }
$orderby = "ORDER BY $type $sort";
}
else
$orderby = "ORDER BY torrents.id DESC";


$addparam = "";
$wherea = array();
$wherecatina = array();

if ($_GET["incldead"] == 1)
{
	$addparam .= "incldead=1&amp;";
	if (!isset($CURUSER) || get_user_class < UC_ADMINISTRATOR)
		$wherea[] = "banned != 'yes'";
}
elseif ($_GET["incldead"] == 2)
{
	$addparam .= "incldead=2&amp;";
		$wherea[] = "visible = 'no'";
}
	else
		$wherea[] = "visible = 'yes'";

$category = htmlspecialchars($_GET["cat"]);

$all = htmlspecialchars($_GET["all"]);

if (!$all)
	if (!$_GET && $CURUSER["notifs"])
	{
	  $all = True;
	  foreach ($cats as $cat)
	  {
	    $all &= $cat[id];
	    if (strpos($CURUSER["notifs"], "[cat" . $cat[id] . "]") !== False)
	    {
	      $wherecatina[] = $cat[id];
	      $addparam .= "c$cat[id]=1&amp;";
	    }
	  }
	}
	elseif ($category)
	{
	  if (!is_valid_id($category))
	    stderr("Error", "Invalid category ID $category.");
	  $wherecatina[] = $category;
	  $addparam .= "cat=$category&amp;";
	}
	else
	{
	  $all = True;
	  foreach ($cats as $cat)
	  {
	    $all &= $_GET["c$cat[id]"];
	    if ($_GET["c$cat[id]"])
	    {
	      $wherecatina[] = $cat[id];
	      $addparam .= "c$cat[id]=1&amp;";
	    }
	  }
	}

if ($all)
{
	$wherecatina = array();
  $addparam = "";
}

if (count($wherecatina) > 1)
	$wherecatin = implode(",",$wherecatina);
elseif (count($wherecatina) == 1)
	$wherea[] = "category = $wherecatina[0]";

$wherebase = $wherea;

if (isset($cleansearchstr))
{
	$wherea[] = "MATCH (search_text, ori_descr) AGAINST (" . sqlesc($searchstr) . ")";
	//$wherea[] = "0";
	$addparam .= "search=" . urlencode($searchstr) . "&amp;";
	if(isset($_GET["sort"]))
		{
  $type = htmlspecialchars($_GET['sort']);
	  if (!is_valid_type($type))
	  {
		$msg = sqlesc("Invalid type: $type. Username: $CURUSER[username]\n");
		$dt = sqlesc(get_date_time());
  		mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(" . $CURUSER["id"] . ", 10, '" . get_date_time() . "' , $msg, 0 )") or sqlerr(__FILE__, __LINE__);
		stderr("Error", "Invalid type: $type.");
	  }

$sort = htmlspecialchars($_GET['d']);
	  if (!is_valid_sort($sort))
	  {
		$msg = sqlesc("Invalid sort: $sort. Username: $CURUSER[username]\n");
		$dt = sqlesc(get_date_time());
  		mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(" . $CURUSER["id"] . ", 10, '" . get_date_time() . "' , $msg, 0 )") or sqlerr(__FILE__, __LINE__);
		stderr("Error", "Invalid sort: $sort.");
	  }
$orderby = "ORDER BY $type $sort";

		}
	else
	$orderby = "ORDER BY torrents.id DESC";
}

$where = implode(" AND ", $wherea);
if ($wherecatin)
	$where .= ($where ? " AND " : "") . "category IN(" . $wherecatin . ")";

if ($where != "")
	$where = "WHERE $where";

$res = mysql_query("SELECT COUNT(*) FROM torrents $where") or die(mysql_error());
$row = mysql_fetch_array($res);
$count = $row[0];

if (!$count && isset($cleansearchstr)) {
	$wherea = $wherebase;
	if(isset($_GET["sort"]))
		{
  $type =htmlspecialchars( $_GET['sort']);
	  if (!is_valid_type($type))
	  {
		$msg = sqlesc("Invalid type: $type. Username: $CURUSER[username]\n");
		$dt = sqlesc(get_date_time());
  		mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(" . $CURUSER["id"] . ", 10, '" . get_date_time() . "' , $msg, 0 )") or sqlerr(__FILE__, __LINE__);
		stderr("Error", "Invalid type: $type.");
	  }

$sort =htmlspecialchars( $_GET['d']);
	  if (!is_valid_sort($sort))
	  {
		$msg = sqlesc("Invalid sort: $sort. Username: $CURUSER[username]\n");
		$dt = sqlesc(get_date_time());
  		mysql_query("INSERT INTO messages (sender, receiver, added, msg, poster) VALUES(" . $CURUSER["id"] . ", 10, '" . get_date_time() . "' , $msg, 0 )") or sqlerr(__FILE__, __LINE__);
		stderr("Error", "Invalid sort: $sort.");
	  }
$orderby = "ORDER BY $type $sort";

		}
	else
	$orderby = "ORDER BY torrents.id DESC";
	$searcha = explode(" ", $cleansearchstr);
	$sc = 0;
	foreach ($searcha as $searchss) {
		if (strlen($searchss) <= 1)
			continue;
		$sc++;
		if ($sc > 5)
			break;
		$ssa = array();
		foreach (array("search_text", "ori_descr") as $sss)
			$ssa[] = "$sss LIKE '%" . sqlwildcardesc($searchss) . "%'";
		$wherea[] = "(" . implode(" OR ", $ssa) . ")";
	}
	if ($sc) {
		$where = implode(" AND ", $wherea);
		if ($where != "")
			$where = "WHERE $where";
		$res = mysql_query("SELECT COUNT(*) FROM torrents $where");
		$row = mysql_fetch_array($res);
		$count = $row[0];
	}
}

$torrentsperpage = $CURUSER["torrentsperpage"];
if (!$torrentsperpage)
	$torrentsperpage = 15;

if ($count)
{
	list($pagertop, $pagerbottom, $limit) = pager($torrentsperpage, $count, "browse.php?" . $addparam);
if (!$searchstr && $torrentsperpage ==15 && !isset($_GET["page"]) && !isset($_GET["incldead"]) && !isset($_GET["cat"]) && !$addparam)
$file = "$CACHE/browse/type-".$orderby.".txt";
else
$file = false;
$expire = 60; // 60 seconds
if (file_exists($file) && filemtime($file) > (time() - $expire)) {
    $records = unserialize(file_get_contents($file));
} else {

	$query = "SELECT torrents.id, torrents.category, torrents.leechers, torrents.seeders, torrents.name, torrents.times_completed, torrents.size, torrents.added,UNIX_TIMESTAMP(torrents.added) as utadded,torrents.comments,torrents.numfiles,torrents.filename,torrents.owner,IF(torrents.nfo <> '', 1, 0) as nfoav," .
   "IF(torrents.numratings < $minvotes, 0, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, categories.name AS cat_name, categories.image AS cat_pic, users.username," .
   "categories.name AS cat_name, categories.image AS cat_pic, users.username FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id $where $orderby $limit";
	"categories.name AS cat_name, categories.image AS cat_pic, users.username FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id $where $orderby $limit";
$result = mysql_query($query)
        or die (mysql_error());
    while ($record = mysql_fetch_array($result) ) {
        $records[] = $record;
    }
	if (!$searchstr && $torrentsperpage ==15 && !isset($_GET["page"]) && !isset($_GET["incldead"]) && !isset($_GET["cat"]) && !$addparam) {
    	$OUTPUT = serialize($records);
    	$fp = fopen($file,"w");
    	fputs($fp, $OUTPUT);
    	fclose($fp);
	}
} // end else
}
else
	unset($res);
if (isset($cleansearchstr))
	stdhead("Search results for \"$searchstr\"");
else
	stdhead();

?>

<STYLE TYPE="text/css" MEDIA=screen>

  a.catlink:link, a.catlink:visited{
		text-decoration: none;
	}

	a.catlink:hover {
		color: #A83838;
	}

</STYLE>

<!-- /////// some vars for the statusbar;o) //////// -->



<?





$date=gmdate("D, M d Y H:i", time() + $CURUSER['tzoffset'] * 60);
$uped = mksize($CURUSER['uploaded']);

$uped = mksize($CURUSER['uploaded']);

$downed = mksize($CURUSER['downloaded']);

if ($CURUSER["downloaded"] > 0)

{

$ratio = $CURUSER['uploaded'] / $CURUSER['downloaded'];

$ratio = number_format($ratio, 3);

$color = get_ratio_color($ratio);

if ($color)

  $ratio = "<font color=$color>$ratio</font>";

}

else

if ($CURUSER["uploaded"] > 0)

     $ratio = "Inf.";

else

$ratio = "---";



if ($CURUSER['donor'] == "yes")

 $medaldon = "<img src=pic/star.gif alt=donor title=donor>";



if ($CURUSER['warned'] == "yes")

 $warn = "<img src=pic/warned.gif alt=warned title=warned>";



//// check for messages //////////////////

$res = mysql_query("SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND folder_in<>0") or print(mysql_error());
$arr = mysql_fetch_row($res);
$messages = $arr[0];
$res = mysql_query("SELECT COUNT(*) FROM messages WHERE receiver=" . $CURUSER["id"] . " AND folder_in<>0 AND unread='yes'") or print(mysql_error());
$arr = mysql_fetch_row($res);
$unread = $arr[0];
$res = mysql_query("SELECT COUNT(*) FROM messages WHERE sender=" . $CURUSER["id"] . " AND folder_out<>0") or print(mysql_error());
$arr = mysql_fetch_row($res);
$outmessages = $arr[0];

if ($unread)

 $inboxpic = "<img height=14px style=border:none alt=inbox title='inbox (new messages)' src=pic/pn_inboxnew.gif>";

else

 $inboxpic = "<img height=14px style=border:none alt=inbox title='inbox (no new messages)' src=pic/pn_inbox.gif>";

$res3 = mysql_query("SELECT connectable FROM peers WHERE userid=" . sqlesc($CURUSER["id"]) . " LIMIT 1") or print(mysql_error());
if($row = mysql_fetch_row($res3)){
       $connect = $row[0];
       if($connect == "yes"){
         $connectable = "<b><font color=green><a title='Connectable = Yes'>Yes</a></font></b>";
       }else{
         $connectable = "<b><font color=red><a title='Connectable = No'>No</a></font></b>";
       }
}else{
$connectable ="<b><a title='Unknown'>---</a></b>";
}


//// check active torrents ///////////////////////

$res2 = mysql_query("SELECT COUNT(*) FROM peers WHERE userid=" . $CURUSER["id"] . " AND seeder='yes'") or print(mysql_error());

$row = mysql_fetch_row($res2);

$activeseed = $row[0];

$res2 = mysql_query("SELECT COUNT(*) FROM peers WHERE userid=" . $CURUSER["id"] . " AND seeder='no'") or print(mysql_error());

$row = mysql_fetch_row($res2);

$activeleech = $row[0];

//// end
if (get_user_class() >= UC_MODERATOR)
$p="[<a href=staffpanel.php><font color=red>Staffpanel</font></a>]";

?>



<!-- //////// start the statusbar ///////////// -->



<table cellpadding="4" cellspacing="1" border="0" style="width:90%" class="bottom">

  <tr>

<td class="tablea"><table style="width:100%" cellspacing="0" cellpadding="0" border="0">

    <tr>

     <td class="bottom" align="left"><span class="smallfont">Welcome back, <b><a href="userdetails.php?id=<?=$CURUSER['id']?>"><?=$CURUSER['username']?></a></b><?=$medaldon?><?=$warn?>&nbsp; [<a href="logout.php">logout</a>] <?=$p?>&nbsp;Connectable:&nbsp;<?=$connectable?>&nbsp;&nbsp;<br/>

     <font color=1900D1>Ratio:</font> <?=$ratio?>&nbsp;&nbsp;<font color=green>Uploaded:</font> <font color=black><?=$uped?></font>&nbsp;&nbsp;<font color=darkred>Downloaded:</font> <font color=black><?=$downed?></font>&nbsp;&nbsp;<font color=1900D1>Active Torrents:&nbsp;</font></span> <img alt="Torrents seeding" title="Torrents seeding" src="pic/arrowup.gif">&nbsp;<font color=black><span class="smallfont"><?=$activeseed?></span></font>&nbsp;&nbsp;<img alt="Torrents leeching" title="Torrents leeching" src="pic/arrowdown.gif">&nbsp;<font color=black><span class="smallfont"><?=$activeleech?></span></font></td>

     <td class="bottom" align="right"><span class="smallfont">The time is now: <?echo "$date";?><br/>

     <?
       if ($messages){

               print("<span class=smallfont>". '<a href="messages.php?folder='.PM_FOLDERID_INBOX.'">'."$inboxpic</a> $messages ($unread New)</span>");

  if ($outmessages)

     print("<span class=smallfont>&nbsp;&nbsp;". '<a href="messages.php?folder='.PM_FOLDERID_OUTBOX.'">'."<img height=14px style=border:none alt=sentbox title=sentbox src=pic/pn_inbox.gif></a> $outmessages</span>");

  else

     print("<span class=smallfont>&nbsp;&nbsp;". '<a href="messages.php?folder='.PM_FOLDERID_INBOX.'">'."<img height=14px style=border:none alt=sentbox title=sentbox src=pic/pn_inbox.gif></a> 0</span>");

       }

       else

       {

               print("<span class=smallfont>". '<a href="messages.php?folder='.PM_FOLDERID_INBOX.'">'."<img height=14px style=border:none alt=inbox title=inbox src=pic/pn_inbox.gif></a> 0</span>");

  if ($outmessages)

     print("<span class=smallfont>&nbsp;&nbsp;". '<a href="messages.php?folder='.PM_FOLDERID_OUTBOX.'">'."<img height=14px style=border:none alt=sentbox title=sentbox src=pic/pn_inboxnew.gif></a> $outmessages</span>");

  else

     print("<span class=smallfont>&nbsp;&nbsp;". '<a href="messages.php?folder='.PM_FOLDERID_OUTBOX.'">'."<img height=14px style=border:none alt=sentbox title=sentbox src=pic/pn_inboxnew.gif></a> 0</span>");

       }

       print("&nbsp;<a href=friends.php><img style=border:none alt=Buddylist title=Buddylist src=pic/buddylist.gif></a>");

?>
     </span></td>



    </tr>

   </table></table>
<br>

<!-- /////////// here we go, with the cats //////////// -->

<form method="get" action="browse.php">
<table width="60%" class="coltable" cellspacing="1" cellpadding="4" border="1">
<tr>
<table class=bottom>

<tr>

<td class=bottom>

<table class=bottom width="736">

<tr>
<td width=30% align=center><nobr>
Search: <input type="text" name="search" size="30" value="" />
in
<select name="cat">

<option value="0">(all types)</option>
<option value="43">Alternative</option>
<option value="69">Ambiental</option>
<option value="72">Arabic</option>
<option value="73">Blues</option>
<option value="44">Country</option>
<option value="45">Dance</option>
<option value="46">Drum'n'Bass</option>
<option value="47">Electronic</option>
<option value="67">Funny</option>
<option value="70">Hardcore</option>
<option value="48">Hip-Hop</option>
<option value="49">House</option>
<option value="74">Jazz</option>
<option value="71">Latino</option>
<option value="68">Lautareasca</option>
<option value="37">Manele</option>
<option value="64">Media Appz</option>
<option value="50">Metal</option>
<option value="52">Music Vids</option>
<option value="53">OST</option>
<option value="51">Old Music</option>
<option value="54">Other</option>
<option value="55">Pop</option>
<option value="56">Psychedelic</option>
<option value="57">Punk</option>
<option value="65">R'n'B</option>
<option value="59">Rap</option>
<option value="58">Reggae</option>
<option value="60">Rock</option>
<option value="66">Romaneasca</option>
<option value="63">Techno</option>
<option value="62">Trance</option>
</select>
<input type="submit" class="groovybutton2" value="Search!">
</td>

</form>
<form method="get" action="browse.php">
<td width=19% align=center><nobr>Show:
<select name=incldead><option value="0">Active Torrents</option>
<option value="1">Include Dead</option>
<option value="2">Only Dead</option>
</select>
<input type="submit" class="groovybutton2" value="Go!">

</td>
<td width=1% align=center><a href="javascript: klappe_news('browse')"><img border=0 src=/pic/categories.png></a></td>
</tr>
</table>
<div id="kbrowse" style="display: none;"><table width=100% border="0" class=statusbar >
<tr>
<font  class=small><div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 10px">
<input name=c43 type="checkbox" value=1>
<a href=browse.php?cat=43>Alternative</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c69 type="checkbox" value=1>
<a href=browse.php?cat=69>Ambiental</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c72 type="checkbox" value=1>
<a href=browse.php?cat=72>Arabic</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c73 type="checkbox" value=1>
<a href=browse.php?cat=73>Blues</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c44 type="checkbox" value=1>
<a href=browse.php?cat=44>Country</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c45 type="checkbox" value=1>
<a href=browse.php?cat=45>Dance</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c46 type="checkbox" value=1>
<a href=browse.php?cat=46>Drum'n'Bass</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c47 type="checkbox" value=1>
<a href=browse.php?cat=47>Electronic</b></td></a>
</tr><tr><div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c67 type="checkbox" value=1>
<a href=browse.php?cat=67>Funny</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c70 type="checkbox" value=1>
<a href=browse.php?cat=70>Hardcore</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c48 type="checkbox" value=1>
<a href=browse.php?cat=48>Hip-Hop</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c49 type="checkbox" value=1>
<a href=browse.php?cat=49>House</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c74 type="checkbox" value=1>
<a href=browse.php?cat=74>Jazz</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c71 type="checkbox" value=1>
<a href=browse.php?cat=71>Latino</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c68 type="checkbox" value=1>
<a href=browse.php?cat=68>Lautareasca</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c37 type="checkbox" value=1>
<a href=browse.php?cat=37>Manele</b></td></a>
</tr><tr><div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c64 type="checkbox" value=1>
<a href=browse.php?cat=64>Media Appz</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c50 type="checkbox" value=1>
<a href=browse.php?cat=50>Metal</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c52 type="checkbox" value=1>
<a href=browse.php?cat=52>Music Vids</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c53 type="checkbox" value=1>
<a href=browse.php?cat=53>OST</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c51 type="checkbox" value=1>
<a href=browse.php?cat=51>Old Music</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c54 type="checkbox" value=1>
<a href=browse.php?cat=54>Other</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c55 type="checkbox" value=1>
<a href=browse.php?cat=55>Pop</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c56 type="checkbox" value=1>
<a href=browse.php?cat=56>Psychedelic</b></td></a>
</tr><tr><div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c57 type="checkbox" value=1>
<a href=browse.php?cat=57>Punk</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c65 type="checkbox" value=1>
<a href=browse.php?cat=65>R'n'B</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c59 type="checkbox" value=1>
<a href=browse.php?cat=59>Rap</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c58 type="checkbox" value=1>
<a href=browse.php?cat=58>Reggae</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c60 type="checkbox" value=1>
<a href=browse.php?cat=60>Rock</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c66 type="checkbox" value=1>
<a href=browse.php?cat=66>Romaneasca</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c63 type="checkbox" value=1>
<a href=browse.php?cat=63>Techno</b></td></a>
<div align=center><td class="bottom" style="padding-bottom: 2px;padding-left: 7px">
<input name=c62 type="checkbox" value=1>
<a href=browse.php?cat=62>Trance</b></td></a>
</tr>
</table>
</div>
</form>
<script language="javascript" src="suggest.js" type="text/javascript"></script>
<div id="suggcontainer" style="text-align: left; width: 520px; display: none;">
<div id="suggestions" style="cursor: default; position: absolute; background-color: #FFFFFF; border: 1px solid #777777;"></div>
</div>

</td></tr></table>
<?

if (isset($cleansearchstr))
print("<p></p><h3>Search results for \"" . htmlspecialchars($searchstr) . "\"</h3>\n");

if ($count) {
	print($pagertop);

	torrenttable($records, "browse.php?" . $addparam);

	print($pagerbottom);
}
else {
	if (isset($cleansearchstr)) {
		print("<p></p><h3>Nothing found!</h3>\n");
		print("<p>Try again with a refined search string.</p>\n");
	}
	else {
		print("<p></p><h3>Nothing here!</h3>\n");
		print("<p>Sorry pal :(</p>\n");
	}
}
mysql_query("UPDATE users SET last_browse=".gmtime()." where id=".$CURUSER['id']);

stdfoot();



?>