<?
require "include/functions.php";
dbconn(false);
loggedinorreturn();
initFolder();

$GLOBALS["FOLDER"] = intval($_REQUEST["folder"]);
if ($GLOBALS["FOLDER"] == 0) $GLOBALS["FOLDER"] = PM_FOLDERID_INBOX;

if ($CURUSER["class"] < UC_MODERATOR && $GLOBALS["FOLDER"] == PM_FOLDERID_MOD)
    stderr("Error "," You do not have access to this folder");

if ($GLOBALS["FOLDER"] > 0)
    $res = mysql_query("SELECT * FROM `pmfolders` WHERE id=".$GLOBALS["FOLDER"]." AND `owner`=".$CURUSER["id"]);
else {
    switch ($GLOBALS["FOLDER"]) {
    case PM_FOLDERID_INBOX:
            $foldername = "__inbox";
            break;
    case PM_FOLDERID_OUTBOX:
            $foldername = "__outbox";
            break;
    case PM_FOLDERID_SYSTEM:
            $foldername = "__system";
            break;
    case PM_FOLDERID_MOD:
            $foldername = "__mod";
            break;
    default:
            $foldername = "__invalid";
            break;
    }
    $res = mysql_query("SELECT * FROM `pmfolders` WHERE name='".$foldername."' AND `owner`=".$CURUSER["id"]);
}

if (mysql_num_rows($res) == 0)
    stderr("Error "," The folder is invalid!");

$finfo = mysql_fetch_assoc($res);

if (isset($_GET["sortfield"]) && in_array($_GET["sortfield"], array('added','subject','sendername','receivername'))) {
    if (isset($_GET["sortorder"]) && in_array($_GET["sortorder"], array("ASC", "DESC"))) {
        $finfo["sortfield"] = $_GET["sortfield"];
        $finfo["sortorder"] = $_GET["sortorder"];

        mysql_query("UPDATE `pmfolders` SET `sortfield`=".sqlesc($_GET["sortfield"]).",`sortorder`=".sqlesc($_GET["sortorder"])." WHERE `id`=".$finfo["id"]);
    }
}

if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && ($finfo["prunedays"] == 0 || $finfo["prunedays"] > $GLOBALS["PM_PRUNE_DAYS"]))
    $finfo["prunedays"] = $GLOBALS["PM_PRUNE_DAYS"];

// Action-Mapping
if (isset($_REQUEST["reply"]))      $_REQUEST["action"] = "reply";
if (isset($_REQUEST["delete"]))     $_REQUEST["action"] = "delete";
if (isset($_REQUEST["move"]))       $_REQUEST["action"] = "move";
if (isset($_REQUEST["markread"]))   $_REQUEST["action"] = "markread";
if (isset($_REQUEST["markunread"])) $_REQUEST["action"] = "markunread";
if (isset($_REQUEST["markclosed"])) $_REQUEST["action"] = "markclosed";
if (isset($_REQUEST["markopen"]))   $_REQUEST["action"] = "markopen";

if (isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case "createfolder":
            createFolderDialog();
            die();
        case "deletefolder":
            deleteFolderDialog();
            die();
        case "config":
            folderConfigDialog();
            die();
        case "send":
            sendMessageDialog();
            die();
    }

    if ((!isset($_REQUEST["id"]) || intval($_REQUEST["id"]) == 0) && !is_array($_REQUEST["selids"]))
        stderr("Error "," No news for this action!");

    // selids numerisch machen!
    if (is_array($_REQUEST["selids"])) {
        for ($I=0; $I<count($_REQUEST["selids"]); $I++) {
            $_REQUEST["selids"][$I] = intval($_REQUEST["selids"][$I]);
        }
    }

    checkMessageOwner();

    if (isset($_REQUEST["id"])) {
        $selids = intval($_REQUEST["id"]);
    } elseif (is_array($_REQUEST["selids"])) {
        $selids = implode(",", $_REQUEST["selids"]);
    }

    switch ($_REQUEST["action"]) {
        case "markopen":
            mysql_query("UPDATE `messages` SET `mod_flag`='open' WHERE `id` IN ($selids)");
            break;
        case "markclosed":
            mysql_query("UPDATE `messages` SET `mod_flag`='closed' WHERE `id` IN ($selids)");
            break;
        case "markread":
            mysql_query("UPDATE `messages` SET `unread`='' WHERE `id` IN ($selids)");
            break;
        case "markunread":
            mysql_query("UPDATE `messages` SET `unread`='yes' WHERE `id` IN ($selids)");
            break;
        case "reply":
            if ((!isset($_REQUEST["id"]) || intval($_REQUEST["id"]) == 0))
                stderr("Error "," The message ID can only parameters of the 'id' over - which as you try?!?");
            sendMessageDialog(intval($_REQUEST["id"]));
            die();
        case "read":
            displayMessage(intval($_REQUEST["id"]));
            die();
        case "delete":
            deletePersonalMessages($selids);
            break;
        case "move":
            if ($GLOBALS["FOLDER"] == PM_FOLDERID_SYSTEM || $GLOBALS["FOLDER"] == PM_FOLDERID_MOD)
                stderr("Error "," From this folder able to be no messages!");

            $target_folder = intval($_REQUEST["to_folder"]);
            if ($target_folder == 0) {
                selectTargetFolderDialog($selids);
                die();
            }

            if ($target_folder == PM_FOLDERID_SYSTEM || $target_folder == PM_FOLDERID_MOD)
                stderr("Error "," In this folder able to be no messages!");

            if ($target_folder != PM_FOLDERID_INBOX && $target_folder != PM_FOLDERID_OUTBOX)
                checkFolderOwner($target_folder);

            mysql_query("UPDATE `messages` SET `folder_in`=".intval($_REQUEST["to_folder"])." WHERE `id` IN ($selids) AND `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$CURUSER["id"]);
            mysql_query("UPDATE `messages` SET `folder_out`=".intval($_REQUEST["to_folder"])." WHERE `id` IN ($selids) AND `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$CURUSER["id"]);
            break;
    }

}

switch ($GLOBALS["FOLDER"]) {
    case PM_FOLDERID_INBOX:
        $finfo["name"] = "Inbox";
        break;
    case PM_FOLDERID_OUTBOX:
        $finfo["name"] = "Outgoing";
        break;
    case PM_FOLDERID_SYSTEM:
        $finfo["name"] = "System messages";
        break;
    case PM_FOLDERID_MOD:
        $finfo["name"] = "Mod Notifications";
        break;
}

stdhead("News");
?>
<script type="text/javascript">

function selectAll()
{
    var I=1;
    var check = document.forms['msgform'].elements['selall'].checked;

    while (eval("document.forms['msgform'].elements['chkbox" + I + "']") != 'undefined') {
        eval("document.forms['msgform'].elements['chkbox" + I + "']").checked = check;
        I++;
    }
}

</script>

<form id="msgform" method="post" action="messages.php">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<table width="95%" >
  <colgroup>
    <col width="100%">
    <col width="200">
  </colgroup>
  <tr>
    <td valign="top">
<?php
begin_frame2('<img src="'.$pic_base_url.'pm/mail_generic22.png" width="22" height="22" alt="" style="vertical-align: middle;"> Folder - '.htmlspecialchars($finfo["name"]));
begin_table2(TRUE);
?>
<colgroup>
  <col width="16">
  <col width="55%">
  <col width="15%">
  <col width="15%">
  <col width="15%">
  <col width="48">
</colgroup>
<tr>
  <th class="tablecat"><input onclick="selectAll();" type="checkbox" id="selall" name="selall" value="1"></th>
  <th class="tablecat" nowrap="nowrap"><? if ($finfo["sortfield"] == "subject") echo ($finfo["sortorder"]=="ASC"?'<img src="'.$pic_base_url.'pm/up.png" style="vertical-align:middle">&nbsp;':'<img src="'.$pic_base_url.'pm/down.png" style="vertical-align:middle">&nbsp;'); ?><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;sortfield=subject&amp;sortorder=<? if ($finfo["sortfield"] == "subject") echo ($finfo["sortorder"]=="ASC"?"DESC":"ASC"); else echo $finfo["sortorder"]; ?>"><font size=1><i>Subject</i></a></font></th>
  <th class="tablecat" nowrap="nowrap"><? if ($finfo["sortfield"] == "sendername") echo ($finfo["sortorder"]=="ASC"?'<img src="'.$pic_base_url.'pm/up.png" style="vertical-align:middle">&nbsp;':'<img src="'.$pic_base_url.'pm/down.png" style="vertical-align:middle">&nbsp;'); ?><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;sortfield=sendername&amp;sortorder=<? if ($finfo["sortfield"] == "sendername") echo ($finfo["sortorder"]=="ASC"?"DESC":"ASC"); else echo $finfo["sortorder"]; ?>"><font size=1><i>Sender</i></a></font></th>
  <th class="tablecat" nowrap="nowrap"><? if ($finfo["sortfield"] == "receivername") echo ($finfo["sortorder"]=="ASC"?'<img src="'.$pic_base_url.'pm/up.png" style="vertical-align:middle">&nbsp;':'<img src="'.$pic_base_url.'pm/down.png" style="vertical-align:middle">&nbsp;'); ?><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;sortfield=receivername&amp;sortorder=<? if ($finfo["sortfield"] == "receivername") echo ($finfo["sortorder"]=="ASC"?"DESC":"ASC"); else echo $finfo["sortorder"]; ?>"><font size=1><i>Receiver</i></a></font></th>
  <th class="tablecat" nowrap="nowrap"><? if ($finfo["sortfield"] == "added") echo ($finfo["sortorder"]=="ASC"?'<img src="'.$pic_base_url.'pm/up.png" style="vertical-align:middle">&nbsp;':'<img src="'.$pic_base_url.'pm/down.png" style="vertical-align:middle">&nbsp;'); ?><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;sortfield=added&amp;sortorder=<? if ($finfo["sortfield"] == "added") echo ($finfo["sortorder"]=="ASC"?"DESC":"ASC"); else echo $finfo["sortorder"]; ?>"><font size=1><i>Date</i></a></font></th>
  <th class="tablecat">&nbsp;</th>
</tr>
<?php

if ($GLOBALS["FOLDER"] == PM_FOLDERID_MOD) {
    // News from last 7 days
    mysql_query("DELETE FROM `messages` WHERE `folder_in`=".PM_FOLDERID_MOD." AND `sender`=0 AND `receiver`=0 AND UNIX_TIMESTAMP(`added`)<".(time()-7*86400));
    if ($_REQUEST["closed"]==1)
        $msgres = mysql_query("SELECT `messages`.`id`,`messages`.`folder_in`,`messages`.`folder_out`,`messages`.`mod_flag`,'0' AS `sender`,'0' AS`receiver`,`messages`.`unread`,`messages`.`subject`,`messages`.`added`,'System' AS `sendername`,'Tracker-Team' AS `receivername`  FROM `messages` WHERE `folder_in`=".PM_FOLDERID_MOD." AND `receiver`=0 AND `mod_flag`='closed' ORDER BY ".$finfo["sortfield"]." ".$finfo["sortorder"]);
    else
        $msgres = mysql_query("SELECT `messages`.`id`,`messages`.`folder_in`,`messages`.`folder_out`,`messages`.`mod_flag`,'0' AS `sender`,'0' AS`receiver`,`messages`.`unread`,`messages`.`subject`,`messages`.`added`,'System' AS `sendername`,'Tracker-Team' AS `receivername`  FROM `messages` WHERE `folder_in`=".PM_FOLDERID_MOD." AND `receiver`=0 AND `mod_flag`='open' ORDER BY ".$finfo["sortfield"]." ".$finfo["sortorder"]);
} else {

    if ($finfo["prunedays"] > 0) {
        $prunetime = time()-$finfo["prunedays"]*86400;
        mysql_query("DELETE FROM `messages` WHERE `folder_out`=0 AND `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$CURUSER["id"]." AND UNIX_TIMESTAMP(`added`)<".$prunetime);
        mysql_query("DELETE FROM `messages` WHERE `folder_in`=0 AND `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$CURUSER["id"]." AND UNIX_TIMESTAMP(`added`)<".$prunetime);
        mysql_query("UPDATE `messages` SET `folder_in`=0 WHERE `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$CURUSER["id"]." AND UNIX_TIMESTAMP(`added`)<".$prunetime);
        mysql_query("UPDATE `messages` SET `folder_out`=0 WHERE `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$CURUSER["id"]." AND UNIX_TIMESTAMP(`added`)<".$prunetime);
    }
    $msgres = mysql_query("SELECT `messages`.`id`,`messages`.`folder_in`,`messages`.`folder_out`,`messages`.`sender`,`messages`.`receiver`,`messages`.`unread`,`messages`.`subject`,`messages`.`added`,`sender`.`username` AS `sendername`,`receiver`.`username` AS `receivername`  FROM `messages` LEFT JOIN `users` AS `sender` ON `sender`.`id`=`messages`.`sender` LEFT JOIN `users` AS `receiver` ON `receiver`.`id`=`messages`.`receiver` WHERE (`folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$CURUSER["id"].") OR (`folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$CURUSER["id"].") ORDER BY ".$finfo["sortfield"]." ".$finfo["sortorder"]);
}

if (mysql_num_rows($msgres) == 0) {
    echo '<tr><td class="tablea" colspan="6">This folder contains no messages.</td></tr>'."\n";
} else {
    $msgnr = 1;
    while ($msg = mysql_fetch_assoc($msgres)) {
        messageLine($msg, $msgnr);
        $msgnr++;
    }

?>
<tr>
  <td class="tablea" colspan="6">
    <table cellspacing="2" cellpadding="2" border="0">
      <tr>
        <td>Anser selected messages:</td>
<?php if ($GLOBALS["FOLDER"] != PM_FOLDERID_MOD) { ?>
        <td>
          <input type="submit" name="delete" class="groovybutton2" value="Delete">
          <input type="submit" name="markread" class="groovybutton2" value="Mark Read">
          <input type="submit" name="markunread" class="groovybutton2" value="Mark unread"></td>
      </tr>
<?php if ($GLOBALS["FOLDER"] != PM_FOLDERID_SYSTEM) { ?>
      <tr>
        <td>move to ...:</td>
        <td>
          <select name="to_folder" size="1">
            <option>** Please go folder **</option>
            <option value="<?=PM_FOLDERID_INBOX?>">Inbox</option>
            <option value="<?=PM_FOLDERID_OUTBOX?>">Outgoing</option>
<?php
        getFolders(0, 0, TRUE);
?>
          </select>
          <input type="submit" name="move" class="groovybutton2" value="Move">
        </td>
<?php
        }
    } else {
?>
        <td><input type="submit" name="markclosed" value="As a mark done"></td>
        <td><input type="submit" name="markopen" value="As an outstanding mark"></td>
        <?php
    }
?>
        </tr>
    </table>
  </td>
</tr>
<?php
}

end_table();
end_frame();
?>
    </td>
    <td valign="top">
<?php
begin_frame2('<img src="'.$pic_base_url.'pm/folder_mail22.png" width="22" height="22" alt="" style="vertical-align: middle;"> Folder', FALSE, "90px;");
begin_table2(TRUE);
// Hauptordner
folderLine(PM_FOLDERID_INBOX, "Inbox", "folder_mail.png");
folderLine(PM_FOLDERID_OUTBOX, "Outgoing", "folder_sent_mail.png");
folderLine(PM_FOLDERID_SYSTEM, "System messages", "system.png");

if ($CURUSER["class"] >= UC_MODERATOR) {
    folderLine(PM_FOLDERID_MOD, "Mod Notifications", "folder_red.png");
    folderLine(PM_FOLDERID_MOD, "Done", "ok.png", 1);
}

getFolders();
end_table();
?>
        <img src="<?=$pic_base_url?>pm/folder_new.png" alt="New Folder" title="New Folder" style="vertical-align:middle">&nbsp;<a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=createfolder">Folder</a><br>
        <img src="<?=$pic_base_url?>pm/configure.png" alt="Configure" title="Configure" style="vertical-align:middle">&nbsp;<a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=config">Folder configure</a><br>
        <? if ($GLOBALS["FOLDER"] > 0) { ?>
        <img src="<?=$pic_base_url?>pm/editdelete.png" alt="Delete" title="Delete" style="vertical-align:middle">&nbsp;<a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=deletefolder">Delete Folder</a><br>
        <? } ?>
        <br>
        <?php
        end_frame();
?>
    </td>
  </tr>
</table>
</form>
<?php

stdfoot();

?>