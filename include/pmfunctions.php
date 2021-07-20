<?
function messageDate($date)
{
    $today = date("Y-m-d");
    $yesterday = date("Y-m-d", time()-24*3600);

    $date = preg_replace(":$today:", "<b>Today</b>", $date);
    $date = preg_replace(":$yesterday:", "<b>Yesterday</b>", $date);
    $date = preg_replace(": :", ", ", $date);

    return $date;
}

function deletePersonalMessages($delids, $userid = 0)
{
    global $CURUSER;

    if ($userid == 0)
        $userid = $CURUSER["id"];

    mysql_query("DELETE FROM `messages` WHERE `id` IN ($delids) AND `folder_in`=0 AND `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$userid);
    mysql_query("DELETE FROM `messages` WHERE `id` IN ($delids) AND `folder_out`=0 AND `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$userid);
    mysql_query("UPDATE `messages` SET `folder_in`=0 WHERE `id` IN ($delids) AND `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$userid);
    mysql_query("UPDATE `messages` SET `folder_out`=0 WHERE `id` IN ($delids) AND `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$userid);
}
function deletePMFolder($folder, $msgaction, $msgtarget)
{
    global $CURUSER;


    $res = mysql_query("SELECT `id` FROM `pmfolders` WHERE `parent`=".$folder);
    while ($subfolder = mysql_fetch_assoc($res))
        deletePMFolder($subfolder["id"], $msgaction, $msgtarget);


    $res = mysql_query("SELECT `id` FROM `messages` WHERE (`folder_in`=".$folder." AND `receiver`=".$CURUSER["id"].") OR (`folder_out`=".$folder." AND `sender`=".$CURUSER["id"].")");
    $msgids = array();
    while ($msg = mysql_fetch_assoc($res))
        $msgids[] = $msg["id"];
    $msgids = implode(",", $msgids);

    if ($msgaction == "delete")
        deletePersonalMessages($msgids);
    elseif ($msgaction == "move") {
        mysql_query("UPDATE `messages` SET `folder_in`=$msgtarget WHERE `id` IN ($msgids) AND `folder_in`=$folder AND `receiver`=".$CURUSER["id"]);
        mysql_query("UPDATE `messages` SET `folder_out`=$msgtarget WHERE `id` IN ($msgids) AND `folder_out`=$folder AND `sender`=".$CURUSER["id"]);
    }

    mysql_query("DELETE FROM `pmfolders` WHERE `id`=$folder");
}
function initFolder()
{
    global $CURUSER;

    $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `pmfolders` WHERE `owner`=".$CURUSER["id"]." AND `name` LIKE '__%'"));

    if ($arr["cnt"] == 0) {
        mysql_query("INSERT INTO `pmfolders` (`owner`,`name`,`sortfield`,`sortorder`) VALUES (".$CURUSER["id"].",'__inbox','added','DESC')");
        mysql_query("INSERT INTO `pmfolders` (`owner`,`name`,`sortfield`,`sortorder`) VALUES (".$CURUSER["id"].",'__outbox','added','DESC')");
        mysql_query("INSERT INTO `pmfolders` (`owner`,`name`,`sortfield`,`sortorder`) VALUES (".$CURUSER["id"].",'__system','added','DESC')");
        mysql_query("INSERT INTO `pmfolders` (`owner`,`name`,`sortfield`,`sortorder`) VALUES (".$CURUSER["id"].",'__mod','added','DESC')");
    }
}
function folderLine($id, $name, $image, $indent = 0, $mode = 'normal')
{
    global $CURUSER;

    $name = htmlspecialchars($name);
    $active = $id == $GLOBALS["FOLDER"];
    $linkadd = "";

    // Unread messages
    if ($id != PM_FOLDERID_MOD)
        $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `receiver`=$CURUSER[id] AND `folder_in`=$id AND `unread`='yes'"));
    else {
        if ($name == "Done") {
            $active = $active && $_REQUEST["closed"] == 1;
            $arr["cnt"] = 0;
            $linkadd = "&amp;closed=1";
        } else {
            $active = $active && !isset($_REQUEST["closed"]);
            $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `receiver`=0 AND `mod_flag`='open'"));
        }
    }
    $unread = $arr["cnt"];

    switch ($mode) {
        case "option":
            echo '<option value="'.$id.'">'.($indent?str_repeat ("&nbsp;&nbsp;&nbsp;", $indent):'').' '.$name.'</option>'."\n";
            break;

        case "normal":
            echo '<tr><td class="'.($active?'tablecat':'tablea').'" style="text-align: left;padding:0px;" nowrap="nowrap"><a href="messages.php?folder='.$id.$linkadd.'" style="display:block;padding:4px;'.($indent?'padding-left:'.($indent*16+4).'px;':'').'text-decoration:none;"><img src="'.$pic_base_url.'pic/pm/'.$image.'" alt="'.$name.'" title="'.$name.'" style="vertical-align:middle;border:none;">&nbsp;'.$name.($unread>0?'&nbsp;(<b>'.$unread.'</b>)':'').'</a></td></tr>'."\n";
            break;

        case "config":
            echo '<tr><td class="'.($active?'tablecat':'tablea').'" style="text-align: left;padding:0px;" nowrap="nowrap"><a href="messages.php?folder='.$id.'" style="display:block;padding:4px;'.($indent?'padding-left:'.($indent*16+4).'px;':'').'text-decoration:none;"><img src="'.$pic_base_url.'pic/pm/'.$image.'" alt="'.$name.'" title="'.$name.'" style="vertical-align:middle;border:none;">&nbsp;'.$name.($unread>0?'&nbsp;(<b>'.$unread.'</b>)':'').'</a></td></tr>'."\n";
            break;
    }
}
function getFolders($currentFolder = 0, $indent = 0, $mode = 'normal', $exclude = 0)
{
    global $CURUSER;
    $folder_res = mysql_query("SELECT * FROM `pmfolders` WHERE `owner`=".$CURUSER["id"]." AND `parent`=".$currentFolder." ORDER BY `name` ASC");

    while ($folder = mysql_fetch_assoc($folder_res)) {
        if (substr($folder["name"], 0, 2) == "__")
            continue;

        if ($exclude && $folder["id"] == $exclude)
            continue;

        folderLine($folder["id"], $folder["name"], "folder.png", $indent, $mode);
        getFolders($folder["id"], $indent+1, $mode);
    }
}


function messageLine($arr, $msgnr)
{
    global $CURUSER;

    if ($arr["sender"] == 0)
        $senderlink = "System";
    elseif ($arr["sendername"]!="")
        $senderlink = '<a href="userdetails.php?id='.$arr["sender"].'">'.htmlspecialchars($arr["sendername"]).'</a>';
    else
        $senderlink = "---";

    if ($arr["receiver"] == 0)
        $receiverlink = "Tracker-Team";
    elseif ($arr["receivername"]!="")
        $receiverlink = '<a href="userdetails.php?id='.$arr["receiver"].'">'.htmlspecialchars($arr["receivername"]).'</a>';
    else
        $receiverlink = "---";

    $arr["added"] = messageDate($arr["added"]);

    $unread_image = $pic_base_url."pic/pm/";
    if ($arr["folder_in"] == PM_FOLDERID_MOD) {
        if ($arr["mod_flag"]=="open") {
            $unread = TRUE;
            $unread_image .= "system.png";
            $unread_image_title = "To Edit";
        } else {
            $unread = FALSE;
            $unread_image .= "ok.png";
            $unread_image_title = "Done";
        }
    } else {
        if ($arr["unread"]=="yes") {
            $unread = TRUE;
            $unread_image .= "mail_new.png";
            $unread_image_title = "Ungelesen";
        } else {
            $unread = FALSE;
            $unread_image .= "mail_generic.png";
            $unread_image_title = "Read";
        }
    }

?>
<tr>
  <td class="tableb"><input id="chkbox<?=$msgnr?>" type="checkbox" name="selids[]" value="<?=$arr["id"]?>"></td>
  <td class="tablea"><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=mark<?=($arr["folder_in"] == PM_FOLDERID_MOD?($unread?"closed":"open"):($unread?"read":"unread"))?>&amp;id=<?=$arr["id"]?>"><img src="<?=$unread_image?>" alt="<?=$unread_image_title?>" title="<?=$unread_image_title?>" style="vertical-align:middle;border:none;"></a>&nbsp;<a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=read&amp;id=<?=$arr["id"]?>"><?=($unread?"<b>".htmlspecialchars($arr["subject"])."</b>":htmlspecialchars($arr["subject"]))?></a></td>
  <td class="tableb"><?=$senderlink?></td>
  <td class="tablea"><?=$receiverlink?></td>
  <td class="tableb" nowrap="nowrap"><?=$arr["added"]?></td>
  <td class="tablea" nowrap="nowrap">
    <? if ($arr["receiver"] > 0) { ?>
    <a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=delete&amp;id=<?=$arr["id"]?>"><img src="<?=$pic_base_url?>pm/mail_delete.png" alt="Delete" title="Delete" style="border:none;"></a>
    <? } else { ?>
    <img src="<?=$pic_base_url?>pm/mail_delete_disabled.png" alt="Delete" title="Delete" style="border:none;">
    <? } ?>

    <? if ($arr["receiver"] == $CURUSER["id"] && $arr["sender"] > 0 && $senderlink != "---") { ?>
    <a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=reply&amp;id=<?=$arr["id"]?>"><img src="<?=$pic_base_url?>pm/mail_reply.png" alt="Reply" title="Reply" style="border:none;"></a>
    <? } else { ?>
    <img src="<?=$pic_base_url?>pm/mail_reply_disabled.png" alt="Reply" title="Reply" style="border:none;">
    <? } ?>

    <? if ($arr["receiver"] > 0 && $arr["sender"] > 0) { ?>
    <a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=move&amp;id=<?=$arr["id"]?>"><img src="<?=$pic_base_url?>pm/2rightarrow.png" alt="Move" title="Move" style="border:none;"></a>
    <? } else { ?>
    <img src="<?=$pic_base_url?>pm/2rightarrow_disabled.png" alt="Move" title="Move" style="border:none;">
    <? } ?>
  </td>
</tr>
<?php
}

function checkMessageOwner($owner = "")
{
    global $CURUSER;

    if ($owner == "") {
        switch ($_REQUEST["action"]) {
            case "markopen":
            case "markclosed":
                if ($CURUSER["class"] < UC_MODERATOR)
                    stderr("Error", "You have for this action not a sufficient justification!");
                $owner = "team";
                break;

            case "markread":
            case "markunread":
            case "reply":
                $owner = "receiver";
                break;

            case "delete":
            case "move":
                $owner = "any";
                break;

            case "read":
                if ($CURUSER["class"] < UC_MODERATOR)
                    $owner = "any";
                else
                    $owner = "any+team";
                break;

            default:
                stderr("Error", "This action is invalid!");
        }
    }

    if (isset($_REQUEST["id"])) {
        $msgid = intval($_REQUEST["id"]);
        $tgtcount = 1;
        if ($owner == "receiver")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id`=$msgid AND `receiver`=".$CURUSER["id"]." AND folder_in <> 0";
        elseif ($owner == "any")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id`=$msgid AND ((`receiver`=".$CURUSER["id"]." AND folder_in <> 0) OR (`sender`=".$CURUSER["id"]." AND folder_out <> 0))";
        elseif ($owner == "team")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id`=$msgid AND `receiver`=0 AND `sender`=0 AND `folder_in`=".PM_FOLDERID_MOD;
        elseif ($owner == "any+team")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id`=$msgid AND ((`receiver`=0 AND `sender`=0 AND `folder_in`=".PM_FOLDERID_MOD.") OR ((`receiver`=".$CURUSER["id"]." AND folder_in <> 0) OR (`sender`=".$CURUSER["id"]." AND folder_out <> 0)))";
    } elseif (is_array($_REQUEST["selids"])) {
        $tgtcount = count($_REQUEST["selids"]);
        $selids = implode(",", $_REQUEST["selids"]);
        if ($owner == "receiver")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id` IN ($selids) AND `receiver`=".$CURUSER["id"]." AND folder_in <> 0";
        elseif ($owner == "any")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id` IN ($selids) AND ((`receiver`=".$CURUSER["id"]." AND folder_in <> 0) OR (`sender`=".$CURUSER["id"]." AND folder_out <> 0))";
        elseif ($owner == "team")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id` IN ($selids) AND `receiver`=0 AND `sender`=0 AND `folder_in`=".PM_FOLDERID_MOD;
    }

    $arr = mysql_fetch_assoc(mysql_query($query));

    if ($arr["cnt"] <> $tgtcount)
        stderr("Error", "<p>You have to at least one of the selected messages not sufficient authorization for the desired action.</p><p>Note that you only messages as read or unread can you have received!</p>");
}
function checkFolderOwner($folder)
{
    global $CURUSER;

    if ($folder <= 0)
        stderr( "Error", "You do not have an objective or an invalid folder.");

    $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `pmfolders` WHERE `id`=".intval($folder)." AND `owner`=".$CURUSER["id"]));

    if ($arr["cnt"] == 0)
        stderr("Error "," You have not provided the necessary permissions for the specified folder or folder does not exist.");
}

function sendPersonalMessage($sender,
                              $receiver,
                              $subject,
                              $body,
                              $folder_in = PM_FOLDERID_INBOX,
                              $folder_out = PM_FOLDERID_OUTBOX,
                              $mod_flag = "")
{
    global $CURUSER;

    if ($sender == $CURUSER["id"] && $receiver > 0) {
        $user = @mysql_fetch_assoc(mysql_query("SELECT `notifs`,`email`,UNIX_TIMESTAMP(`last_access`) as `la` FROM `users` WHERE `id`=$receiver"));
        if (!is_array($user))
            stderr("Error "," The recipient could not be determined.");
    }

    $queryset = array();
    $queryset[] = $sender;
    $queryset[] = $receiver;
    $queryset[] = $folder_in;
    $queryset[] = $folder_out;
    $queryset[] = "NOW()";
    $queryset[] = sqlesc($subject);
    $queryset[] = sqlesc($body);
    $queryset[] = sqlesc($mod_flag);

    $query = "INSERT INTO `messages` (`sender`,`receiver`,`folder_in`,`folder_out`,`added`,`subject`,`msg`,`mod_flag`) VALUES (";
    $query .= implode(",", $queryset).")";

    mysql_query($query);
    $msgid = mysql_insert_id();

    if ($sender == $CURUSER["id"] && $receiver > 0 && strpos($user["notifs"], "[pm]") !== FALSE) {
        if (time() - $user["la"] >= 300) {
            $body = <<<EOD
You have a new personal message from $ CURUSER ([ "username"]) receive!

You can use the following URL to the message.
You may have to login to see the message.

$DEFAULTBASEURL/messages.php?action=read&id=$msgid

--
{$SITENAME}
EOD;
            @mail($user["email"], "You have a message from. ".$CURUSER["username"]." get!",
	    	$body, "From: ".$SITEEMAIL);
        }
    }
}


function createFolderDialog()
{
    global $CURUSER;

    if (isset($_POST["docreate"])) {
        $parent = intval($_POST["parent"]);
        $prunedays = intval($_POST["prunedays"]);

        if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && $prunedays == 0)
            $prunedays = $GLOBALS["PM_PRUNE_DAYS"];

        if ($parent > 0)
            checkFolderOwner($parent);
        elseif ($parent < 0)
            stderr("Error "," You have no valid folder, under which the new folder will be created.");

        if ($_POST["foldername"] == "")
            stderr("Error "," You have a folder name!");

        if (substr($_POST["foldername"], 0, 2) == "__")
            stderr("Error", "The folder name can not begin with __!");

        if (strlen($_POST["foldername"]) > 120)
            stderr("Error", "The folder name is too long. They are allowed a maximum of 120 characters.");

        if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && $prunedays > $GLOBALS["PM_PRUNE_DAYS"])
            stderr("Error", "The maximum amounts Vorhaltezeit".$GLOBALS["PM_PRUNE_DAYS"]." Tage.");

        if (!in_array($_POST["sortfield"], array('added','subject','sendername','receivername')))
            stderr("Error", "The specified sort is invalid.");

        if ($_REQUEST["sortorder"] != "ASC" && $_POST["sortorder"] != "DESC")
            stderr("Error", "The specified order is invalid.");

        // Everything OK, create folders
        $queryset = array();
        $queryset[] = $parent;
        $queryset[] = $CURUSER["id"];
        $queryset[] = sqlesc($_POST["foldername"]);
        $queryset[] = sqlesc($_POST["sortfield"]);
        $queryset[] = sqlesc($_POST["sortorder"]);
        $queryset[] = $prunedays;
        $query = "INSERT INTO `pmfolders` (`parent`,`owner`,`name`,`sortfield`,`sortorder`,`prunedays`) VALUES (";
        $query .= implode(",", $queryset) . ")";

        mysql_query($query);

        stderr("Folder successfully created", "<p>The folder '".htmlspecialchars($_POST["foldername"])."' was successfully created.</p><p><a href=\"messages.php?folder=".mysql_insert_id()."\">Next to the new folder</a><br><a href=\"messages.php?folder=".$GLOBALS["FOLDER"]."\">Back to the most recently accessed folders</a></p>");
    }

    stdhead("New PM folder");
    begin_frame2('<img src="'.$pic_base_url.'pic/pm/folder_new22.png" width="22" height="22" alt="" style="vertical-align: middle;"> New PM folder ', FALSE, "600px;");
    ?>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="createfolder">
    <?php
    begin_table2(TRUE);
    ?>
  <tr>
    <td class="tableb">Folder name:</td>
    <td class="tablea"><input type="text" name="foldername" size="60" maxlength="120"></td>
  </tr>
  <tr>
    <td class="tableb">Create Folder:</td>
    <td class="tablea">
      <select name="parent" size="6" style="width: 450px;">
        <option value="0" selected="selected">Root Folder</option>
        <?php getFolders(0, 1, TRUE); ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="tableb">Sort by:</td>
    <td class="tablea">
      <select name="sortfield" size="1">
        <option value="subject">Subject</option>
        <option value="sendername">Sender</option>
        <option value="receivername">Recipient</option>
        <option value="added" selected="selected">Date</option>
      </select>
      <select name="sortorder" size="1">
        <option value="ASC">Ascending</option>
        <option value="DESC" selected="selected">Descending</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="tableb">Days:</td>
    <td class="tablea"><input type="text" name="prunedays" size="10" maxlength="5"> (<?=($GLOBALS["PM_PRUNE_DAYS"]?"Maximal ".$GLOBALS["PM_PRUNE_DAYS"]." 0 or empty for Maximum":"0 Prune days")?>)</td>
  </tr>
  <tr>
    <td class="tablea" colspan="2" style="text-align:center"><input type="submit" name="docreate" class="groovybutton" value="Folder"></td>
  </tr>
    <?php
    end_table();
    ?>
<form>
    <?php
    end_frame();
    stdfoot();
}
function folderConfigDialog()
{
    global $CURUSER, $finfo;

    switch ($finfo["name"]) {
        case "__inbox":
            $changename = FALSE;
            $finfo["name"] = "Inbox";
            break;

        case "__outbox":
            $changename = FALSE;
            $finfo["name"] = "Inbox";
            break;

        case "__system":
            $changename = FALSE;
            $finfo["name"] = "System messages";
            break;

        case "__mod":
            stderr( "Error", "At this folder can not be set.");
            break;

        default:
            $changename = TRUE;
    }

    if (isset($_POST["dosave"])) {
        $prunedays = intval($_POST["prunedays"]);

        if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && $prunedays == 0)
            $prunedays = $GLOBALS["PM_PRUNE_DAYS"];

        if ($changename && $_POST["foldername"] == "")
            stderr("Error "," You have a folder name!");

        if ($changename && substr($_POST["foldername"], 0, 2) == "__")
            stderr("Error ", "The folder name can not begin with __!");

        if ($changename && strlen($_POST["foldername"]) > 120)
            stderr("Error ", "The folder name is too long. They are allowed a maximum of 120 characters.");

        if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && $prunedays > $GLOBALS["PM_PRUNE_DAYS"])
            stderr("Error ", "The maximum amounts Vorhaltezeit".$GLOBALS["PM_PRUNE_DAYS"]." Tage.");

        if (!in_array($_POST["sortfield"], array('added','subject','sendername','receivername')))
            stderr("Error ", "The specified sort is invalid.");

        if ($_REQUEST["sortorder"] != "ASC" && $_POST["sortorder"] != "DESC")
            stderr( "Error", "The order is invalid.");


        $queryset = array();
        if ($changename)
            $queryset[] = "`name` = ".sqlesc($_POST["foldername"]);
        $queryset[] = "`sortfield` = ".sqlesc($_POST["sortfield"]);
        $queryset[] = "`sortorder` = ".sqlesc($_POST["sortorder"]);
        $queryset[] = "`prunedays` = ".$prunedays;
        $query = "UPDATE `pmfolders` SET ".implode(",", $queryset)." WHERE `id`=".$finfo["id"];

        mysql_query($query);

        stderr("Folder successfully changed", "<p>The folder'".htmlspecialchars($_POST["foldername"])."'was successfully changed.</p><p><a href=\"messages.php?folder=".$GLOBALS["FOLDER"]."\">Back to the most recently accessed folders</a></p>");
    }

    stdhead("Folder '".$finfo["name"]."' configure");
    begin_frame2('<img src="'.$pic_base_url.'pic/pm/configure22.png" width="22" height="22" alt="" style="vertical-align: middle;"> Folder \''.htmlspecialchars($finfo["name"]).'\' configure', FALSE, "600px;");
    ?>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="config">
    <?php
    begin_table2(TRUE);
    ?>
  <tr>
    <td class="tableb">Ordnername:</td>
    <td class="tablea"><? if ($changename) { ?><input type="text" name="foldername" size="60" maxlength="120" value="<?=htmlspecialchars($finfo["name"])?>"><? } else { echo htmlspecialchars($finfo["name"]); } ?></td>
  </tr>
  <tr>
    <td class="tableb">Sort by:</td>
    <td class="tablea">
      <select name="sortfield" size="1">
        <option value="added"<?=($finfo["sortfield"]=="added"?' selected="selected"':'')?>>Date</option>
        <option value="subject"<?=($finfo["sortfield"]=="subject"?' selected="selected"':'')?>>Subject</option>
        <option value="sendername"<?=($finfo["sortfield"]=="sendername"?' selected="selected"':'')?>>Sender</option>
        <option value="receivername"<?=($finfo["sortfield"]=="receivername"?' selected="selected"':'')?>>Recipient</option>
      </select>
      <select name="sortorder" size="1">
        <option value="ASC"<?=($finfo["sortorder"]=="ASC"?' selected="selected"':'')?>>Ascending</option>
        <option value="DESC"<?=($finfo["sortorder"]=="DESC"?' selected="selected"':'')?>>Descending</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="tableb">Days:</td>
    <td class="tablea"><input type="text" name="prunedays" size="10" maxlength="5" value="<?=$finfo["prunedays"]?>"> (<?=($GLOBALS["PM_PRUNE_DAYS"]?"Maximal ".$GLOBALS["PM_PRUNE_DAYS"]."0 or empty for Maximum":"0 Prune days")?>)</td>
  </tr>
  <tr>
    <td class="tablea" colspan="2" style="text-align:center"><input type="submit" name="dosave" class="groovybutton" value="Configure"></td>
  </tr>
    <?php
    end_table();
    ?>
<form>
    <?php
    end_frame();
    stdfoot();
}
function deleteFolderDialog()
{
    global $CURUSER, $finfo;

    if ($GLOBALS["FOLDER"] < 0)
        stderr("Error "," The standard folders can not be deleted!");

    if (isset($_POST["dodelete"])) {
        if ($_POST["msgaction"] != "delete" && $_POST["msgaction"] != "move")
            stderr("Error "," bad news for operation!");

        if ($_POST["msgaction"] == "move") {
            if (!isset($_POST["to_folder"]) || intval($_POST["to_folder"]) == 0)
                stderr("Error "," You have a destination for the select message!");

            $target_folder = intval($_POST["to_folder"]);

            if ($target_folder == PM_FOLDERID_SYSTEM || $target_folder == PM_FOLDERID_MOD)
                stderr("Error", "In this folder can not be moved!");

            if ($target_folder != PM_FOLDERID_INBOX && $target_folder != PM_FOLDERID_OUTBOX)
                checkFolderOwner($target_folder);
        } else {
            $target_folder = 0;
        }

        deletePMFolder($GLOBALS["FOLDER"], $_POST["msgaction"], $target_folder);

        stderr("Ok", "<p>The folder'".htmlspecialchars($finfo["name"])."' has been successfully removed.</p><p><a href=\"messages.php?folder=".PM_FOLDERID_INBOX."\">Back to Inbox</a></p>");
    }

    stdhead("Folder '".$finfo["name"]."' delete");
    begin_frame2('<img src="'.$pic_base_url.'pic/pm/editdelete22.png" width="22" height="22" alt="" style="vertical-align: middle;"> '."Folder'".htmlspecialchars($finfo["name"])."' delete", FALSE, "600px;");
    ?>
<p>You're creating the folder'<?=htmlspecialchars($finfo["name"])?>' and all contained sub-folder.
Please give to what the messages should be done, and click to confirm 'Delete'.</p>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" class="groovybutton" name="action" value="deletefolder">
    <?
    begin_table2(TRUE);
    ?>
  <tr>
    <td class="tablea"><input type="radio" name="msgaction" value="delete" checked="checked"> Messages</td>
  </tr>
  <tr>
    <td class="tablea">
      <input type="radio" name="msgaction" value="move"> News move to:
        <select name="to_folder" size="1">
        <option>** Please folder**</option>
        <option value="<?=PM_FOLDERID_INBOX?>">Inbox</option>
        <option value="<?=PM_FOLDERID_OUTBOX?>">Outgoing</option>
        <?php
                getFolders(0, 0, 'option', $GLOBALS["FOLDER"]);
        ?>
        </select>
    </td>
  </tr>
  <tr>
    <td class="tablea" style="text-align:center;">
      <input type="submit" class="groovybutton" name="dodelete" value="Delete">
    </td>
  </tr>
    <?
    end_table();
    ?>
</form>
    <?
    end_frame();
    stdfoot();

}
function selectTargetFolderDialog($selids)
{
    stdhead("Message (s) move");
    begin_frame2('<img src="'.$pic_base_url.'pic/pm/2rightarrow22.png" width="22" height="22" alt="" style="vertical-align: middle;"> Message (s) move ', FALSE, "600px;");
    ?>
<center>
<p>Please select a target folder in which you the message (s) want to move:</p>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<? if (strpos($selids, ",") === FALSE) { ?>
<input type="hidden" name="id" value="<?=$selids?>">
<? } else {
    $arr = explode(",", $selids);
    for ($I=0; $I<count($arr); $I++)
        echo '<input type="hidden" name="selids[]" value="'.$arr[$I].'">'."\n";
   }
?>
<p>
<select name="to_folder" size="1">
<option>** Please folder **</option>
<option value="<?=PM_FOLDERID_INBOX?>">Inbox</option>
<option value="<?=PM_FOLDERID_OUTBOX?>">Outgoing</option>
<?php
        getFolders(0, 0, 'option');
?>
</select>
<input type="submit" name="move" value="Move">
<input type="submit" value="Cancel">
</p>
</center>
</form>
<?
    end_frame();
    stdfoot();
}
function displayMessage()
{
    global $CURUSER;

    if ((!isset($_REQUEST["id"]) || intval($_REQUEST["id"]) == 0))
        stderr("Error "," The message ID can only parameters of the 'id' over - which as you try?!?");

    $msg = mysql_fetch_assoc(mysql_query("SELECT `messages`.*,`sender`.`username` AS `sendername`,`receiver`.`username` AS `receivername`  FROM `messages` LEFT JOIN `users` AS `sender` ON `sender`.`id`=`messages`.`sender` LEFT JOIN `users` AS `receiver` ON `receiver`.`id`=`messages`.`receiver` WHERE `messages`.`id`=".intval($_REQUEST["id"])));

    if ($msg["unread"] == 'yes' && $msg["receiver"] == $CURUSER["id"])
        mysql_query("UPDATE `messages` SET `unread`='' WHERE `id`=".$msg["id"]);

    $msg["added"] = messageDate($msg["added"]);

    if ($msg["sendername"] == "") {
        if ($msg["sender"] == 0)
            $msg["sendername"] = "System";
        else
            $msg["sendername"] = "Deleted";
        $sender_valid = FALSE;
    } else {
        $sender_valid = TRUE;
    }

    if ($msg["receivername"] == "") {
        if ($msg["receiver"] == 0)
            $msg["receivername"] = "Team";
        else
            $msg["receivername"] = "Deleted";
        $receiver_valid = FALSE;
    } else {
        $receiver_valid = TRUE;
    }

    stdhead("Personal message read");
    begin_frame2('<img src="'.$pic_base_url.'pic/pm/mail_generic22.png" width="22" height="22" alt="" style="vertical-align: middle;"> Personal message read ', FALSE, "600px;");
    ?>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="read">
<input type="hidden" name="id" value="<?=$msg["id"]?>">
<? if ($sender_valid) { ?>
<input type="hidden" name="receiver" value="<?=$msg["sender"]?>">
<? } ?>
    <?php
    begin_table2(TRUE);
    ?>
  <colgroup>
    <col width="50">
    <col>
  </colgroup>
  <tr>
    <td class="tablecat" colspan="2"><b>Subject:</b> <?=htmlspecialchars($msg["subject"])?></td>
  </tr>
  <tr>
    <td class="tableb"><b>Sender:</b></td>
    <td class="tablea"><?=($sender_valid?'<a href="userdetails.php?id='.$msg["sender"].'">'.htmlspecialchars($msg["sendername"]).'</a>':htmlspecialchars($msg["sendername"]))?></td>
  </tr>
  <tr>
    <td class="tableb"><b>Recipient:</b></td>
    <td class="tablea"><?=($receiver_valid?'<a href="userdetails.php?id='.$msg["receiver"].'">'.htmlspecialchars($msg["receivername"]).'</a>':htmlspecialchars($msg["receivername"]))?></a></td>
  </tr>
  <tr>
    <td class="tableb"><b>Date:</b></td>
    <td class="tablea"><?=$msg["added"]?></td>
  </tr>
  <tr>
    <td class="tableb" valign="top"><b>Message:</b></td>
    <td class="tablea"><?=format_comment($msg["msg"])?></td>
  </tr>
  <tr>
    <td class="tablea" style="text-align:center;" colspan="2">
      <? if ($msg["folder_in"] != PM_FOLDERID_MOD) { ?>
      <input type="submit" name="delete" class="groovybutton2" value="Delete">
      <? if ($msg["receiver"] == $CURUSER["id"] && $msg["sender"] > 0 && $msg["sendername"] != "Gelöscht") { ?>
      <input type="submit" name="reply" class="groovybutton2" value="Reply">
      <? } ?>
        <select name="to_folder" size="1">
            <option>** Please folder **</option>
            <option value="<?=PM_FOLDERID_INBOX?>">Inbox</option>
            <option value="<?=PM_FOLDERID_OUTBOX?>">Outgoing</option>
<?php
        getFolders(0, 0, TRUE);
?>
          </select>
          <input type="submit" name="move" class="groovybutton2" value="Move">
      <? } ?>
      <? if ($msg["folder_in"] == PM_FOLDERID_MOD && $msg["mod_flag"] == "open") { ?>
      <input type="submit" name="markclosed" value="As a mark done">
      <? } elseif ($msg["folder_in"] == PM_FOLDERID_MOD && $msg["mod_flag"] == "closed") { ?>
      <input type="submit" name="markopen" value="As an outstanding mark">
      <? } ?>
    </td>
  </tr>
    <?php
    end_table();
    end_frame();
    stdfoot();

}

function sendMessageDialog($replymsg = 0)
{
    global $CURUSER;

    if ($replymsg) {
        $res = mysql_query("SELECT `messages`.*,`users`.`username` AS `sendername` FROM `messages` LEFT JOIN `users` ON `messages`.`sender`=`users`.`id` WHERE `messages`.`id`=".$replymsg);
        if (@mysql_num_rows($res) == 1) {
            $is_reply = TRUE;
            $msg = mysql_fetch_assoc($res);

            if ($msg["sendername"] == "")
                stderr("Error", "The desired recipient does not exist!");

            $action = "answer";
            $image = "mail_reply22.png";
            if (substr($msg["subject"], 0, 4) != "Re: ")
                $msg["subject"] = "Re: ".$msg["subject"];
            $body = "\n\n\n[quote=".$msg["sendername"]."]".stripslashes($msg["msg"])."[/quote]";
            $receiver = $msg["sender"];
        } else
            stderr( "Error", "The message to answer does not exist anymore.");
    } else {
        $res = mysql_query("SELECT `id` AS `sender`, `username` AS `sendername` FROM `users` WHERE `id`=".intval($_REQUEST["receiver"]));
        if (@mysql_num_rows($res) == 1) {
            $msg = mysql_fetch_assoc($res);
        } else
            stderr( "Error", "The desired recipient does not exist!");

        $is_reply = FALSE;
        $action = "Send";
        $image = "mail_send22.png";
        $receiver = intval($_REQUEST["receiver"]);
    }

    if ($receiver == $CURUSER["id"])
        stderr("Error "," You can no message to send yourself!");

    // Check if the message recipient wishes to receive
    $res = mysql_query("SELECT `acceptpms`, `notifs`, UNIX_TIMESTAMP(`last_access`) as `la` FROM `users` WHERE `id`=".$receiver) or sqlerr(__FILE__, __LINE__);
    $user = mysql_fetch_assoc($res);

    if (get_user_class() < UC_GUTEAM)
    {
        if ($user["acceptpms"] == "yes") {
            $res2 = mysql_query("SELECT * FROM blocks WHERE userid=$receiver AND blockid=".$CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
            if (mysql_num_rows($res2) == 1)
                stderr("Rejected "," This user has blocked PNs from you.");
        } elseif ($user["acceptpms"] == "friends") {
            $res2 = mysql_query("SELECT * FROM friends WHERE userid=$receiver AND friendid=".$CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
            if (mysql_num_rows($res2) != 1)
                stderr("Rejected "," This user accepts only PNs of users on his friends list.");
        } elseif ($user["acceptpms"] == "no")
            stderr("Rejected "," This user does not accept PNs.");
    }

    if (isset($_POST["send"])) {
        if ($_POST["subject"] == "")
            stderr("Error "," You must specify a subject!");

        if (strlen($_POST["subject"]) > 250)
            stderr("Error "," The subject is too long (maximum 250 characters)!");

        if ($_POST["body"] == "")
            stderr("Error "," You have a news text!");

        if (strlen($_POST["body"]) > 5000)
            stderr("Error "," The message text is too long. Please brief the text to below 5,000 mark!");

        if ($_POST["save"] == "yes")
            $folder_out = PM_FOLDERID_OUTBOX;
        else
            $folder_out = 0;

        sendPersonalMessage($CURUSER["id"], $receiver, stripslashes($_POST["subject"]), stripslashes($_POST["body"]), PM_FOLDERID_INBOX, $folder_out);

        if ($is_reply && $_POST["delorig"] == "yes") {
            // Keine weitere Prüfung nötig, da wir sonst nicht bis hierher kämen!
            deletePersonalMessages($replymsg);
        }

        stderr("Successfully sent message!", 'The message was successfully sent.<p><a href="messages.php?folder='.$GLOBALS["FOLDER"].'">Back to last folder</a></p>');
    }


    stdhead("Message $action");
    begin_frame2('<img src="'.$pic_base_url.'pic/pm/'.$image.'" width="22" height="22" alt="" style="vertical-align: middle;"> Message'.$action, FALSE, "600px;");
    ?>
<form  name=message action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="<?=($is_reply?"reply":"send")?>">
<input type="hidden" name="id" value="<?=$msg["id"]?>">
<input type="hidden" name="receiver" value="<?=$msg["sender"]?>">
    <?php
    begin_table2(TRUE);
    ?>
  <colgroup>
    <col width="50">
    <col>
  </colgroup>
  <tr>
    <td class="tableb"><b>Recipient:</b></td>
    <td class="tablea"><a href="userdetails.php?id=<?=$msg["sender"]?>"><?=htmlspecialchars($msg["sendername"])?></a></td>
  </tr>
  <tr>
    <td class="tableb"><b>Title:</b></td>
    <td class="tablea"><input type="text" name="subject" size="80" maxlength="250" value="<?=htmlspecialchars($msg["subject"])?>"></td>
  </tr>
  <tr>
    <td class="tableb" valign="top"><b>Body:</b></td>
    <td class="tablea">
<? textbbcode("message","body","$body")?>

  </tr>
  <tr>
    <td class="tableb"><b>Options:</b></td>
    <td class="tablea">
      <? if ($is_reply) { ?>
      <input type="checkbox" name="delorig" value="yes" <?=$CURUSER['deletepms'] == 'yes'?"checked":""?>>Delete this message to which you respond<br>
      <? } ?>
      <input type="checkbox" name="save" value="yes" <?=$CURUSER['savepms'] == 'yes'?"checked":""?>> Add a copy of this message to my sent items folder
  </tr>
  <tr>
    <td class="tablea" style="text-align:center;" colspan="2">
      <input type="submit" name="send" class="groovybutton" value="Send Message">
    </td>
  </tr>
    <?php
    end_table();
    end_frame();
    stdfoot();
}

?>