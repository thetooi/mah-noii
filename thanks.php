<?
require_once("include/functions.php");
dbconn();

loggedinorreturn();
parked();

$userid = $CURUSER["id"];
$torrentid = (int) $_POST["torrentid"];

if (empty($torrentid)) {
stdmsg("Have A Nice Day Shithead!", $msg);
}

$ajax = $_POST["ajax"];
if ($ajax == "yes") {
	sql_query("INSERT INTO thanks (torrentid, userid) VALUES ($torrentid, $userid)") or sqlerr(__FILE__,__LINE__);
	$count_sql = sql_query("SELECT COUNT(*) FROM thanks WHERE torrentid = $torrentid");
	$count_row = mysql_fetch_array($count_sql);
	$count = $count_row[0];

	if ($count == 0) {
		$thanksby = " None yet";
	} else {
		$thanked_sql = sql_query("SELECT thanks.userid, users.username, users.class FROM thanks INNER JOIN users ON thanks.userid = users.id WHERE thanks.torrentid = $torrentid");
		while ($thanked_row = mysql_fetch_assoc($thanked_sql)) {
			if (($thanked_row["userid"] == $CURUSER["id"]) || ($thanked_row["userid"] == $row["owner"]))
			$can_not_thanks = true;
			//list($userid, $username) = $thanked_row;
			$userid = $thanked_row["userid"];
			$username = $thanked_row["username"];
			$class = $thanked_row["class"];
			$thanksby .= "<a href=\"userdetails.php?id=$userid\">".get_user_class_color2($class, $username)."</a>, ";
		}
		if ($thanksby)
			$thanksby = substr($thanksby, 0, -2);
	}
	$thanksby = "<div id=\"ajax\"><form action=\"thanks.php\" method=\"post\">
	<input type=\"submit\" name=\"submit\" onclick=\"send(); return false;\" value=\"".Thanks."\"".($can_not_thanks ? " disabled" : "").">
	<input type=\"hidden\" name=\"torrentid\" value=\"$torrentid\">".$thanksby."
	</form></div>";
	print $thanksby;
} else {
	$res = sql_query("INSERT INTO thanks (torrentid, userid) VALUES ($torrentid, $userid)") or sqlerr(__FILE__,__LINE__);
	header("Location: $DEFAULTBASEURL/details.php?id=$torrentid&thanks=1");
}
?>