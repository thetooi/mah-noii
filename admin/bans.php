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
    $lang = array_merge( $lang, load_language('ad_bans') );
    $doUpdate = false;
    $remove = isset($_GET['remove']) ? (int)$_GET['remove'] : 0;
if (is_valid_id($remove)){
    @mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM bans WHERE id=$remove") or sqlerr();
    $removed = sprintf($lang['text_banremoved'], $remove);
    write_log("{$removed}".$CURUSER['id']." (".$CURUSER['username'].")");
    $doUpdate = true;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $CURUSER['class'] >= UC_ADMINISTRATOR){
if(isset($_POST['cacheit'])){
    $doUpdate = true;
    }else{
    $first = trim($_POST["first"]);
    $last = trim($_POST["last"]);
    $comment = trim($_POST["comment"]);
if (!$first || !$last || !$comment)
    stderr("{$lang['stderr_error']}", "{$lang['text_missing']}");
    $first = ip2long($first);
    $last = ip2long($last);
if ($first == -1 || $first === FALSE || $last == -1 || $last === FALSE)
    stderr("{$lang['stderr_error']}", "{$lang['text_badip.']}");
    $comment = sqlesc($comment);
    $added = time();
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, {$CURUSER['id']}, $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);
    $doUpdate = true;
    }
}
    $res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT b.*, u.username FROM bans b LEFT JOIN users u on b.addedby = u.id ORDER BY added DESC") or sqlerr(__FILE__,__LINE__);
    $configfile="<"."?php\n\n\$bans = array(\n";
    $HTMLOUT = '';
    $HTMLOUT .= "<h1>{$lang['text_current']}</h1>\n";
if (mysqli_num_rows($res) == 0){
    $HTMLOUT .= "<p align='center'><b>{$lang['text_nothing']}</b></p>\n";
    }else{
    $HTMLOUT .= "<table border='1' cellspacing='0' cellpadding='5'>\n";
    $HTMLOUT .= "<tr>
    <td class='colhead'>{$lang['header_added']}</td>
    <td class='colhead' align='left'>{$lang['header_firstip']}</td>
    <td class='colhead' align='left'>{$lang['header_lastip']}</td>
    <td class='colhead' align='left'>{$lang['header_by']}</td>
    <td class='colhead' align='left'>{$lang['header_comment']}</td>
    <td class='colhead'>{$lang['header_remove']}</td>
    </tr>\n";
    while ($arr = mysqli_fetch_assoc($res)){
if($doUpdate){
    $configfile .= "array('id'=> '{$arr['id']}', 'first'=> {$arr['first']}, 'last'=> {$arr['last']}),\n";
}
    $arr["first"] = long2ip($arr["first"]);
    $arr["last"] = long2ip($arr["last"]);
    $HTMLOUT .= "<tr>
    <td>".get_date($arr['added'],'')."</td>
    <td align='left'>{$arr['first']}</td>
    <td align='left'>{$arr['last']}</td>
    <td align='left'><a href='userdetails.php?id={$arr['addedby']}'>{$arr['username']}</a></td>
    <td align='left'>".htmlentities($arr['comment'], ENT_QUOTES)."</td>
    <td><a href='admin.php?action=bans&amp;remove={$arr['id']}'>{$lang['text_remove']}</a></td>
    </tr>\n";
}
    $HTMLOUT .= "</table>\n";
}
if($doUpdate){
    $configfile .= "\n);\n\n?".">";
    $filenum = fopen ("cache/bans_cache.php","w");
    ftruncate($filenum, 0);
    fwrite($filenum, $configfile);
    fclose($filenum);
}
if ($CURUSER['class'] >= UC_ADMINISTRATOR){
    $HTMLOUT .= "<h2>{$lang['text_addban']}</h2>
      <form method='post' action='admin.php?action=bans'>
      <table border='1' cellspacing='0' cellpadding='5'>
        <tr>
          <td class='rowhead'>{$lang['table_firstip']}</td>
          <td><input type='text' name='first' size='40' /></td>
        </tr>
        <tr>
          <td class='rowhead'>{$lang['table_lastip']}</td>
          <td><input type='text' name='last' size='40' /></td>
        </tr>
        <tr>
          <td class='rowhead'>{$lang['table_comment']}</td><td><input type='text' name='comment' size='40' /></td>
        </tr>
        <tr>
          <td colspan='2' align='center'><input type='submit' name='okay' value='{$lang['btn_add']}' class='btn' /></td>
        </tr>
        <tr>
          <td colspan='2' align='center'><input type='submit' name='cacheit' value='{$lang['btn_cache']}' class='btn' /></td>
        </tr>
      </table>
      </form>";
}
    print stdhead("{$lang['stdhead_adduser']}") . $HTMLOUT . stdfoot();
?> 