<?php
require ("include/functions.php");
require_once("include/pprotect.php");
dbconn();
loggedinorreturn();
//referer();
if (get_user_class() < UC_MODERATOR) stderr("Error", "Permission denied");

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

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
if ($_POST["username"] == "" || $_POST["password"] == "" || $_POST["email"] == "" || $_POST["class"] == "" || $_POST["modcomment"] == "")
stderr("Error", "Missing form data.");
if (!validusername($_POST["username"]))
stderr("Error", "Invalid username.");
if ($_POST["password"] != $_POST["password2"])
stderr("Error", "Passwords mismatch.");
if (!validemail($_POST['email']))
stderr("Error", "Not valid email");

$class = (int)$_POST["class"];
$country = (int)$_POST["country"];
$modcomment = htmlspecialchars($_POST["modcomment"]);
$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);
////// email stuff \\\\\\\\
$email = htmlspecialchars($_POST["email"]);
//check_banned_emails($email);
// check if email addy is already in use
$res = mysql_query("SELECT COUNT(*) FROM users WHERE email='$email'") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
if ($arr[0] != 0)
stderr("Error", "The e-mail address is already in use.");
////// finish email stuff \\\\\\\\
$secret = mksecret();
$passhash = md5($secret . $password . $secret);
$passkey = md5($username.get_date_time().$passhash);

mysql_query("INSERT INTO users (email, secret, username, passhash, passkey, class, country, modcomment, status, added, last_access) VALUES(".implode(",", array_map("sqlesc", array($email, $secret, $username, $passhash, $passkey, $class, $country, $modcomment, 'confirmed'))).",NOW(),NOW())");
$res = mysql_query("SELECT id FROM users WHERE username=".sqlesc($username)."");
$arr = mysql_fetch_row($res);
if (!$arr)
stderr("Error", "Unable to create the account. The user name is possibly already taken.");
$id = 0+$arr["0"];
$msg = "Dear $username

:wave:

Welcome to $SITENAME!

Be sure to read the rules and FAQ before you start using the site.

We are a community based Tracker, and we hope that you will get involved in our forums, not just the torrents.

so, enjoy

cheers,

The $SITENAME Staff";
sendPersonalMessage(0, $id, "We congratulate!", $msg, PM_FOLDERID_SYSTEM, 0);
write_log("User account $id ($username) just added by $CURUSER[username]");

header("Location: $BASEURL/userdetails.php?id=$id");
die;
}
stdhead("Add user");
?>
<h1>Add user</h1>
<form method=post action=adduser.php>
<table border=1 cellspacing=0 cellpadding=5>
<tr><td class=rowhead>User name</td><td><input type=text name=username size=40></td></tr>
<tr><td class=rowhead>Password</td><td><input type=password name=password size=40></td></tr>
<tr><td class=rowhead>Re-type password</td><td><input type=password name=password2 size=40></td></tr>
<tr><td class=rowhead>E-mail</td><td><input type=text name=email size=40></td></tr>
<?php
//////////added country by putyn
$countries = "<option value=0>Select one</option>\n";
$ct_r = mysql_query("SELECT id,name FROM countries ORDER BY name") or die;
while ($ct_a = mysql_fetch_array($ct_r))
  $countries .= "<option value=$ct_a[id]>$ct_a[name]</option>\n";
print("<tr><td class=rowhead>Country</td><td  colspan=2 align=\"left\"><select name=country>\n$countries\n</select></td></tr>\n");
print("<tr><td class=rowhead>Class</td><td colspan=2 align=left><select name=class>\n");
$maxclass = get_user_class() - 1;
for ($i = 0; $i <= $maxclass; ++$i)
print("<option value=$i>".get_user_class_name($i)."\n");
print("</select></td></tr>\n");
?>
<tr><td class=rowhead>Comment</td><td><input type=text size=60 name=modcomment value="Added By <?php echo $CURUSER['username'];?>" READONLY></td></tr>
<tr><td colspan=2 align=center><input type=submit class="groovybutton" value="Okay" class=btn></td></tr>
</table>
</form>
<?php stdfoot(); ?>