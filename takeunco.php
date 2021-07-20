<?
require_once("include/functions.php");
function bark($msg) {
  stdhead();
    stdmsg("Job failed...", $msg);
  stdfoot();
  exit;
}
dbconn();
loggedinorreturn();
if (get_user_class() > UC_MODERATOR) {

if (empty($_POST["delusr"]))
    bark("Don't leave any fields blank.");

$do="DELETE FROM users WHERE id IN (" . implode(", ", $_POST[delusr]) . ") AND status='pending'";
$res=mysql_query($do);
}
header("Refresh: 0; url=/unco.php");
?>