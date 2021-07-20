<?
//////////////// Respect mod by hellix
require_once("include/functions.php");

function bark($msg)
{
   stdhead();
   stdmsg("Error!", $msg);
   echo("</table>");
   stdfoot();
   exit;
}
dbconn();
loggedinorreturn();
parked();
//referer();
$id = (int) $_GET["id"];
if (!is_valid_id($id))
bark("Invalid ID.");
$userid = $CURUSER["id"];
$respect = $id;
$res = mysql_query("SELECT id FROM users WHERE id=".$id."");
if (mysql_num_rows($res) == 0)
bark("id ($id) vrong");
$res = mysql_query("SELECT * FROM respect WHERE respect=$respect && userid=$userid") or sqlerr();
$arr = mysql_fetch_assoc($res);
if ($arr) die("You already voted for this member");
if ($id != $CURUSER["id"])
{
if ($vote == "good")
mysql_query("UPDATE users SET good = good + 1 WHERE id=$id") or sqlerr();
if ($vote == "bad")
mysql_query("UPDATE users SET bad = bad + 1 WHERE  id=$id") or sqlerr();
mysql_query("INSERT INTO respect (userid, respect) VALUES ($userid, $respect)");
if ($vote == "good")
mysql_query("UPDATE respect SET good = good + 1 WHERE respect=$respect") or sqlerr();
if ($vote == "bad")
mysql_query("UPDATE respect SET bad = bad + 1 WHERE respect=$respect") or sqlerr();
  header("Location: $BASEURL/simpaty.php?id=$userid#$frag");
}
else
{
   bark("You cannot vote for yourself!");

}
?>


