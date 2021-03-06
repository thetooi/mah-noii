<?php
/*
+------------------------------------------------
|   BitTorrent Tracker PHP
|   =============================================
|   by xblade
|   (c) 2017 - 2018
|   =============================================
|   Licence Info: GPL
+------------------------------------------------
*/
require_once "include/bittorrent.php";
require_once "include/user_functions.php";
require_once "include/html_functions.php";
require_once "include/password_functions.php";
dbconn();
loggedinorreturn();
    $HTMLOUT ='';
    $sure ='';
    $lang = array_merge( load_language('global'), load_language('invite_code') );
    $do = (isset($_GET["do"]) ? $_GET["do"] : (isset($_POST["do"]) ? $_POST["do"] : ''));
    $valid_actions = array('create_invite', 'delete_invite', 'confirm_account', 'view_page', 'send_email');
    $do = (($do && in_array($do,$valid_actions,true)) ? $do : '') or header("Location: ?do=view_page");
if ($do == 'view_page') {
    $query = mysqli_query($GLOBALS["___mysqli_ston"], 'SELECT * FROM users WHERE invitedby = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $rows = mysqli_num_rows($query);
    $HTMLOUT ='';
    $HTMLOUT .= "<table align='center' border='0' cellpadding='6' cellspacing='1' width='98%'>
    <tr>
    <td class='colhead' colspan='7' class='colhead'><b>{$lang['invites_users']}</b></td></tr>";
if(!$rows){
    $HTMLOUT .= "<tr>
    <td colspan='7' class='colhead'>{$lang['invites_nousers']}</td></tr>";
    } else {
    $HTMLOUT .= "<tr>
    <td align='center'><b>{$lang['invites_username']}</b></td>
    <td align='center'><b>{$lang['invites_uploaded']}</b></td>
    <td align='center'><b>{$lang['invites_downloaded']}</b></td>
    <td align='center'><b>{$lang['invites_ratio']}</b></td>
    <td align='center'><b>{$lang['invites_status']}</b></td>
    <td align='center'><b>{$lang['invites_confirm']}</b></td></tr>";
    for ($i = 0; $i < $rows; ++$i) {
    $arr = mysqli_fetch_assoc($query);
if ($arr['status'] == 'pending')
    $user = "<td align='center'>" . htmlspecialchars($arr['username']) . "</td>";
    else
    $user = "<td align='center'>
    <a href='{$FMED['baseurl']}/userdetails.php?id=$arr[id]'>" . htmlspecialchars($arr['username']) . "</a>
    " .($arr["warned"] == "yes" ? "
    &nbsp;
    <img src='{$FMED['pic_base_url']}/userimages/warned.gif' border='0' alt='Warned' />" : "")."
    &nbsp;
    " .($arr["enabled"] == "no" ? "
    &nbsp;
    <img src='{$FMED['pic_base_url']}/userimages/disabled.gif' border='0' alt='Disabled' />" : "")."
    &nbsp;
    " .($arr["donor"] == "yes" ? "<img src='{$FMED['pic_base_url']}/userimages/star.gif' border='0' alt='Donor' />" : "")."</td>";
if ($arr['downloaded'] > 0) {
    $ratio = number_format($arr['uploaded'] / $arr['downloaded'], 3);
    $ratio = "<font color='" . get_ratio_color($ratio) . "'>".$ratio."</font>";
    } else {
if ($arr['uploaded'] > 0) {
    $ratio = 'Inf.';
    }else {
    $ratio = '---';
    }
}
if ($arr["status"] == 'confirmed')
    $status = "<font color='#1f7309'>{$lang['invites_confirm1']}</font>";
    else
    $status = "<font color='#ca0226'>{$lang['invites_pend']}</font>";
    $HTMLOUT .= "<tr class='tableb'>
    ".$user."
    <td align='center'>" . mksize($arr['uploaded']) . "</td>
    <td align='center'>" . mksize($arr['downloaded']) . "</td>
    <td align='center'>".$ratio."</td>
    <td align='center'>".$status."</td>";
if ($arr['status'] == 'pending') {
    $HTMLOUT .= "<td align='center'>
    <a href='?do=confirm_account&amp;userid=".$arr['id']."&amp;sender=".$CURUSER['id']."'>
    <img src='{$FMED['pic_base_url']}/userimages/user_green.png' alt='confirm' title='Confirm' border='0' /></a></td></tr>";
    } else
    $HTMLOUT .= "<td align='center'>---</td></tr>";
    }
}
    $HTMLOUT .= "</table><br />";
    $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM invite_codes WHERE sender = ".$CURUSER['id']." AND status = 'Pending'") or sqlerr();
    $num_row = mysqli_num_rows($select);
    $HTMLOUT .= "<table align='center' border='0' cellpadding='6' cellspacing='1' width='98%'>
    "."
    <tr><td colspan='6' class='colhead'><b>{$lang['invites_codes']}</b></td></tr>";
if (!$num_row) {
    $HTMLOUT.= "<tr><td colspan='1'>{$lang['invites_nocodes']}</td></tr>";
    } else {
    $HTMLOUT .= "<tr><td><b>{$lang['invites_send_code']}</b></td>
    <td><b>{$lang['invites_date']}</b></td>
    <td><b>{$lang['invites_delete']}</b></td>
    <td><b>{$lang['invites_status']}</b></td></tr>";
    for ($i = 0; $i < $num_row; ++$i){
    $fetch_assoc = mysqli_fetch_assoc($select);
    $HTMLOUT .= "<tr>
    <td>".$fetch_assoc['code']." <a href='?do=send_email&amp;id=".(int)$fetch_assoc['id']."'>
    Click Here Email</a></td>
    <td>" . get_date($fetch_assoc['invite_added'], '', 0,1)."</td>";
    $HTMLOUT .= "<td><a href='?do=delete_invite&amp;id=".$fetch_assoc['id']."&amp;sender=".$CURUSER['id']."'>
    <img src='{$FMED['pic_base_url']}del.png' border='0' alt='Delete'/></a></td>
    <td>".$fetch_assoc['status']."</td></tr>";
    }
}
    $HTMLOUT .= "<tr>
    <td colspan='6' align='center'>
    <form action='?do=create_invite' method='post'>
    <input type='submit' value='{$lang['invites_create']}' style='height: 20px' /></form></td></tr>";
    $HTMLOUT .= "</table>";
    print stdhead('Invites') . $HTMLOUT . stdfoot();
    die;
    }elseif ($do =='create_invite') {
if ($CURUSER['invites'] <= 0)
    stderr($lang['invites_error'], $lang['invites_noinvite']);
if ($CURUSER["invite_rights"] == 'no')
    stderr($lang['invites_deny'], $lang['invites_disabled']);
    $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) FROM users") or sqlerr(__FILE__, __LINE__);
    $arr = mysqli_fetch_row($res);
if ($arr[0] >= $FMED['invites'])
    stderr($lang['invites_error'], $lang['invites_limit']);
    $invite = md5(mksecret());
    mysqli_query($GLOBALS["___mysqli_ston"], 'INSERT INTO invite_codes (sender, invite_added, code) VALUES ( ' . sqlesc((int)$CURUSER['id']) . ', ' . sqlesc(time()) . ', ' . sqlesc($invite) . ' )') or sqlerr(__FILE__, __LINE__);
    mysqli_query($GLOBALS["___mysqli_ston"], 'UPDATE users SET invites = invites - 1 WHERE id = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    header("Location: ?do=view_page");
    }elseif ($do =='send_email') {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = (isset($_POST['email'])? htmlentities($_POST['email']) : '');
    $invite = (isset($_POST['code'])? $_POST['code'] : '');
if (!$email) stderr($lang['invites_error'], $lang['invites_noemail']);
    $check = (mysqli_fetch_row(mysqli_query($GLOBALS["___mysqli_ston"], 'SELECT COUNT(*) FROM users WHERE email = ' . sqlesc($email)))) or sqlerr(__FILE__, __LINE__);
if ($check[0] != 0) stderr('Error', 'This email address is already in use!');
if (!validemail($email)) stderr($lang['invites_error'], $lang['invites_invalidemail']);
    $inviter = htmlspecialchars($CURUSER['username']);
$body = <<<EOD
You have been invited to {$FMED['site_name']} by $inviter. They have
specified this address ($email) as your email. If you do not know this person, please ignore this email. Please do not reply.

This is a private site and you must agree to the rules before you can enter:


------------------------------------------------------------

To confirm your invitation, you have to follow this link and type the invite code:

{$FMED['baseurl']}/invite_signup.php

Invite Code: $invite

------------------------------------------------------------

After you do this, your inviter need's to confirm your account.
We urge you to read the RULES and FAQ before you start using {$FMED['site_name']}.
EOD;
    $sendit = mail($email, "You have been invited to {$FMED['site_name']}", $body, "From: {$FMED['site_email']}", "-f{$FMED['site_email']}");
if (!$sendit) stderr($lang['invites_error'], $lang['invites_unable']);
    else stderr('', $lang['invites_confirmation']); }
    $id = (isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : ''));
if (!is_valid_id($id)) stderr($lang['invites_error'], $lang['invites_invalid']);
    $query = mysqli_query($GLOBALS["___mysqli_ston"], 'SELECT * FROM invite_codes WHERE id = ' . sqlesc($id) . ' AND sender = ' . sqlesc($CURUSER['id']).' AND status = "Pending"') or sqlerr(__FILE__, __LINE__);
    $fetch = mysqli_fetch_assoc($query) or stderr($lang['invites_error'], $lang['invites_noexsist']);
    $HTMLOUT .= "<form method='post' action='?do=send_email'>
    <table align='center' border='0' cellpadding='6' cellspacing='1' width='98%'><tr>
    <td class='rowhead'>E-Mail</td>
    <td class='colhead'><input type='text' size='40' name='email' /></td>
    </tr>
    <tr>
    <td colspan='2'>
    <input type='hidden' name='code' value='".$fetch['code']."' /></td></tr><tr>
    <td colspan='2' >
    <input type='submit' value='Send e-mail' class='btn' /></td></tr></table></form>";
    print stdhead('Invites') . $HTMLOUT . stdfoot();
    }elseif ($do =='delete_invite') {
    $id = (isset($_GET["id"]) ? (int)$_GET["id"] : (isset($_POST["id"]) ? (int)$_POST["id"] : ''));
    $query = mysqli_query($GLOBALS["___mysqli_ston"], 'SELECT * FROM invite_codes WHERE id = ' . sqlesc($id) . ' AND sender = ' . sqlesc($CURUSER['id']).' AND status = "Pending"') or sqlerr(__FILE__, __LINE__);
    $assoc = mysqli_fetch_assoc($query);
if (!$assoc)
    stderr($lang['invites_error'],$lang['invites_noexsist']);
    isset($_GET['sure']) && $sure = htmlspecialchars($_GET['sure']);
if (!$sure)
    stderr($lang['invites_delete1'], $lang['invites_sure'].' Click <a href="'.$_SERVER['PHP_SELF'].'?do=delete_invite&amp;id='.$id.'&amp;sender='.$CURUSER['id'].'&amp;sure=yes">here</a> to delete it or <a href="?do=view_page">here</a> to go back.');
    mysqli_query($GLOBALS["___mysqli_ston"], 'DELETE FROM invite_codes WHERE id = ' . sqlesc($id) . ' AND sender =' . sqlesc($CURUSER['id'].' AND status = "Pending"')) or sqlerr(__FILE__, __LINE__);
    mysqli_query($GLOBALS["___mysqli_ston"], 'UPDATE users SET invites = invites + 1 WHERE id = '.sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    header("Location: ?do=view_page");
    }elseif ($do ='confirm_account') {
    $userid = (isset($_GET["userid"]) ? (int)$_GET["userid"] : (isset($_POST["userid"]) ? (int)$_POST["userid"] : ''));
if (!is_valid_id($userid))
    stderr($lang['invites_error'], $lang['invites_invalid']);
    $select = mysqli_query($GLOBALS["___mysqli_ston"], 'SELECT id, username FROM users WHERE id = ' . sqlesc($userid) . ' AND invitedby = ' . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
    $assoc = mysqli_fetch_assoc($select);
if (!$assoc)
    stderr($lang['invites_error'], $lang['invites_errorid']);
    isset($_GET['sure']) && $sure = htmlspecialchars($_GET['sure']);
if (!$sure)
    stderr($lang['invites_confirm1'], $lang['invites_sure1'].' '.htmlspecialchars($assoc['username']).'\'s account? Click <a href="?do=confirm_account&amp;userid='.$userid.'&amp;sender='.$CURUSER['id'].'&amp;sure=yes">here</a> to confirm it or <a href="?do=view_page">here</a> to go back.');
    mysqli_query($GLOBALS["___mysqli_ston"], 'UPDATE users SET status = "confirmed" WHERE id = '.sqlesc($userid).' AND invitedby = '.sqlesc($CURUSER['id']).' AND status="pending"') or sqlerr(__FILE__, __LINE__);
$msg = sqlesc("Hey there :wave:
Welcome to {$FMED['site_name']}!

We have made many changes to the site, and we hope you enjoy them!
We have been working hard to make {$FMED['site_name']} somethin' special!

{$FMED['site_name']} has a strong community (just check out forums), and is a feature rich site. We hope you'll join in on all the fun!

Be sure to read the [url={$FMED['baseurl']}/rules.php]Rules[/url] and [url={$FMED['baseurl']}/faq.php]FAQ[/url] before you start using the site.
We are a strong friendly community here :D {$FMED['site_name']} is so much more then just torrents.
Just for kicks, we've started you out with 200.0 Karma Bonus  Points, and a couple of bonus GB to get ya started!
so, enjoy
cheers,
{$FMED['site_name']} Staff");
    $id = $assoc["id"];
    $subject = sqlesc("Welcome to {$FMED['site_name']} !");
    $added = sqlesc(time());
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO messages (sender, subject, receiver, msg, added) VALUES (0, $subject, $id, $msg, $added)") or sqlerr(__FILE__, __LINE__);
    header("Location: ?do=view_page");
}
?>