<?
require_once("include/functions.php");
dbconn();
//referer();
$res = mysql_query("SELECT COUNT(*) FROM users") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
if ($arr[0] >= $maxusers)
	stderr("Error", "Sorry, user limit reached. Please try again later.");

if (!mkglobal("wantusername:wantpassword:passagain:email:country"))
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
include('captcha/captchac_lib.php');
	$Turing_code = $_REQUEST["Turing"];
	if ( CheckCaptcha($Turing_code) !=1 )
    {
    	bark("The Captcha Code you entered is invalid. Please press the Back button of your browser and try again.");
	return 1;
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
/*
function isproxy()
{
	$ports = array(80, 88, 1075, 1080, 1180, 1182, 2282, 3128, 3332, 5490, 6588, 7033, 7441, 8000, 8080, 8085, 8090, 8095, 8100, 8105, 8110, 8888, 22788);
	for ($i = 0; $i < count($ports); ++$i)
		if (isportopen($ports[$i])) return true;
	return false;
}
*/
$country = htmlspecialchars(mysql_escape_string($_POST["country"]));
$gender = htmlspecialchars(mysql_escape_string($_POST["gender"]));
$website = htmlspecialchars(mysql_escape_string($_POST["website"]));
if (!preg_match("/^(.*)(http\:\/\/|https\:\/\/|ftp\:\/\/|ftps\:\/\/|www\.|\.([a-z]{2,5}))(.*)+$/i",$website))
bark("Invalid website.");
$musicstyle = htmlspecialchars(mysql_escape_string($_POST["musicstyle"]));
if (!preg_match('~^[A-Za-zР-пр-џ\-!]+$~', $musicstyle))
bark("Invalid musicstyle.");

if (empty($wantusername) || empty($wantpassword) || empty($email) || empty($gender)|| empty($country))
	bark("Don't leave any fields blank.");
$year = htmlspecialchars(mysql_escape_string($_POST["year"]));
$month = htmlspecialchars(mysql_escape_string($_POST["month"]));
$day = htmlspecialchars(mysql_escape_string($_POST["day"]));
if ($year == '0000')
   bark("Please set your birth year.");
if ($month == '00')
   bark("Please set your birth month.");
if ($day == '00')
   bark("Please set your birth day.");



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

if (!validemail($email))
	bark("That doesn't look like a valid email address.");

if (strlen($website) > 40)
	bark("Sorry, website url is too long (max is 40 chars)");

if (strlen($musicstyle) > 150)
	bark("Sorry, Your Music Style is too long (max is 150 chars)");
if (!validusername($wantusername))
	bark("Invalid username.");

// make sure user agrees to everything...
if ($HTTP_POST_VARS["rulesverify"] != "yes" || $HTTP_POST_VARS["faqverify"] != "yes" || $HTTP_POST_VARS["ageverify"] != "yes")
	stderr("Signup failed", "Sorry, you're not qualified to become a member of this site.");

// check if email addy is already in use

$a = (@mysql_fetch_row(@sql_query("SELECT COUNT(*) FROM users WHERE email=".sqlesc($email)))) or die(mysql_error());
if ($a[0] != 0)
  bark("The e-mail address $email is already in use.");

/*
$a = (@mysql_fetch_row(@mysql_query("select count(*) from users where ip='" . $_SERVER['REMOTE_ADDR'] . "'"))) or die(mysql_error());
if ($a[0] != 0)
 bark("The ip " . $_SERVER['REMOTE_ADDR'] . " is already in use.");
*/
/*
// do simple proxy check
if (isproxy())
	bark("You appear to be connecting through a proxy server. Your organization or ISP may use a transparent caching HTTP proxy. Please try and access the site on <a href=http://torrentbits.org:81/signup.php>port 81</a> (this should bypass the proxy server). <p><b>Note:</b> if you run an Internet-accessible web server on the local machine you need to shut it down until the sign-up is complete.");
*/


$secret = mksecret();
$wantpasshash = md5($secret . $wantpassword . $secret);
$editsecret = mksecret();
$passkey= md5($wantusername.get_date_time().$wantpasshash);


$ret = mysql_query("INSERT INTO users (username, passhash, secret, editsecret, email, gender, website, passkey, status,musicstyle,country,year,month,day, added, invitedate, last_check) VALUES (" .
        implode(",", array_map("sqlesc", array($wantusername, $wantpasshash, $secret, $editsecret, $email, $gender, $website, $passkey, 'confirmed',$musicstyle,$country,$year,$month,$day))) .
        ",'" . get_date_time() . "','" . get_date_time() . "','" . get_date_time() . "')");

if (!$ret) {
	if (mysql_errno() == 1062)
		bark("Username already exists!");
	bark("borked");
}

$id = mysql_insert_id();

write_log("User account $id ($wantusername) was created");

$psecret = md5($editsecret);
header("Refresh: 0; url=ok.php?type=confirm");


?>