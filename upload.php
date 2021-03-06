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
dbconn(false);
loggedinorreturn();
    $lang = array_merge( load_language('global'), load_language('upload') );
    $HTMLOUT = '';
if ($CURUSER['class'] < UC_UPLOADER){
    stderr($lang['upload_sorry'], $lang['upload_no_auth']);
}
    $HTMLOUT .= "<div align='center'>
    <form enctype='multipart/form-data' action='takeupload.php' method='post'>
    <input type='hidden' name='MAX_FILE_SIZE' value='{$FMED['max_torrent_size']}' />
    <p>{$lang['upload_announce_url']} <b>{$FMED['announce_urls'][0]}</b></p>";
    $HTMLOUT .= "<table border='1' cellspacing='0' cellpadding='10'>
    <tr>
      <td class='heading' valign='top' align='right'>{$lang['upload_torrent']}</td>
      <td valign='top' align='left'><input type='file' name='file' size='80' /></td>
    </tr>
    <tr>
      <td class='heading' valign='top' align='right'>{$lang['upload_name']}</td>
      <td valign='top' align='left'><input type='text' name='name' size='80' /><br />({$lang['upload_filename']})</td>
    </tr>
    <tr>
      <td class='heading' valign='top' align='right'>{$lang['upload_poster']}</td>
      <td valign='top' align='left'>
      <input type='text' name='poster' size='80' /><br />{$lang['upload_poster1']}</td>
    </tr>
    <tr>
      <td class='heading' valign='top' align='right'>{$lang['upload_nfo']}</td>
      <td valign='top' align='left'><input type='file' name='nfo' size='80' /><br />({$lang['upload_nfo_info']})</td>
    </tr>
    <tr>
      <td class='heading' valign='top' align='right'>{$lang['upload_description']}</td>
      <td valign='top' align='left'><textarea name='descr' rows='10' cols='80'></textarea>
      <br />({$lang['upload_html_bbcode']})</td>
    </tr>";
    $s = "<select name='type'>\n<option value='0'>({$lang['upload_choose_one']})</option>\n";
    $cats = genrelist();
    foreach ($cats as $row){
    $s .= "<option value='{$row["id"]}'>" . htmlspecialchars($row["name"]) . "</option>\n";
}
    $s .= "</select>\n";
    $HTMLOUT.= "<tr><td class='rowhead' >Strip ASCII</td>
    <td class='col1'align='left'>
    <input type='checkbox' name='strip' value='strip' checked='checked' />
    <a href='http://en.wikipedia.org/wiki/ASCII_art' target='_blank'>What is this ?</td></tr>\n";
    $HTMLOUT.= "<tr><td class='rowhead' >{$lang['upload_box']}<td valign='top' align='left'>
    <input type='checkbox' name='box' value='yes' />{$lang['upload_box_only']}</td></tr>\n";
    $HTMLOUT.= "<tr><td class='rowhead' >{$lang['upload_vip']}<td valign='top' align='left'>
    <input type='checkbox' name='vip' value='yes' />{$lang['upload_vip_only']}</td></tr>\n";
    $HTMLOUT .= "<tr>
    <td class='heading' valign='top' align='right'>{$lang['upload_type']}</td>
        <td valign='top' align='left'>$s</td>
    </tr>
    <tr>
        <td align='center' colspan='2'><input type='submit' class='btn' value='{$lang['upload_submit']}' /></td>
    </tr>
    </table>
    </form>
    </div>";
    print stdhead($lang['upload_stdhead']) . $HTMLOUT . stdfoot();
?>