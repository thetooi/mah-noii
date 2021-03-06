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
if ( ! defined( 'IN_FMED_ADMIN' ) ){
    print "<h1>{$lang['text_incorrect']}</h1>{$lang['text_cannot']}";
    exit();
}
require_once "include/user_functions.php";
    $lang = array_merge( $lang, load_language('ad_delacct') );
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
if (!$username || !$password)
    stderr("{$lang['text_error']}", "{$lang['text_please']}");
    $res = @mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM users WHERE username=" . sqlesc($username) . "AND passhash=md5(concat(secret,concat(" . sqlesc($password) . ",secret)))") or sqlerr();
if (mysqli_num_rows($res) != 1)
    stderr("{$lang['text_error']}", "{$lang['text_bad']}");
    $arr = mysqli_fetch_assoc($res);
    $id = $arr['id'];
    $res = @mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM users WHERE id=$id") or sqlerr();
if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) != 1)
    stderr("{$lang['text_error']}", "{$lang['text_unable']}");
    stderr("{$lang['stderr_success']}", "{$lang['text_success']}");
}
    $HTMLOUT = "<h1>{$lang['text_delete']}</h1>
    <form method='post' action='admin.php?action=delacct'>
    <table border='1' cellspacing='0' cellpadding='5'>
    <tr>
        <td class='rowhead'>{$lang['table_username']}</td>
        <td><input size='40' name='username' /></td>
    </tr>
    <tr>
        <td class='rowhead'>{$lang['table_password']}</td>
        <td><input type='password' size='40' name='password' /></td>
    </tr>
    <tr>
        <td colspan='2'><input type='submit' class='btn' value='{$lang['btn_delete']}' /></td>
    </tr>
    </table>
    </form>";
    print stdhead("{$lang['stdhead_delete']}") . $HTMLOUT . stdfoot();
?> 