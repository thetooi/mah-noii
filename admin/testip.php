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
    print "<h1>Incorrect access</h1>You cannot access this file directly.";
    exit();
}
require_once "include/user_functions.php";
    $lang = array_merge( $lang, load_language('ad_testip') );
    $HTMLOUT = '';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $ip = isset($_POST["ip"]) ? $_POST["ip"] : false;
    }else{
    $ip = isset($_GET["ip"]) ? $_GET["ip"] : false;
}
if ($ip){
    $nip = ip2long($ip);
if ($nip == -1)
    stderr($lang['testip_error'], $lang['testip_error1']);
    $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM bans WHERE $nip >= first AND $nip <= last") or sqlerr(__FILE__, __LINE__);
if (mysqli_num_rows($res) == 0){
    stderr($lang['testip_result'], sprintf($lang['testip_notice'],htmlentities($ip, ENT_QUOTES)));
    }else{
    $HTMLOUT .= "<table class='main' border='0' cellspacing='0' cellpadding='5'>
    <tr>
          <td class='colhead'>{$lang['testip_first']}</td>
          <td class='colhead'>{$lang['testip_last']}</td>
          <td class='colhead'>{$lang['testip_comment']}</td>
    </tr>\n";
    while ($arr = mysqli_fetch_assoc($res)){
    $first = long2ip($arr["first"]);
    $last = long2ip($arr["last"]);
    $comment = htmlspecialchars($arr["comment"]);
    $HTMLOUT .= "<tr><td>$first</td><td>$last</td><td>$comment</td></tr>\n";
}
    $HTMLOUT .= "</table>\n";
    stderr($lang['testip_result'], "<table border='0' cellspacing='0' cellpadding='0'><tr><td class='embedded' style='padding-right: 5px'><img src='{$FMED['pic_base_url']}smilies/excl.gif' alt='' /></td><td class='embedded'>".sprintf($lang['testip_notice2'],$ip)."</td></tr></table><p>$HTMLOUT</p>");
    }
}
    $HTMLOUT .= "<h1>{$lang['testip_title']}</h1>
    <form method='post' action='admin.php?action=testip'>
    <table border='1' cellspacing='0' cellpadding='5'>
    <tr><td class='rowhead'>{$lang['testip_address']}</td><td><input type='text' name='ip' /></td></tr>
    <tr><td colspan='2' align='center'><input type='submit' class='btn' value='{$lang['testip_ok']}' /></td></tr>
    </table>
    </form>";
    print stdhead($lang['testip_windows_title']) . $HTMLOUT . stdfoot();
?> 