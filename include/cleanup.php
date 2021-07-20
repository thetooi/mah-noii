<?

require_once("functions.php");

function docleanup() {

	global $torrent_dir, $signup_timeout, $max_dead_torrent_time, $autoclean_interval;

	set_time_limit(0);
	ignore_user_abort(1);

	do {
		$res = mysql_query("SELECT id FROM torrents");
		$ar = array();
		while ($row = mysql_fetch_array($res)) {
			$id = $row[0];
			$ar[$id] = 1;
		}

		if (!count($ar))
			break;

		$dp = @opendir($torrent_dir);
		if (!$dp)
			break;

		$ar2 = array();
		while (($file = readdir($dp)) !== false) {
			if (!preg_match('/^(\d+)\.torrent$/', $file, $m))
				continue;
			$id = $m[1];
			$ar2[$id] = 1;
			if (isset($ar[$id]) && $ar[$id])
				continue;
			$ff = $torrent_dir . "/$file";
			unlink($ff);
		}
		closedir($dp);

		if (!count($ar2))
			break;

		$delids = array();
		foreach (array_keys($ar) as $k) {
			if (isset($ar2[$k]) && $ar2[$k])
				continue;
			$delids[] = $k;
			unset($ar[$k]);
		}
		if (count($delids))
			mysql_query("DELETE FROM torrents WHERE id IN (" . join(",", $delids) . ")");

		$res = mysql_query("SELECT torrent FROM peers GROUP BY torrent");
		$delids = array();
		while ($row = mysql_fetch_array($res)) {
			$id = $row[0];
			if (isset($ar[$id]) && $ar[$id])
				continue;
			$delids[] = $id;
		}
		if (count($delids))
			mysql_query("DELETE FROM peers WHERE torrent IN (" . join(",", $delids) . ")");

		$res = mysql_query("SELECT torrent FROM files GROUP BY torrent");
		$delids = array();
		while ($row = mysql_fetch_array($res)) {
			$id = $row[0];
			if ($ar[$id])
				continue;
			$delids[] = $id;
		}
		if (count($delids))
			mysql_query("DELETE FROM files WHERE torrent IN (" . join(",", $delids) . ")");
	} while (0);

	$deadtime = deadtime();
	mysql_query("DELETE FROM peers WHERE last_action < FROM_UNIXTIME($deadtime)");

	$deadtime -= $max_dead_torrent_time;
	mysql_query("UPDATE torrents SET visible='no' WHERE visible='yes' AND forcevisible='no' AND last_action < FROM_UNIXTIME($deadtime)");

	$deadtime = time() - $signup_timeout;
	mysql_query("DELETE FROM users WHERE status = 'pending' AND added < FROM_UNIXTIME($deadtime) AND last_login < FROM_UNIXTIME($deadtime) AND last_access < FROM_UNIXTIME($deadtime) AND last_access != '0000-00-00 00:00:00'");

 	$deadtime = time() - $signup_timeout;
	$user = mysql_query("SELECT invited_by FROM users WHERE status = 'pending' AND added < FROM_UNIXTIME($deadtime) AND last_access = '0000-00-00 00:00:00'");
	$arr = mysql_fetch_assoc($user);
         if (mysql_num_rows($user) > 0)
 	{
         $invites = mysql_query("SELECT invites FROM users WHERE id = $arr[invited_by]");
	$arr2 = mysql_fetch_assoc($invites);
         if ($arr2[invites] < 10)
	{
         $invites = $arr2[invites] +1;
	mysql_query("UPDATE users SET invites='$invites' WHERE id = $arr[invited_by]");
	}
         mysql_query("DELETE FROM users WHERE status = 'pending' AND added < FROM_UNIXTIME($deadtime) AND last_access = '0000-00-00 00:00:00'");
         }

	$torrents = array();
	$res = mysql_query("SELECT torrent, seeder, COUNT(*) AS c FROM peers GROUP BY torrent, seeder");
	while ($row = mysql_fetch_assoc($res)) {
		if ($row["seeder"] == "yes")
			$key = "seeders";
		else
			$key = "leechers";
		$torrents[$row["torrent"]][$key] = $row["c"];
	}

	$res = mysql_query("SELECT torrent, COUNT(*) AS c FROM comments GROUP BY torrent");
	while ($row = mysql_fetch_assoc($res)) {
		$torrents[$row["torrent"]]["comments"] = $row["c"];
	}

	$fields = explode(":", "comments:leechers:seeders");
	$res = mysql_query("SELECT id, seeders, leechers, comments FROM torrents");
	while ($row = mysql_fetch_assoc($res)) {
		$id = $row["id"];
		$torr = $torrents[$id];
		foreach ($fields as $field) {
			if (!isset($torr[$field]))
				$torr[$field] = 0;
		}
		$update = array();
		foreach ($fields as $field) {
			if ($torr[$field] != $row[$field])




				$update[] = "$field = " . $torr[$field];
		}
		if (count($update))
			mysql_query("UPDATE torrents SET " . implode(",", $update) . " WHERE id = $id");
	}


   //      delete from shoutbox after 2 days
        $secs = 2*86400;
        $dt = sqlesc(get_date_time(gmtime() - $secs));
        mysql_query("DELETE FROM shoutbox WHERE " . time() . " - date > $secs") or sqlerr(__FILE__, __LINE__);
    //delete old login attempts
    $secs = 1*86400; // Delete failed login attempts per one day.
    $dt = sqlesc(get_date_time(gmtime() - $secs)); // calculate date.
    mysql_query("DELETE FROM loginattempts WHERE banned='no' AND added < $dt"); // do job.
	//delete inactive user accounts
	$secs = 28*86400;
	$dt = sqlesc(get_date_time(gmtime() - $secs));
	$maxclass = UC_USER;
	$res = mysql_query("SELECT id FROM users WHERE parked='no' AND status='confirmed' AND class <= $maxclass AND last_access < $dt");
	while ($arr = mysql_fetch_assoc($res))
	{
    mysql_query("DELETE FROM users WHERE id=arr[id]");
    mysql_query("DELETE FROM messages WHERE receiver=arr[id]");
    mysql_query("DELETE FROM friends WHERE userid=arr[id]");
    mysql_query("DELETE FROM bookmarks WHERE userid=arr[id]");
    mysql_query("DELETE FROM respect WHERE userid=arr[id]");
}

	//delete old/ no upload accounts
	$secs = 28*86400;
	$dt = sqlesc(get_date_time(gmtime() - $secs));
	$maxclass = UC_USER;
	$res = mysql_query("SELECT id FROM users WHERE uploaded < 10 AND class <= $maxclass AND added < $dt");
	while ($arr = mysql_fetch_assoc($res))
	{
    mysql_query("DELETE FROM users WHERE id=arr[id]");
    mysql_query("DELETE FROM messages WHERE receiver=arr[id]");
    mysql_query("DELETE FROM friends WHERE userid=arr[id]");
    mysql_query("DELETE FROM bookmarks WHERE userid=arr[id]");
    mysql_query("DELETE FROM respect WHERE userid=arr[id]");
}

	//delete parked user accounts
    $secs = 56*86400; // change the time to fit your needs
    $dt = sqlesc(get_date_time(gmtime() - $secs));
    $maxclass = UC_USER;
	$res = mysql_query("SELECT id FROM users WHERE parked='yes' AND status='confirmed' AND class <= $maxclass AND last_access < $dt");
	while ($arr = mysql_fetch_assoc($res))
	{
    mysql_query("DELETE FROM users WHERE id=arr[id]");
    mysql_query("DELETE FROM messages WHERE receiver=arr[id]");
    mysql_query("DELETE FROM friends WHERE userid=arr[id]");
    mysql_query("DELETE FROM bookmarks WHERE userid=arr[id]");
    mysql_query("DELETE FROM respect WHERE userid=arr[id]");
}

	// lock topics where last post was made more than x days ago
	$secs = 14*86400;
	$res = mysql_query("SELECT topics.id FROM topics LEFT JOIN posts ON topics.lastpost = posts.id AND topics.sticky = 'no' WHERE " . gmtime() . " - UNIX_TIMESTAMP(posts.added) > $secs") or sqlerr(__FILE__, __LINE__);
	while ($arr = mysql_fetch_assoc($res))
		mysql_query("UPDATE topics SET locked='yes' WHERE id=$arr[id]") or sqlerr(__FILE__, __LINE__);

  //remove expired warnings
  $res = mysql_query("SELECT id FROM users WHERE warned='yes' AND warneduntil < NOW() AND warneduntil <> '0000-00-00 00:00:00'") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $msg = "Your warning has been removed. Please keep in your best behaviour from now on.\n";
    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET warned = 'no', warneduntil = '0000-00-00 00:00:00' WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
      sendPersonalMessage(0, 0, "The warning for'$arr[username]' has expired", $mod_msg, PM_FOLDERID_MOD, 0, "open");
      write_log("remwarn", "The warning for user'<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' expired.");
      write_modcomment($arr["id"], 0, "Warning expired.");
    }
  }


/////////////////////////////////////////////Automatic Demotion to Peasant Stuff///////////////////////////////
/////////Update last_check for classes great than 1/////////
    $res = mysql_query("SELECT id FROM users WHERE class > 1") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) > 0)
    {
        $dt = sqlesc(get_date_time());
        while ($arr = mysql_fetch_assoc($res))
        {
        mysql_query("UPDATE users SET last_check = '" . get_date_time() . "' WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
        }
    }
/////////Update last_check for users who downloaded less than 1 GB/////////
    $limit = 1*1024*1024*1024;
    $res = mysql_query("SELECT id FROM users WHERE class = 1 AND downloaded < $limit") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) > 0)
    {
        $dt = sqlesc(get_date_time());
        while ($arr = mysql_fetch_assoc($res))
        {
        mysql_query("UPDATE users SET last_check = '" . get_date_time() . "', maxtorrents = 5 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
        }
    }
/////////Promote peasant user if ratio is above .3/////////
    $minratio = 0.30;
    $res = mysql_query("SELECT id FROM users WHERE class = 0 AND uploaded / downloaded >= $minratio") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) > 0)
    {
        $dt = sqlesc(get_date_time());

        $msg = "Congratulations, you have been auto-promoted to <b>User</b> again.You can now stand without shame of your fellow compadres. You are allowed to have 10 active torrents.\n";
        while ($arr = mysql_fetch_assoc($res))
        {
            mysql_query("UPDATE users SET last_check = '" . get_date_time() . "', class = 1, maxtorrents = 10, warned = 'no', leechwarn = 'no' WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
           	sendPersonalMessage(0, $arr["id"], "Automatic promotion to 'User' ", $msg, PM_FOLDERID_SYSTEM, 0);
            write_log("promotion", "The user'<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' was automatically transported to the User.");
            write_modcomment($arr["id"], 0, "Automatic promotion to power user.");
        }
    }
/////////Warn user of demotion to peasant if they have downloaded over 1 GB, ratio is below .3 for 1 weeks/////////
    $limit = 1*1024*1024*1024;
    $dt = sqlesc(get_date_time(gmtime() - 86400*7));
    $minratio = 0.30;
    $res = mysql_query("SELECT id FROM users WHERE class = 1 AND downloaded > $limit AND last_check < $dt AND uploaded / downloaded < $minratio AND leechwarn = 'no'") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) > 0)
    {
        $dt = sqlesc(get_date_time());
        $msg = "You will be auto-demoted from User to Peasant in another week because your ratio has dropped below $minratio for a week. You are only allowed to have 5 active torrents.\n";
        while ($arr = mysql_fetch_assoc($res))
        {
	   mysql_query("UPDATE users SET leechwarn = 'yes', maxtorrents = 5, warned = 'yes' WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
       sendPersonalMessage(0, $arr["id"], "Attention!!", $msg, PM_FOLDERID_SYSTEM, 0);
        }
    }
/////////Demote user to peasant if they have downloaded over 1 GB, ratio is below .3 for 2 weeks/////////
    $limit = 1*1024*1024*1024;
    $secs = 14*86400;
    $dt = sqlesc(get_date_time(gmtime() - $secs));
    $minratio = 0.30;
    $res = mysql_query("SELECT id FROM users WHERE class = 1 AND downloaded > $limit AND last_check < $dt AND uploaded / downloaded < $minratio") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) > 0)
    {
        $dt = sqlesc(get_date_time());
        $msg = "You have been auto-demoted from User to Peasant because your share ratio has dropped below $minratio for 2 weeks. Your account will be automatically deleted in 2 weeks if your ratio is not above $minratio. You are only allowed to have 2 active torrents.\n";
        while ($arr = mysql_fetch_assoc($res))
        {
            mysql_query("UPDATE users SET class = 0, maxtorrents = 2 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
            sendPersonalMessage(0, $arr["id"], "You have been to 'Peasant' demoted", $msg, PM_FOLDERID_SYSTEM, 0);
            write_log("demotion", "The user'<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' was automatically demoted to the Peasant.");
            write_modcomment($arr["id"], 0, "Automatic demotion to the Peasant.");
        }
    }
//////////disable peasant accounts////////////
	$secs = 28*86400;
	$dt = sqlesc(get_date_time(gmtime() - $secs));
	mysql_query("UPDATE users SET enabled  = 'no' WHERE class = 0 AND last_check < $dt");
/////////Update last_check for users with ratio above .30 and have warning/////////
    $minratio = 0.30;
    $res = mysql_query("SELECT id FROM users WHERE class = 1 AND leechwarn = 'yes' AND uploaded / downloaded > $minratio") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) > 0)
    {
        $msg = "Congratulations, your warning has automatically been removed.You are allowed to have 10 active torrents again.\n";
        $dt = sqlesc(get_date_time());
        while ($arr = mysql_fetch_assoc($res))
        {
        mysql_query("UPDATE users SET last_check = '" . get_date_time() . "', maxtorrents = 10, leechwarn = 'no', warned = 'no' WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
        sendPersonalMessage(0, $arr["id"], "Your warning has expired", $msg, PM_FOLDERID_SYSTEM, 0);
        sendPersonalMessage(0, 0, "The warning for'$arr[username]' has expired", $mod_msg, PM_FOLDERID_MOD, 0, "open");
        write_log("remwarn", "The warning for user'<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' warning has expired.");
        }
    }
/////////Update last_check for users with ratio above .30 & downloaded over 1 GB/////////
    $limit = 1*1024*1024*1024;
    $minratio = 0.30;
    $res = mysql_query("SELECT id FROM users WHERE class = 1 AND uploaded / downloaded > $minratio AND downloaded >= $limit") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) > 0)
    {
        $dt = sqlesc(get_date_time());
        while ($arr = mysql_fetch_assoc($res))
        {
        mysql_query("UPDATE users SET last_check = '" . get_date_time() . "', maxtorrents = 20 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
        }
    }
///////////////////////////////////////End of Automatic Demotion to Peasant Stuff////////////////////////////

	// promote power users
	$limit = 10*1024*1024*1024;
	$minratio = 1.05;
	$maxdt = sqlesc(get_date_time(gmtime() - 86400*28));
	$res = mysql_query("SELECT id FROM users WHERE class = 1 AND uploaded >= $limit AND uploaded / downloaded >= $minratio AND added < $maxdt") or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) > 0)
	{
		$dt = sqlesc(get_date_time());
		$msg = sqlesc("Congratulations, you have been auto-promoted to [b]Power User[/b]. :)\nYour account can not be deleted automatically. You are allowed to have 100 active torrents.\n");
		while ($arr = mysql_fetch_assoc($res))
		{
			mysql_query("UPDATE users SET class = 2, invites = 5, maxtorrents = 100 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
			sendPersonalMessage(0, $arr["id"], "Automatic promotion to 'Power User' ", $msg, PM_FOLDERID_SYSTEM, 0);
            write_log("promotion", "The user'<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' was automatically transported to the Power user.");
            write_modcomment($arr["id"], 0, "Automatic promotion to power user.");
		}
	}

	// demote power users
	$minratio = 0.95;
	$res = mysql_query("SELECT id FROM users WHERE class = 2 AND uploaded / downloaded < $minratio") or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) > 0)
	{
		$dt = sqlesc(get_date_time());
		$msg = "You have been auto-demoted from [b]Power User[/b] to [b]User[/b] because your share ratio has dropped below $minratio. You are allowed to have 10 active torrents.\n";
		while ($arr = mysql_fetch_assoc($res))
		{
			mysql_query("UPDATE users SET class = 1, maxtorrents = 10, invites = 0 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
			sendPersonalMessage(0, $arr["id"], "You have been to 'User' demoted", $msg, PM_FOLDERID_SYSTEM, 0);
            write_log("demotion", "The user'<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' was automatically demoted to the user.");
            write_modcomment($arr["id"], 0, "Automatic demotion to the user.");
		}
	}

	// Update stats
	$seeders = get_row_count("peers", "WHERE seeder='yes'");
	$leechers = get_row_count("peers", "WHERE seeder='no'");
	mysql_query("UPDATE avps SET value_u=$seeders WHERE arg='seeders'") or sqlerr(__FILE__, __LINE__);
	mysql_query("UPDATE avps SET value_u=$leechers WHERE arg='leechers'") or sqlerr(__FILE__, __LINE__);

	// update forum post/topic count
	$forums = mysql_query("select id from forums");
	while ($forum = mysql_fetch_assoc($forums))
	{
		$postcount = 0;
		$topiccount = 0;
		$topics = mysql_query("select id from topics where forumid=$forum[id]");
		while ($topic = mysql_fetch_assoc($topics))
		{

			$res = mysql_query("select count(*) from posts where topicid=$topic[id]");
			$arr = mysql_fetch_row($res);
			$postcount += $arr[0];
			++$topiccount;
		}
		mysql_query("update forums set postcount=$postcount, topiccount=$topiccount where id=$forum[id]");
	}

        /////////////////////////////////delete inactive torrents/////////////////////////////////////
	$days = 3;
	$dt = sqlesc(get_date_time(gmtime() - ($days * 86400)));
	$res = mysql_query("SELECT id, name FROM torrents WHERE seeders = 0 AND last_action < $dt");
	while ($arr = mysql_fetch_assoc($res))
	{
		@unlink("$torrent_dir/$arr[id].torrent");
		mysql_query("DELETE FROM torrents WHERE id=$arr[id]");
		mysql_query("DELETE FROM peers WHERE torrent=$arr[id]");
		mysql_query("DELETE FROM comments WHERE torrent=$arr[id]");
		mysql_query("DELETE FROM files WHERE torrent=$arr[id]");
		mysql_query("DELETE FROM ratings WHERE torrent=$arr[id]");
		mysql_query("DELETE FROM bookmarks WHERE id=$arr[id]") or sqlerr(__FILE__,__LINE__);
		mysql_query("DELETE FROM thanks WHERE id=$arr[id]") or sqlerr(__FILE__,__LINE__);
		$msg = "Your Torrent '$ arr [name]' was automatically deleted by the system. (Inactive and older than $days days).\n";
        sendPersonalMessage(0, $arr["owner"], "One of your Torrents was deleted", $msg, PM_FOLDERID_SYSTEM, 0);
        write_log("torrentdelete", "Torrent $arr[id] ($arr[name]) was deleted by the system (disabled and older than $ days days)");
	}
}


?>