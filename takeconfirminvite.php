<?
require_once("include/functions.php");
$id = (int) $HTTP_GET_VARS["id"];
$md5 = $HTTP_GET_VARS["secret"];
if (!$id)
httperr();
dbconn();
//referer();
$res = mysql_query("SELECT COUNT(*) FROM users") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
if ($arr[0] >= $invites)
	stderr("Error", "Sorry, user limit reached. Please try again later.");
$res = mysql_query("SELECT editsecret, status FROM users WHERE id = $id");
$row = mysql_fetch_array($res);
if (!$row)
	httperr();

if ($row["status"] != "pending") {
	header("Refresh: 0; url=../../ok.php?type=confirmed");
	exit();
}

$sec = hash_pad($row["editsecret"]);
if ($md5 != md5($sec))
	httperr();
$gender =htmlspecialchars( $_POST["gender"]);
$website = unesc($_POST["website"]);
$country = htmlspecialchars($_POST["country"]);
$musicstyle = unesc($_POST["musicstyle"]);
$year = htmlspecialchars($_POST["year"]);
$month = htmlspecialchars($_POST["month"]);
$day = htmlspecialchars($_POST["day"]);
if ($year == '0000')
   bark("Please set your birth year.");
if ($month == '00')
   bark("Please set your birth month.");
if ($day == '00')
   bark("Please set your birth day.");


if (empty($wantusername) || empty($wantpassword) || empty($gender))
	bark("Don't leave any fields blank.");
if (!mkglobal("wantusername:wantpassword:passagain"))
	die();

function bark($msg) {
  stdhead();
	stdmsg("Signup failed!", $msg);
  stdfoot();
  exit;
}

function validusername($username)
{
	if ($username == "")
	  return false;

	// The following characters are allowed in user names
	$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	for ($i = 0; $i < strlen($username); ++$i)
	  if (strpos($allowedchars, $username[$i]) === false)
	    return false;

	return true;
}

function isportopen($port)
{
	global $HTTP_SERVER_VARS;
	$sd = @fsockopen($HTTP_SERVER_VARS["REMOTE_ADDR"], $port, $errno, $errstr, 1);
	if ($sd)
	{
		fclose($sd);
		return true;
	}
	else
		return false;
}


if (strlen($wantusername) > 12)
	bark("Sorry, username is too long (max is 12 chars)");

if ($wantpassword != $passagain)
	bark("The passwords didn't match! Must've typoed. Try again.");

if (strlen($wantpassword) < 6)
	bark("Sorry, password is too short (min is 6 chars)");

if (strlen($wantpassword) > 40)
	bark("Sorry, password is too long (max is 40 chars)");

if ($wantpassword == $wantusername)
	bark("Sorry, password cannot be same as user name.");

if (strlen($website) > 40)
	bark("Sorry, website url is too long (max is 40 chars)");

if (strlen($musicstyle) > 150)
	bark("Sorry, Your Music Style is too long (max is 150 chars)");

if (!validusername($wantusername))
	bark("Invalid username.");

// check if ip addy is already in use
$a = (@mysql_fetch_row(@mysql_query("select count(*) from users where ip='" . $_SERVER['REMOTE_ADDR'] . "'"))) or die(mysql_error());
if ($a[0] != 0)
bark("The ip " . $_SERVER['REMOTE_ADDR'] . " is already in use.");

// make sure user agrees to everything...
if ($HTTP_POST_VARS["rulesverify"] != "yes" || $HTTP_POST_VARS["faqverify"] != "yes" || $HTTP_POST_VARS["ageverify"] != "yes")
	stderr("Signup failed", "Sorry, you're not qualified to become a member of this site.");


$secret = mksecret();
$wantpasshash = md5($secret . $wantpassword . $secret);

$passkey= md5($wantusername.get_date_time().$wantpasshash);


$ret = mysql_query("UPDATE users SET username='$wantusername', gender='$gender', website='$website',country='$country',musicstyle='$musicstyle',year='$year',month='$month',day='$day', invitedate='" . get_date_time() . "', last_check='" . get_date_time() . "', passhash='$wantpasshash', status='confirmed', editsecret='', passkey='$passkey', secret='$secret' WHERE id=$id");

if (!$ret) {
	if (mysql_errno() == 1062)
		bark("Username already exists!");
	bark("$wantpasshash");

}

logincookie($id, $wantpasshash);

header("Refresh: 0; url=../../ok.php?type=confirm");



?>