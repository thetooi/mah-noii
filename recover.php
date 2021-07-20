<?
require "include/functions.php";
dbconn();
//remade by putyn @tbdev
function bark($msg)
{
  stdhead();
  stdmsg("Err", $msg);
  stdfoot();
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
 $action = (isset($_POST["action"]) ? $_POST["action"] : "");

 if ($action == "send") {
  $email = htmlentities($_POST["email"]);
  if (!$email)
    bark("You must enter an email address");
  if (!validemail($email))
	bark("That doesn't look like a valid email address.");


  $res = mysql_query("SELECT id,email,passhash FROM users WHERE email=" . sqlesc($email) . " LIMIT 1") or sqlerr();
  $arr = mysql_fetch_assoc($res);
  if (!$arr)
    bark("Error, The email address was not found in the database.\n");

	$sec = mksecret();

  mysql_query("UPDATE users SET editsecret=" . sqlesc($sec) . " WHERE id=" .sqlesc($arr["id"])) or sqlerr();
  if (!mysql_affected_rows())
	  bark("Database error. Please contact an administrator about this.");

  $hash = md5($sec . $email . $arr["passhash"] . $sec);

  $subject = "$SITENAME password reset confirmation";

  $body = <<<EOD
Someone, hopefully you, requested that the password for the account
associated with this email address ($email) be reset.

The request originated from {$_SERVER["REMOTE_ADDR"]}.

If you did not do this ignore this email. Please do not reply.


Should you wish to confirm this request, please follow this link:

$DEFAULTBASEURL/recover.php?id={$arr["id"]}&secret=$hash


If you want after you do this , your password will be reset and emailed back
to you.

--
$SITENAME
EOD;

$headers = 'From: no-reply@' . $SITENAME. "\r\n" .
'Reply-To:' . $SITEEMAIL . "\r\n" .
'X-Mailer: PHP/' . phpversion();

$mail= @mail($arr["email"], $subject, $body, $headers);

    if(!$email)
	stderr("Error", "Unable to send mail. Please contact an administrator about this error.");
	else
    stderr("Success", "A confirmation email has been mailed.\n Please allow a few minutes for the mail to arrive.<b>Remember to look in your junk/spam folder!</b>");
}
if ($action == "change")
{

	$id = (isset($_POST["id"])? 0 + $_POST["id"] : "");

	$mailback = ((isset($_POST["mailback"]) && ($_POST["mailback"] == "yes")) ? "yes" : "no" );

	$newpass = isset($_POST["newpass"]) ? $_POST["newpass"] : "" ;

	$confirmnewpass = isset($_POST["confirmnewpass"]) ? $_POST["confirmnewpass"] : "" ;

	if ($newpass != $confirmnewpass)
     bark("The passwords didn't match! Must've typoed. Try again.");

	if (strlen($newpass) < 6)
	  bark("Sorry, password is too short (min is 6 chars)");

	if (strlen($newpass) > 40)
	  bark("Sorry, password is too long (max is 40 chars)");

	$res = mysql_query("SELECT username,editsecret,email FROM users WHERE id =".sqlesc($id)."");
	$arr = mysql_fetch_array($res);

	  $sec = mksecret();

	  $newpasshash = md5($sec . $newpass . $sec);

	  mysql_query("UPDATE users SET secret=" . sqlesc($sec) . ", editsecret='', passhash=" . sqlesc($newpasshash) . " WHERE id=".sqlesc($id)." AND editsecret=" . sqlesc($arr["editsecret"]));

  if ($mailback == "yes") {
  $body = <<<EOD
	Dear {$arr["username"]},

	Your new {$SITENAME} password is:

    Password:  $newpass

	You may login at $DEFAULTBASEURL/login.php

	--
	{$SITENAME}
EOD;


  $subject = "$SITENAME account details";

  $headers = 'From: no-reply@'.$SITENAME."\r\n" .
             'Reply-To:' . $SITEMAIL . "\r\n" .
             'X-Mailer: PHP/' . phpversion();

  $mail= @mail($arr["email"], $subject, $body, $headers);
  if ($mail)
  $msg = "The account details was sent to the specified adress";
  else
  $msg = "Unable to send mail but your password was changed";
  }

  if (!mysql_affected_rows())
		stderr("Error", "Unable to update user data. Please contact an administrator about this error.");
  else
		stderr("Succes","Your password has been updated.".$msg."");



}
}
elseif($_GET)
{

  $id = isset($_GET["id"]) ? 0 + $_GET["id"] : "" ;
  $md5 = isset($_GET["secret"]) ? $_GET["secret"] : "";


	$res = mysql_query("SELECT username, email, passhash, editsecret FROM users WHERE id = ".sqlesc($id)."");
	$arr = mysql_fetch_array($res);

	$email = $arr["email"];
	$sec = hash_pad($arr["editsecret"]);
	if (preg_match('/^ *$/s', $sec))
	  bark("Something wierd happened !(Err1)");
	if ($md5 != md5($sec . $email . $arr["passhash"] . $sec))
	  bark("Something wierd happened !(Err2)");

	stdhead();
	print("<form method=post action=recover.php>");
	print("<table border=1 cellspacing=0 cellpadding=10>");
	print("<tr><td class=\"rowhead\">New password</td><td><input type=\"password\" size=40 name=\"newpass\"></td></tr>");
	print("<tr><td class=\"rowhead\">Confirm password</td><td><input type=\"password\" size=40 name=\"confirmnewpass\"></td></tr>");
	print("<tr><td class=\"rowhead\">Email back?</td><td><input type=\"checkbox\" name=\"mailback\" value=\"yes\" /><font class=\"small\">Mark this if you want your new password mailed back to you</font></td></tr>");
	print("<tr><td colspan=2 align=center><input type=submit value='Change it!' class=btn /><input type=\"hidden\" name=\"action\" value=\"change\" /><input type=\"hidden\" name=\"id\" value=\"".$id."\" /></td></tr>");
	print("</table>");
	stdfoot();


}
else
{
 	stdhead();

	print("<form method=post action=recover.php>");
	print("<table border=1 cellspacing=0 cellpadding=10>");
	print("<tr><td class=rowhead>Registered email</td>");
	print("<td><input type=text size=40 name=email></td></tr>");
	print("<tr><td colspan=2 align=center><input type=submit value='Do it!' class=groovybutton /><input type=\"hidden\" name=\"action\" value=\"send\" /></td></tr>");
	print("</table>");

	end_frame();
	stdfoot();
}

?>
