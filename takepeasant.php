<?
require_once("include/functions.php");
function bark($msg) {
	genbark($msg, "Job failed!");
}
dbconn();
loggedinorreturn();
if (get_user_class() > UC_MODERATOR) {

if (empty($_POST["delusr"]))
    bark("Don't leave any fields blank.");

$do="DELETE FROM users WHERE id IN (" . implode(", ", $_POST[delusr]) . ") AND class='0'";
$res=mysql_query($do);
}
header("Refresh: 0; url=/peasant.php");
?>