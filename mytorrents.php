<?
ob_start("ob_gzhandler");
require_once("include/functions.php");
dbconn(false);
loggedinorreturn();
parked();
//referer();
stdhead("".safechar($CURUSER["username"])."'s Completed torrent's ");

if(isset($_GET["sort"]))
{
  $order = htmlspecialchars($_GET['sort']);
  $scending =htmlspecialchars( $_GET['d']);
  $orderby = "ORDER BY $order $scending";
}
else
$orderby = "ORDER BY torrents.id DESC";
$addparam = "";
$where = "WHERE owner = " . $CURUSER["id"] . " AND banned != 'yes'";
$res = mysql_query("SELECT COUNT(*) FROM torrents $where");
$row = mysql_fetch_array($res);
$count = $row[0];

if (!$count) {
?>
<h1>No torrents</h1>
<p>You haven't uploaded any torrents yet, so there's nothing in this page.</p>
<?
}
else {
	list($pagertop, $pagerbottom, $limit) = pager(20, $count, "mytorrents.php?" . $addparam);

	$query = "SELECT torrents.id, torrents.category, torrents.leechers, torrents.seeders, torrents.name, torrents.visible, torrents.times_completed, torrents.size, torrents.added, torrents.comments,torrents.numfiles,torrents.filename,torrents.owner,IF(torrents.nfo <> '', 1, 0) as nfoav," .
   "IF(torrents.numratings < $minvotes, NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, categories.name AS cat_name, categories.image AS cat_pic, users.username," .
   "categories.name AS cat_name, categories.image AS cat_pic, users.username FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id $where $orderby $limit";
	"categories.name AS cat_name, categories.image AS cat_pic, categ AS cat_stylesheet, users.username FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id $where $orderby $limit";
	$res = mysql_query($query) or die(mysql_error());
while ($record = mysql_fetch_array($res) ) {
        $records[] = $record;
    }
	print($pagertop);

	torrenttable($records, "mytorrents.php?" . $addparam);

	print($pagerbottom);
}

stdfoot();



?>