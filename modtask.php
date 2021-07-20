<?
require "include/functions.php";
dbconn(false);
loggedinorreturn();
parked();
//referer();

function puke($text = "w00t")
{
  stderr("w00t", $text);
}
if (get_user_class() < UC_MODERATOR) stderr("Error", "Permission denied");


$action = $_POST["action"];

if ($action == "edituser")
{
  $userid = htmlspecialchars($_POST["userid"]);
  $title =htmlspecialchars( $_POST["title"]);
  $avatar =htmlspecialchars( $_POST["avatar"]);
  $enabled =htmlspecialchars( $_POST["enabled"]);
  $warned = htmlspecialchars($_POST["warned"]);
  $warnlength = (int) $_POST["warnlength"];
  $warnpm =htmlspecialchars( $_POST["warnpm"]);
  $donor = htmlspecialchars($_POST["donor"]);
  $maxtorrents = htmlspecialchars($_POST["maxtorrents"]);
  $uploaded = htmlspecialchars($_POST["uploaded"]);
  $downloaded = htmlspecialchars($_POST["downloaded"]);
  $invites = htmlspecialchars($_POST["invites"]);
  $donated = htmlspecialchars($_POST["donated"]);
  $modcomment =htmlspecialchars( $_POST["modcomment"]);
  $username = htmlspecialchars($_POST["username"]);
  $email =htmlspecialchars( $_POST["email"]);
  $good = htmlspecialchars($_POST["good"]);
  $bad = htmlspecialchars($_POST["bad"]);
  $country = htmlspecialchars($_POST["country"]);
  $info = htmlspecialchars($_POST["info"]);
  $signature = htmlspecialchars($_POST["signature"]);
  $musicstyle = htmlspecialchars($_POST["musicstyle"]);
  $addbookmark = htmlspecialchars($_POST["addbookmark"]);
  $bookmcomment = htmlspecialchars( $_POST["bookmcomment"]);
  $website = htmlspecialchars( $_POST["website"]);

  $class = (int) $_POST["class"];
  if (!is_valid_id($userid) || !is_valid_user_class($class))
    stderr("Error", "Bad user ID or class ID.");
  // check target user class
  $res = mysql_query("SELECT warned, enabled, username, class, passhash, passkey, oldpasskey FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
  $arr = mysql_fetch_assoc($res) or puke();
  $curenabled = $arr["enabled"];
  $curclass = $arr["class"];
  $curwarned = $arr["warned"];
  // User may not edit someone with same or higher class than himself!
  if ($curclass >= get_user_class())
    puke();

  if ($curclass != $class)
  {
    // Notify user
    $what = ($class > $curclass ? "promoted" : "demoted");
    $msg = "You have been $what to '" . get_user_class_name($class) . "' by $CURUSER[username].";
    sendPersonalMessage(0, $userid, " You have been to '" . get_user_class_name($class) . "' $what", $msg, PM_FOLDERID_SYSTEM, 0);
    $updateset[] = "class = $class";
    $what = ($class > $curclass ? "Promoted" : "Demoted");
 		$modcomment = gmdate("Y-m-d") . " - $what to '" . get_user_class_name($class) . "' by $CURUSER[username].\n". $modcomment;
  }

  // some Helshad fun
  $fun = ($CURUSER['id'] == 277) ? " Tremble in fear, mortal." : "";

  if ($warned && $curwarned != $warned)
  {
		$updateset[] = "warned = " . sqlesc($warned);
		$updateset[] = "warneduntil = '0000-00-00 00:00:00'";
    if ($warned == 'no')
    {
			$modcomment = gmdate("Y-m-d") . " - Warning removed by " . $CURUSER['username'] . ".\n". $modcomment;
      $msg = "Your warning has been removed by " . $CURUSER['username'] . ".";
    }
                sendPersonalMessage(0, $userid, " Your warning removed
 ", $msg, PM_FOLDERID_SYSTEM, 0);
  }
	elseif ($warnlength)
  {
    if ($warnlength == 255)
    {
	$modcomment = gmdate("Y-m-d") . " - Warned by " . $CURUSER['username'] . ".\nReason: $warnpm\n" . $modcomment;
    $msg = "You have received a [url=rules.php#warning]warning[/url] from $CURUSER[username].$fun" . ($warnpm ? "\n\nReason: $warnpm" : "");
	$updateset[] = "warneduntil = '0000-00-00 00:00:00'";
    }
    else
    {
	    $warneduntil = get_date_time(gmtime() + $warnlength * 604800);
	    $dur = $warnlength . " week" . ($warnlength > 1 ? "s" : "");
	    $msg = "You have received a $dur [url=rules.php#warning]warning[/url] from " . $CURUSER['username'] . ".$fun" . ($warnpm ? "\n\nReason: $warnpm" : "");
	    $modcomment = gmdate("Y-m-d") . " - Warned for $dur by " . $CURUSER['username'] .  ".\nReason: $warnpm\n" . $modcomment;
	    $updateset[] = "warneduntil = '$warneduntil'";
		}
 		$added = sqlesc(get_date_time());
   sendPersonalMessage(0, $userid, " You have been warned", $msg . "\n\n If  you'll find this warning unjustified, do you ask a team member!", PM_FOLDERID_SYSTEM, 0);
    $updateset[] = "warned = 'yes'";
	}

  if ($enabled != $curenabled)
  {
  	if ($enabled == 'yes')
  		$modcomment = gmdate("Y-m-d") . " - Enabled by " . $CURUSER['username'] . ".\n" . $modcomment;
  	else
  		$modcomment = gmdate("Y-m-d") . " - Disabled by " . $CURUSER['username'] . ".\n" . $modcomment;
  }

if ($_POST['resetkey'] == 1)
{
$passkey= md5($arr['username'].get_date_time().$arr['passhash']);
$updateset[] = "passkey = " . sqlesc($passkey);
$oldpasskey = "[$arr[passkey]]$arr[oldpasskey]";
if (strlen($oldpasskey)>255)
	bark("You have reset your passkey too many times, ask an Admin for permission");
$updateset[] = "oldpasskey = " . sqlesc($oldpasskey);
}
if ($_POST['deleteoldkey'] == 1)
$updateset[] = "oldpasskey = " . sqlesc('');

 $updateset[] = "enabled = " . sqlesc($enabled);
  $updateset[] = "donor = " . sqlesc($donor);
  $updateset[] = "avatar = " . sqlesc($avatar);
  $updateset[] = "title = " . sqlesc($title);
  $updateset[] = "maxtorrents = ".sqlesc($maxtorrents);
  $updateset[] = "uploaded = ".sqlesc($uploaded);
  $updateset[] = "downloaded= ".sqlesc($downloaded);
  $updateset[] = "invites = ".sqlesc($invites);
  $updateset[] = "donated = ".sqlesc($donated);
  $updateset[] = "modcomment = " . sqlesc($modcomment);
  $updateset[] = "username = " . sqlesc($username);
  $updateset[] = "email = " . sqlesc($email);
  $updateset[] = "good = " . sqlesc($good);
  $updateset[] = "bad = " . sqlesc($bad);
  $updateset[] = "info = " . sqlesc($info);
  $updateset[] = "signature = " . sqlesc($signature);
  $updateset[] = "musicstyle = " . sqlesc($musicstyle);
  $updateset[] = "bookmcomment = " . sqlesc($bookmcomment);
  $updateset[] = "addbookmark = " . sqlesc($addbookmark);
  $updateset[] = "website = " . sqlesc($website);
  if (is_valid_id($country))
  $updateset[] = "country = $country";
  // Support
if ((isset($_POST['support'])) && (($support = $_POST['support']) != $user['support']))
{
if ($support == 'yes')
{
$modcomment = gmdate("Y-m-d") . " - Promoted to FLS by " . $CURUSER['username'] . ".\n" . $modcomment;
}
elseif ($support == 'no')
{
$modcomment = gmdate("Y-m-d") . " - Demoted from FLS by " . $CURUSER['username'] . ".\n" . $modcomment;
}
else
die();

$supportfor = htmlspecialchars($_POST['supportfor']);

$updateset[] = "support = " . sqlesc($support);
$updateset[] = "supportfor = ".sqlesc($supportfor);
}

  mysql_query("UPDATE users SET  " . implode(", ", $updateset) . " WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
  $returnto = $_POST["returnto"];

  header("Location: $BASEURL/$returnto");
  die;
}

puke();

?>