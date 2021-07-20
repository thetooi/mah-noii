<?
ob_start("ob_gzhandler");
require "include/functions.php";
dbconn(true);
loggedinorreturn();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $choice = htmlspecialchars(mysql_escape_string($_POST["choice"]));
  if ($CURUSER && $choice != "" && $choice < 256 && $choice == floor($choice))
  {
    $res = mysql_query("SELECT * FROM polls ORDER BY added DESC LIMIT 1") or sqlerr();
    $arr = mysql_fetch_assoc($res) or die("No poll");
    $pollid = $arr["id"];
    $userid = $CURUSER["id"];
    $res = mysql_query("SELECT * FROM pollanswers WHERE pollid=$pollid && userid=$userid") or sqlerr();
    $arr = mysql_fetch_assoc($res);
    if ($arr) die("Dupe vote");
    mysql_query("INSERT INTO pollanswers VALUES(0, $pollid, $userid, $choice)") or sqlerr();
    if (mysql_affected_rows() != 1)
      stderr("Error", "An error occured. Your vote has not been counted.");
    header("Location: $BASEURL/");
    die;
  }
  else
    stderr("Error", "Please select an option.");
}


if ($CURUSER)
{
$a = @mysql_fetch_assoc(@mysql_query("SELECT id,username FROM users WHERE status='confirmed' ORDER BY id DESC LIMIT 1")) or die(mysql_error());
if ($CURUSER)
{
$file2 = "$CACHE/index/newestuser.txt";
$expire = 2*60; // 2 minutes
if (file_exists($file2) && filemtime($file2) > (time() - $expire)) {
    $newestuser = unserialize(file_get_contents($file2));
} else {

$res = mysql_query("SELECT id,username FROM users WHERE status='confirmed' ORDER BY id DESC LIMIT 1") or die(mysql_error());
while ($user = mysql_fetch_array($res) ) {
        $newestuser[] = $user;
    }
    $OUTPUT = serialize($newestuser);
    $fp = fopen($file2,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
} // end else
foreach ($newestuser as $a)
{
  $latestuser = "<a href=userdetails.php?id=" . $a["id"] . ">" . $a["username"] . "</a>";
}
}
$file = "$CACHE/index/stats.txt";
$expire = 10*60; // 10 minutes
if (file_exists($file) &&
    filemtime($file) > (time() - $expire)) {
$a=unserialize(file_get_contents($file));
$male = $a[1];
$female= $a[2];
$registered = $a[3];
$unverified = $a[4];
$torrents = $a[5];
$ratio = $a[6];
$peers = $a[7];
$seeders = $a[8];
$leechers = $a[9];
} else {
$male = number_format(get_row_count("users", "WHERE gender='Male'"));
$female = number_format(get_row_count("users", "WHERE gender='Female'"));
$registered = number_format(get_row_count("users"));
$unverified = number_format(get_row_count("users", "WHERE status='pending'"));
$torrents = number_format(get_row_count("torrents"));
//$dead = number_format(get_row_count("torrents", "WHERE visible='no'"));

$r = mysql_query("SELECT value_u FROM avps WHERE arg='seeders'") or sqlerr(__FILE__, __LINE__);
$a = mysql_fetch_row($r);
$seeders = 0 + $a[0];
$r = mysql_query("SELECT value_u FROM avps WHERE arg='leechers'") or sqlerr(__FILE__, __LINE__);
$a = mysql_fetch_row($r);
$leechers = 0 + $a[0];
$seeders = get_row_count("peers", "WHERE seeder='yes'");
$leechers = get_row_count("peers", "WHERE seeder='no'");
if ($leechers == 0)
  $ratio = 0;
else
$ratio = round($seeders / $leechers * 100);
$peers = number_format($seeders + $leechers);
$seeders = number_format($seeders);
$leechers = number_format($leechers);
$stats1 = array(1 => "$male", "$female", "$registered","$unverified","$torrents","$ratio","$peers","$seeders","$leechers");
$stats2 = serialize($stats1);
$fh = fopen($file, "w");
fwrite($fh,$stats2);
fclose($fh);
}

}

$dt = gmtime() - 180;
$dt = sqlesc(get_date_time($dt));
$result = mysql_query("SELECT SUM(last_access >= $dt) AS totalol FROM users") or sqlerr(__FILE__, __LINE__);

while ($row = mysql_fetch_array ($result))
{
$totalonline = $row["totalol"];
}


$file3 = "$CACHE/index/active.txt";
$expire = 30; // 30 seconds
if (file_exists($file3) && filemtime($file3) > (time() - $expire)) {
    $active3 = unserialize(file_get_contents($file3));
} else {
$dt = gmtime() - 180;
$dt = sqlesc(get_date_time($dt));
$active1 = mysql_query("SELECT id, username, class, donor FROM users WHERE last_access >= $dt ORDER BY username") or print(mysql_error());
while ($active2 = mysql_fetch_array($active1) ) {
        $active3[] = $active2;
    }
    $OUTPUT = serialize($active3);
    $fp = fopen($file3,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
} // end else

foreach ($active3 as $arr)
{
  if ($activeusers) $activeusers .= ",\n";
  switch ($arr["class"])
  {
case UC_SYSOP:
case UC_ADMINISTRATOR:
     $arr["username"] = "<font color=#FF0000>" . $arr["username"] . "</font>";
     break;
case UC_MODERATOR:
     $arr["username"] = "<font color=#6B001A>" . $arr["username"] . "</font>";
     break;
case UC_UPLOADER:
     $arr["username"] = "<font color=#9A6258>" . $arr["username"] . "</font>";
     break;
case UC_VIP:
     $arr["username"] = "<font color=#FF6600>" . $arr["username"] . "</font>";
     break;
 case UC_POWER_USER:
     $arr["username"] = "<font color=#4F3157>" . $arr["username"] . "</font>";
     break;
  }
 $donator = $arr["donor"];
  if ($donator == "yes")
    $activeusers .= "<nobr>";
  if ($CURUSER)
    $activeusers .= "<a href=userdetails.php?id=" . $arr["id"] . "><b>" . $arr["username"] . "</b></a>";
  else
   $activeusers .= "<b>$arr[username]</b>";
  if ($donator == 'yes')
    $activeusers .= "<img src=/pic/star.gif alt='Donated
$$arr[donated]'></nobr>";



}
if (!$activeusers)
  $activeusers = "There have been no active users lately.";




stdhead();
if ($CURUSER)
{
echo "<font class=small>Welcome to our newest member, <b>$latestuser</b>!</font>\n";
}
echo("<table width=95% class=main border=0 cellspacing=0 cellpadding=0>");
?>
<head>
	<style type="text/css" media="screen">@import "tabs.css";</style>
</head>

<body>
<?
$file5 = "$CACHE/index/news.txt";
$expire = 30; // 3 minutes
if (file_exists($file5) && filemtime($file5) > (time() - $expire)) {
    $news2 = unserialize(file_get_contents($file5));
} else {
$res = mysql_query("SELECT * FROM news WHERE ADDDATE(added, INTERVAL 45 DAY) > NOW() ORDER BY added DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
 while ($news1 = mysql_fetch_array($res) ) {
        $news2[] = $news1;
    }
    $OUTPUT = serialize($news2);
    $fp = fopen($file5,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
}
 // end else;
if ($news2)
{
echo("<div id=header5>
	<ul id=primary>
		<li><span>Recent news</span></li>
		<li><a href=onews.php>Other news</a></li>
		<li><a href=articles.php>Articles</a></li>
	</ul>
	");
	echo("<table width=95% border=1 cellspacing=0 cellpadding=10><tr><td class=text>\n<ul>");
       foreach ($news2 as $array)
	{
	  echo("<li><b>" . gmdate("Y-m-d",strtotime($array['added'])) . " - </b>" .  BBCodeToHTML(stripslashes($array['body'])));
    if (get_user_class() >= UC_ADMINISTRATOR)
    {
    	echo(" <font size=\"-2\">[<a class=altlink href=news.php?action=edit&newsid=" . $array['id'] . "&returnto=" . urlencode($_SERVER['PHP_SELF']) . "><b>E</b></a>]</font>");
    	echo(" <font size=\"-2\">[<a class=altlink href=news.php?action=delete&newsid=" . $array['id'] . "&returnto=" . urlencode($_SERVER['PHP_SELF']) . "><b>D</b></a>]</font>");
    }
    echo("</li>");
  }
  echo("</ul></td></tr></table>\n");
?>
<p>
<script language=javascript>
function SmileIT(smile,form,text){
   document.forms[form].elements[text].value = document.forms[form].elements[text].value+" "+smile+" ";
   document.forms[form].elements[text].focus();
}
</script>
<?
echo("<table width=95%' border='1' cellspacing='0' cellpadding='1'><tr><td class=text>\n");
echo("<iframe src='shoutbox.php' width='100%' height='220' frameborder='0' name='sbox' marginwidth='0' marginheight='0'></iframe><br><br>\n");
echo("<form action='shoutbox.php' method='get' target='sbox' name='shbox' onSubmit=\"mySubmit()\">\n");
echo("<center>Message: <input type='text' maxlength=140  name='shbox_text' size='100'>  <p><input type='submit' value='Post it'> <input type='hidden' name='sent' value='yes'></p>  \n");

echo("</td></tr></table></form>");
?>
<center><a href="javascript: SmileIT(':-)','shbox','shbox_text')"><img border=0 src=pic/smilies/smile1.gif></a><a href="javascript: SmileIT(':smile:','shbox','shbox_text')"><img border=0 src=pic/smilies/smile2.gif></a><a href="javascript: SmileIT(':-D','shbox','shbox_text')"><img border=0 src=pic/smilies/grin.gif></a><a href="javascript: SmileIT(':evo:','shbox','shbox_text')"><img src=pic/smilies/evo.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':-|','shbox','shbox_text')"><img border=0 src=pic/smilies/noexpression.gif></a><a href="javascript: SmileIT(':-/','shbox','shbox_text')"><img border=0 src=pic/smilies/confused.gif></a><a href="javascript: SmileIT(':-(','shbox','post')"><img border=0 src=pic/smilies/sad.gif></a><a href="javascript: SmileIT(':weep:','shbox','shbox_text')"><img src=pic/smilies/weep.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':-O','shbox','shbox_text')"><img src=pic/smilies/ohmy.gif border=0></a><a href="javascript: SmileIT('8-)','shbox','shbox_text')"><img src=pic/smilies/cool1.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':yawn:','shbox','shbox_text')"><img src=pic/smilies/yawn.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':sly:','shbox','shbox_text')"><img src=pic/smilies/sly.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':greedy:','shbox','shbox_text')"><img src=pic/smilies/greedy.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':weirdo:','shbox','shbox_text')"><img src=pic/smilies/weirdo.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':sneaky:','shbox','shbox_text')"><img src=pic/smilies/sneaky.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':kiss:','shbox','shbox_text')"><img src=pic/smilies/kiss.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':geek:','shbox','shbox_text')"><img src=pic/smilies/geek.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':evil:','shbox','shbox_text')"><img src=pic/smilies/evil.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':yucky:','shbox','shbox_text')"><img src=pic/smilies/yucky.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':shit:','shbox','shbox_text')"><img src=pic/smilies/shit.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':?:','shbox','shbox_text')"><img src=pic/smilies/question.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':!:','shbox','shbox_text')"><img src=pic/smilies/idea.gif width="18" height="18" border=0></a></center>
</center></p>

<?

}
  $bb ='';

	$bd_array = do_cache(

		 	"$CACHE/index/bd.txt",

			7200,

			"SELECT id, username, (YEAR(CURDATE())-year) - (RIGHT(CURDATE(),5)< CONCAT(month,'-',day)) 	FROM users WHERE year > 0 and month > 0 and day > 0 and RIGHT(CURDATE(),5)= CONCAT(month,'-',day)ORDER by username");

		{





		foreach($bd_array as $row)
  if ($CURUSER)
			$bb .='<a href="userdetails.php?id=' . $row[0] . '">' . $row[1] . '(' . $row[2] . ')</a>, ';

  	else

      $bb .='' . $row[1] . '(' . $row[2] . ')</b>, ';

	}


?>
<h2></h2>
<table width=95% border=1 cellspacing=0 cellpadding=10><tr><td align=left>
<table class=main border=1 cellspacing=0 cellpadding=5>
<h2>&nbsp;Active users (<?=$totalonline?>)</h2>
&nbsp;<?=$activeusers?>
</table>
</td></tr></table>

<?
if ($bb)
echo("<p><table width=95% border=1 cellspacing=0 cellpadding=10><tr><td class=text>
<p><i>Happy birthday:</i> <b> $bb </b></p>
</td></tr></table></p>");
if ("text/html, */*" == $_SERVER["HTTP_ACCEPT"])
{
 $u = mysql_fetch_assoc(mysql_query("select id, username from users where id=".$userid));
 mysql_query("update users set enabled='no', modcomment=".sqlesc("Banned for using RatioMaker")." where id=$userid" );
 benc_resp_raw("You have been banned for cheating");
}
?>

<?
if ($CURUSER)
{
  // Get current poll
$file4 = "$CACHE/index/poll.txt";
$expire = 3*60; // 3 minutes
if (file_exists($file4) && filemtime($file4) > (time() - $expire)) {
    $poll2 = unserialize(file_get_contents($file4));
} else {
  $res = mysql_query("SELECT * FROM polls ORDER BY added DESC LIMIT 1") or sqlerr();
while ($poll1 = mysql_fetch_array($res) ) {
        $poll2[] = $poll1;
    }
    $OUTPUT = serialize($poll2);
    $fp = fopen($file4,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
} // end else
if($poll2)

foreach ($poll2 as $arr)
{
  $pollid = $arr["id"];
  $userid = $CURUSER["id"];
  $question = $arr["question"];
  $o = array($arr["option0"], $arr["option1"], $arr["option2"], $arr["option3"], $arr["option4"],
    $arr["option5"], $arr["option6"], $arr["option7"], $arr["option8"], $arr["option9"],
    $arr["option10"], $arr["option11"], $arr["option12"], $arr["option13"], $arr["option14"],
    $arr["option15"], $arr["option16"], $arr["option17"], $arr["option18"], $arr["option19"]);

  // Check if user has already voted
  $res = mysql_query("SELECT * FROM pollanswers WHERE pollid=$pollid && userid=$userid") or sqlerr();
  $arr2 = mysql_fetch_assoc($res);

  echo("<p></p>");



	echo("</h2>\n");
	echo("<table width=95% border=1 cellspacing=0 cellpadding=10><tr><td align=center>\n");
  echo("<table class=interiortable  border=1 cellspacing=0 cellpadding=0><tr><td class=text>");
  echo("<p align=center><b>$question</b></p>\n");
  $voted = $arr2;
  if ($voted)
  {
    // display results
    if ($arr["selection"])
      $uservote = $arr["selection"];
    else
      $uservote = -1;
		// we reserve 255 for blank vote.
    $res = mysql_query("SELECT selection FROM pollanswers WHERE pollid=$pollid AND selection < 20") or sqlerr();

    $tvotes = mysql_num_rows($res);

    $vs = array(); // array of
    $os = array();

    // Count votes
    while ($arr2 = mysql_fetch_row($res))
      $vs[$arr2[0]] += 1;

    reset($o);
    for ($i = 0; $i < count($o); ++$i)
      if ($o[$i])
        $os[$i] = array($vs[$i], $o[$i]);

    function srt($a,$b)
    {
      if ($a[0] > $b[0]) return -1;
      if ($a[0] < $b[0]) return 1;
      return 0;
    }

    // now os is an array like this: array(array(123, "Option 1"), array(45, "Option 2"))
    if ($arr["sort"] == "yes")
    	usort($os, srt);
    echo("<table class=poll width=100% border=0 cellspacing=0 cellpadding=0>\n");
    $i = 0;
    while ($a = $os[$i])
    {
      if ($i == $uservote)
        $a[1] .= "&nbsp;*";
      if ($tvotes == 0)
      	$p = 0;
      else
      	$p = round($a[0] / $tvotes * 100);
      if ($i % 2)
        $c = "";
      else
        $c = "";
      echo("<tr><td nowrap  class=embedded align=left>" . $a[1] . "&nbsp;&nbsp;</td><td class=embedded align=left>" .
        "<img src=\"pic/vote_left".(($i%5)+1).".gif\"><img src=\"pic/vote_middle".(($i%5)+1).".gif\" height=9  width=" . ($p * 5) .
        "><img src=\"pic/vote_right".(($i%5)+1).".gif\"> $p%</td></tr>\n");
            $i++;

    }
    echo("</table>\n");
	$tvotes = number_format($tvotes);
    echo("<p align=center>Votes: $tvotes</p>\n");
  }
  else
  {
    echo("<form method=post action=index.php>\n");
    $i = 0;
    while ($a = $o[$i])
    {
      echo("<input type=radio name=choice value=$i>$a<br>\n");
      ++$i;
    }
    echo("<br>");
    echo("<input type=radio name=choice value=255>Blank vote (a.k.a. \"I just want to see the results!\")<br>\n");
    echo("<p align=center><input type=submit value='Vote!' class=btn></p>");

}
  }
?>
</td></tr></table>
<?
if ($voted)
  echo("<p align=center><a href=polls.php>Previous polls</a></p>\n");
      if (get_user_class() >= UC_MODERATOR)
    {

  	echo("<font class=small>");
  	        if($poll2)
		echo(" - [<a class=altlink href=makepoll.php?returnto=main><b>New</b></a>]\n");
		  if($poll2)
  	echo(" - [<a class=altlink href=makepoll.php?action=edit&pollid=$arr[id]&returnto=main><b>Edit</b></a>]\n");
  	       if($poll2)
		echo(" - [<a class=altlink href=polls.php?action=delete&pollid=$arr[id]&returnto=main><b>Delete</b></a>]");
		echo("</font>");
	}
?>
</td></tr></table><p></p>

<?
}
?>



<h2></h2>
 <table width=95%border=1 cellspacing=0 cellpadding=10><tr><td align=center>
<table class=interiortable border=1 cellspacing=0 cellpadding=5>
<tr><td class=rowhead>Max users</td><td align=right><?=$invites?></td></tr>
<tr><td class=rowhead>Registered users</td><td align=right><?=$registered?></td></tr>

<tr><td class=rowhead>Unconfirmed users</td><td align=right><?=$unverified?></td></tr>
<tr><td class=rowhead>Male users</td><td align=right><?=$male?></td></tr>
<tr><td class=rowhead>Female users</td><td align=right><?=$female?></td></tr>
<tr><td class=rowhead>Torrents</td><td align=right><?=$torrents?></td></tr>
<? if (isset($peers)) { ?>
<tr><td class=rowhead>Peers</td><td align=right><?=$peers?></td></tr>
<tr><td class=rowhead>Seeders</td><td align=right><?=$seeders?></td></tr>
<tr><td class=rowhead>Leechers</td><td align=right><?=$leechers?></td></tr>
<tr><td class=rowhead>Seeder/leecher ratio (%)</td><td align=right><?=$ratio?></td></tr>
 <? } ?>
   </table>
<?
echo("<p align=center><font class=small>Updated ".date('Y-m-d H:i:s', filemtime($file))."</font></p></table>");
?>
<h2></h2><p>
</p>
<table width=95% border=1 cellspacing=0 cellpadding=10><tr><td align=left>
<table class=main border=1 cellspacing=0 cellpadding=5>
<h2></h2>
&nbsp;<font  class=small>Disclaimer: None of the files shown here are actually hosted
on this server. The links are provided solely by this site's users. The
administrator of this site (www.torrentbits.org) cannot be held responsible for
what its users post, or any other actions of its users. You may not use this
site to distribute or download any material when you do not have the legal
rights to do so. It is your own responsibility to adhere to these terms.</font>
</table>
</td></tr></table>




</p>


</td></tr></table>

<?
stdfoot();
?>