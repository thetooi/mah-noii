<?
require_once("include/functions.php");
function bark($msg) {
	genbark($msg, "Update failed!");
}
dbconn();
loggedinorreturn();
//referer();
if (!mkglobal("email:chpassword:passagain"))
	bark("missing form data");
$updateset = array();
$changedemail = 0;
if ($chpassword != "") {
	if (strlen($chpassword) > 40)
		bark("Sorry, password is too long (max is 40 chars)");
	if ($chpassword != $passagain)
		bark("The passwords didn't match. Try again.");
	$sec = mksecret();
  $passhash = md5($sec . $chpassword . $sec);

	$updateset[] = "secret = " . sqlesc($sec);
	$updateset[] = "passhash = " . sqlesc($passhash);
	logincookie($CURUSER["id"], $passhash);
}

if ($email != $CURUSER["email"]) {
	if (!validemail($email))
		bark("That doesn't look like a valid email address.");
  $r = mysql_query("SELECT id FROM users WHERE email=" . sqlesc($email)) or sqlerr();
	if (mysql_num_rows($r) > 0)
		bark("The e-mail address $email is already in use.");
	$changedemail = 1;
}
$showfriends = htmlspecialchars($_POST["showfriends"] != "" ? "yes" : "no");
$updateset[] = "showfriends = '$showfriends'";
$hideprofile = htmlspecialchars($_POST["hideprofile"] != "" ? "yes" : "no");
$updateset[] = "hideprofile = '$hideprofile'";
$parked = htmlspecialchars(mysql_escape_string($_POST["parked"]));
$acceptpms =htmlspecialchars(mysql_escape_string( $_POST["acceptpms"]));
$logintype =htmlspecialchars(mysql_escape_string( $_POST["logintype"]));
$updateset[] = "logintype = " . sqlesc($logintype);
$deletepms = htmlspecialchars($_POST["deletepms"] != "" ? "yes" : "no");
$savepms = htmlspecialchars($_POST["savepms"] != "" ? "yes" : "no");
$pmnotif = htmlspecialchars(mysql_escape_string($_POST["pmnotif"]));
$emailnotif = htmlspecialchars(mysql_escape_string($_POST["emailnotif"]));
$notifs = ($pmnotif == 'yes' ? "[pm]" : "");
$notifs .= ($emailnotif == 'yes' ? "[email]" : "");
$r = mysql_query("SELECT id FROM categories") or sqlerr();
$rows = mysql_num_rows($r);
for ($i = 0; $i < $rows; ++$i)
{
	$a = mysql_fetch_assoc($r);
	if ($HTTP_POST_VARS["cat$a[id]"] == 'yes')
	  $notifs .= "[cat$a[id]]";
}
if(isset($_POST["avatar"]) && (($avatar = $_POST["avatar"]) != $CURUSER["avatar"])) {
if(!preg_match("/^http:\/\/[^\s'\"<>?;&]+[^.]+\/+[a-z]+\.(jpg|gif|png)$/i", $avatar))
bark("invalid avatar.");
$updateset[] = "avatar = " . sqlesc($avatar);
}
$avatars = htmlspecialchars($_POST["avatars"] != "" ? "yes" : "no");
$showemail = htmlspecialchars(mysql_escape_string($_POST["showemail"]));
$showwebsite = htmlspecialchars(mysql_escape_string($_POST["showwebsite"]));
$showsig = ($_POST["showsig"] != "" ? "yes" : "no");
$signature =htmlspecialchars(mysql_escape_string( $_POST["signature"]));
if (strlen($signatureinfo) > 100)
	bark("Sorry, signature is too long (max is 100 chars)");
$info = htmlspecialchars(mysql_escape_string($_POST["info"]));
if (strlen($info) > 400)
	bark("Sorry, info is too long (max is 400 chars)");
$musicstyle = htmlspecialchars(mysql_escape_string($_POST["musicstyle"]));
if (!preg_match('~^[A-Za-zР-пр-џ\-!]+$~', $musicstyle))
bark("Invalid musicstyle.");
if (strlen($musicstyle) > 200)
bark("Sorry, musicstyle is too long (max is 200 chars)");
$stylesheet = htmlspecialchars(mysql_escape_string($_POST["stylesheet"]));
$country = htmlspecialchars(mysql_escape_string($_POST["country"]));
$tzoffset = htmlspecialchars(mysql_escape_string($_POST["tzoffset"]));
$timezone = htmlspecialchars(mysql_escape_string($_POST["timezone"]));
$gender = htmlspecialchars(mysql_escape_string($_POST["gender"]));
$updateset[] = "gender =  " . sqlesc($gender);
$website =  htmlspecialchars(mysql_escape_string($_POST["website"]));
if (!preg_match("/^(.*)(http\:\/\/|https\:\/\/|ftp\:\/\/|ftps\:\/\/|www\.|\.([a-z]{2,5}))(.*)+$/i",$website))
bark("Invalid website.");
if (strlen($website) > 40)
	bark("Sorry, website url is too long (max is 40 chars)");
$updateset[] = "website = " . sqlesc($website);
if ($_POST['resetpasskey'] == 1)
{
  $res = mysql_query("SELECT username, passhash, oldpasskey, passkey FROM users WHERE id=$CURUSER[id]") or sqlerr(__FILE__, __LINE__);
  $arr = mysql_fetch_assoc($res) or puke();
$oldpasskey = "[$arr[passkey]]$arr[oldpasskey]";
if (strlen($oldpasskey)>255)
	bark("You have reset your passkey too many times, ask an admin for permission");
$updateset[] = "oldpasskey = " . sqlesc($oldpasskey);
 $passkey= md5($arr['username'].get_date_time().$arr['passhash']);
$updateset[] = "passkey = " . sqlesc($passkey);
}

$updateset[] = "torrentsperpage = " . min(100, 0 + $_POST["torrentsperpage"]);
$updateset[] = "topicsperpage = " . min(100, 0 + $_POST["topicsperpage"]);
$updateset[] = "postsperpage = " . min(100, 0 + $_POST["postsperpage"]);
if ($_POST['resetkey'] == 1)
{
 $passkey= md5($arr['username'].get_date_time().$arr['passhash']);
$updateset[] = "passkey = " . sqlesc($passkey);
}
if (is_valid_id($stylesheet))
  $updateset[] = "stylesheet = '$stylesheet'";
if (is_valid_id($country))
  $updateset[] = "country = $country";
if (is_valid_id($timezone))
  $updateset[] = "timezone = $timezone";
$updateset[] = "tzoffset = " . sqlesc($tzoffset);
$updateset[] = "info = " . sqlesc($info);
$updateset[] = "signature = " . sqlesc($signature);
$updateset[] = "parked = " . sqlesc($parked);
$updateset[] = "acceptpms = " . sqlesc($acceptpms);
$updateset[] = "deletepms = '$deletepms'";
$updateset[] = "savepms = '$savepms'";
$updateset[] = "notifs = '$notifs'";
$updateset[] = "avatars = '$avatars'";
$updateset[] = "showsig = " . sqlesc($showsig);
$updateset[] = "showemail = " . sqlesc($showemail);
$updateset[] = "showwebsite = " . sqlesc($showwebsite);
$updateset[] = "musicstyle = " . sqlesc($musicstyle);
/* ****** */

$urladd = "";

if ($changedemail) {
	$sec = mksecret();
	$hash = md5($sec . $email . $sec);
	$obemail = urlencode($email);
	$updateset[] = "editsecret = " . sqlesc($sec);
	$thishost = $_SERVER["HTTP_HOST"];
	$thisdomain = preg_replace('/^www\./is', "", $thishost);
	$body = <<<EOD
You have requested that your user profile (username {$CURUSER["username"]})
on $thisdomain should be updated with this email address ($email) as
user contact.

If you did not do this, please ignore this email. The person who entered your
email address had the IP address {$_SERVER["REMOTE_ADDR"]}. Please do not reply.

To complete the update of your user profile, please follow this link:

http://$thishost/confirmemail.php/{$CURUSER["id"]}/$hash/$obemail

Your new email address will appear in your profile after you do this. Otherwise
your profile will remain unchanged.
EOD;

	mail($email, "$thisdomain profile change confirmation", $body, "From: $SITEEMAIL", "-f$SITEEMAIL");

	$urladd .= "&mailsent=1";

}

mysql_query("UPDATE users SET " . implode(",", $updateset) . " WHERE id = " . $CURUSER["id"]) or sqlerr(__FILE__,__LINE__);

header("Location: $BASEURL/my.php?edited=1" . $urladd);



?>