<?
if(!defined('IN_TRACKER'))
  die('Hacking attempt!');

$tzs["-720"] = "GMT -12:00";
$tzs["-660"] = "GMT -11:00";
$tzs["-600"] = "GMT -10:00 (HST)";
$tzs["-540"] = "GMT -09:00 (YST, HDT)";
$tzs["-480"] = "GMT -08:00 (PST, YDT)";
$tzs["-420"] = "GMT -07:00 (MST, PDT)";
$tzs["-360"] = "GMT -06:00 (CST, MDT)";
$tzs["-300"] = "GMT -05:00 (EST, CDT)";
$tzs["-240"] = "GMT -04:00 (AST, EDT)";
$tzs["-210"] = "GMT -03:30";
$tzs["-180"] = "GMT -03:00 (ADT)";
$tzs["-120"] = "GMT -02:00";
$tzs["-60"]  = "GMT -01:00";
$tzs["0"]    = "GMT (WET)";
$tzs["60"]   = "GMT +01:00 (CET, WEST)";
$tzs["120"]  = "GMT +02:00 (EET, CEST)";
$tzs["180"]  = "GMT +03:00 (EEST)";
$tzs["210"]  = "GMT +03:30";
$tzs["240"]  = "GMT +04:00";
$tzs["270"]  = "GMT +04:30";
$tzs["300"]  = "GMT +05:00";
$tzs["330"]  = "GMT +05:30 (IST)";
$tzs["345"]  = "GMT +05:45";
$tzs["360"]  = "GMT +06:00";
$tzs["390"]  = "GMT +06:30";
$tzs["420"]  = "GMT +07:00";
$tzs["480"]  = "GMT +08:00 (AWST)";
$tzs["540"]  = "GMT +09:00 (JST, AWDT)";
$tzs["570"]  = "GMT +09:30 (ACST)";
$tzs["600"]  = "GMT +10:00 (AEST)";
$tzs["630"]  = "GMT +10:30 (ACDT)";
$tzs["660"]  = "GMT +11:00 (AEDT)";
$tzs["720"]  = "GMT +12:00 (NZST)";
$tzs["780"]  = "GMT +13:00 (NZDT)";
// Returns the date for display in proper timezone
function display_date_time($timestamp = 0 , $tzoffset = 0)
{
   return date("Y-m-d H:i:s", $timestamp + ($tzoffset * 60));
}
$smilies = array(
  ":-)" => "smile1.gif",
  ":smile:" => "smile2.gif",
  ":-D" => "grin.gif",
  ":lol:" => "laugh.gif",
  ":w00t:" => "w00t.gif",
  ":-P" => "tongue.gif",
  ";-)" => "wink.gif",
  ":-|" => "noexpression.gif",
  ":-/" => "confused.gif",
  ":-(" => "sad.gif",
  ":'-(" => "cry.gif",
  ":weep:" => "weep.gif",
  ":-O" => "ohmy.gif",
  ":o)" => "clown.gif",
  "8-)" => "cool1.gif",
  "|-)" => "sleeping.gif",
  ":innocent:" => "innocent.gif",
  ":whistle:" => "whistle.gif",
  ":unsure:" => "unsure.gif",
  ":closedeyes:" => "closedeyes.gif",
  ":cool:" => "cool2.gif",
  ":fun:" => "fun.gif",
  ":thumbsup:" => "thumbsup.gif",
  ":thumbsdown:" => "thumbsdown.gif",
  ":blush:" => "blush.gif",
  ":unsure:" => "unsure.gif",
  ":yes:" => "yes.gif",
  ":no:" => "no.gif",
  ":love:" => "love.gif",
  ":?:" => "question.gif",
  ":!:" => "excl.gif",
  ":idea:" => "idea.gif",
  ":arrow:" => "arrow.gif",
  ":arrow2:" => "arrow2.gif",
  ":hmm:" => "hmm.gif",
  ":hmmm:" => "hmmm.gif",
  ":huh:" => "huh.gif",
  ":geek:" => "geek.gif",
  ":look:" => "look.gif",
  ":rolleyes:" => "rolleyes.gif",
  ":kiss:" => "kiss.gif",
  ":shifty:" => "shifty.gif",
  ":blink:" => "blink.gif",
  ":smartass:" => "smartass.gif",
  ":sick:" => "sick.gif",
  ":crazy:" => "crazy.gif",
  ":wacko:" => "wacko.gif",
  ":alien:" => "alien.gif",
  ":wizard:" => "wizard.gif",
  ":wave:" => "wave.gif",
  ":wavecry:" => "wavecry.gif",
  ":baby:" => "baby.gif",
  ":angry:" => "angry.gif",
  ":ras:" => "ras.gif",
  ":sly:" => "sly.gif",
  ":devil:" => "devil.gif",
  ":evil:" => "evil.gif",
  ":evilmad:" => "evilmad.gif",
  ":sneaky:" => "sneaky.gif",
  ":axe:" => "axe.gif",
  ":slap:" => "slap.gif",
  ":wall:" => "wall.gif",
  ":rant:" => "rant.gif",
  ":jump:" => "jump.gif",
  ":yucky:" => "yucky.gif",
  ":nugget:" => "nugget.gif",
  ":smart:" => "smart.gif",
  ":shutup:" => "shutup.gif",
  ":shutup2:" => "shutup2.gif",
  ":crockett:" => "crockett.gif",
  ":zorro:" => "zorro.gif",
  ":snap:" => "snap.gif",
  ":beer:" => "beer.gif",
  ":beer2:" => "beer2.gif",
  ":drunk:" => "drunk.gif",
  ":strongbench:" => "strongbench.gif",
  ":weakbench:" => "weakbench.gif",
  ":dumbells:" => "dumbells.gif",
  ":music:" => "music.gif",
  ":stupid:" => "stupid.gif",
  ":dots:" => "dots.gif",
  ":offtopic:" => "offtopic.gif",
  ":spam:" => "spam.gif",
  ":oops:" => "oops.gif",
  ":lttd:" => "lttd.gif",
  ":please:" => "please.gif",
  ":sorry:" => "sorry.gif",
  ":hi:" => "hi.gif",
  ":yay:" => "yay.gif",
  ":cake:" => "cake.gif",
  ":hbd:" => "hbd.gif",
  ":band:" => "band.gif",
  ":punk:" => "punk.gif",
	":rofl:" => "rofl.gif",
  ":bounce:" => "bounce.gif",
  ":mbounce:" => "mbounce.gif",
  ":thankyou:" => "thankyou.gif",
  ":gathering:" => "gathering.gif",
  ":hang:" => "hang.gif",
  ":chop:" => "chop.gif",
  ":rip:" => "rip.gif",
  ":whip:" => "whip.gif",
  ":judge:" => "judge.gif",
  ":chair:" => "chair.gif",
  ":tease:" => "tease.gif",
  ":box:" => "box.gif",
  ":boxing:" => "boxing.gif",
  ":guns:" => "guns.gif",
  ":shoot:" => "shoot.gif",
  ":shoot2:" => "shoot2.gif",
  ":flowers:" => "flowers.gif",
  ":wub:" => "wub.gif",
  ":lovers:" => "lovers.gif",
  ":kissing:" => "kissing.gif",
  ":kissing2:" => "kissing2.gif",
  ":console:" => "console.gif",
  ":group:" => "group.gif",
  ":hump:" => "hump.gif",
  ":hooray:" => "hooray.gif",
  ":happy2:" => "happy2.gif",
  ":clap:" => "clap.gif",
  ":clap2:" => "clap2.gif",
	":weirdo:" => "weirdo.gif",
  ":yawn:" => "yawn.gif",
  ":bow:" => "bow.gif",
	":dawgie:" => "dawgie.gif",
	":cylon:" => "cylon.gif",
  ":book:" => "book.gif",
  ":fish:" => "fish.gif",
  ":mama:" => "mama.gif",
  ":pepsi:" => "pepsi.gif",
  ":medieval:" => "medieval.gif",
  ":rambo:" => "rambo.gif",
  ":ninja:" => "ninja.gif",
  ":hannibal:" => "hannibal.gif",
  ":party:" => "party.gif",
  ":snorkle:" => "snorkle.gif",
  ":evo:" => "evo.gif",
  ":king:" => "king.gif",
  ":chef:" => "chef.gif",
  ":mario:" => "mario.gif",
  ":pope:" => "pope.gif",
  ":fez:" => "fez.gif",
  ":cap:" => "cap.gif",
  ":cowboy:" => "cowboy.gif",
  ":pirate:" => "pirate.gif",
  ":pirate2:" => "pirate2.gif",
  ":rock:" => "rock.gif",
  ":cigar:" => "cigar.gif",
  ":icecream:" => "icecream.gif",
  ":oldtimer:" => "oldtimer.gif",
	":trampoline:" => "trampoline.gif",
	":banana:" => "bananadance.gif",
  ":smurf:" => "smurf.gif",
  ":yikes:" => "yikes.gif",
  ":osama:" => "osama.gif",
  ":saddam:" => "saddam.gif",
  ":santa:" => "santa.gif",
  ":indian:" => "indian.gif",
  ":pimp:" => "pimp.gif",
  ":nuke:" => "nuke.gif",
  ":jacko:" => "jacko.gif",
  ":ike:" => "ike.gif",
  ":greedy:" => "greedy.gif",
	":super:" => "super.gif",
  ":wolverine:" => "wolverine.gif",
  ":spidey:" => "spidey.gif",
  ":spider:" => "spider.gif",
  ":bandana:" => "bandana.gif",
  ":construction:" => "construction.gif",
  ":sheep:" => "sheep.gif",
  ":police:" => "police.gif",
	":detective:" => "detective.gif",
  ":bike:" => "bike.gif",
	":fishing:" => "fishing.gif",
  ":clover:" => "clover.gif",
  ":horse:" => "horse.gif",
  ":shit:" => "shit.gif",
  ":soldiers:" => "soldiers.gif",
);

$privatesmilies = array(
  ":)" => "smile1.gif",
//  ";)" => "wink.gif",
  ":wink:" => "wink.gif",
  ":D" => "grin.gif",
  ":P" => "tongue.gif",
  ":(" => "sad.gif",
  ":'(" => "cry.gif",
  ":|" => "noexpression.gif",
  // "8)" => "cool1.gif",   we don't want this as a smilie...
  ":Boozer:" => "alcoholic.gif",
  ":deadhorse:" => "deadhorse.gif",
  ":spank:" => "spank.gif",
  ":yoji:" => "yoji.gif",
  ":locked:" => "locked.gif",
  ":grrr:" => "angry.gif", 			// legacy
  "O:-" => "innocent.gif",			// legacy
  ":sleeping:" => "sleeping.gif",	// legacy
  "-_-" => "unsure.gif",			// legacy
  ":clown:" => "clown.gif",
  ":mml:" => "mml.gif",
  ":rtf:" => "rtf.gif",
  ":morepics:" => "morepics.gif",
  ":rb:" => "rb.gif",
  ":rblocked:" => "rblocked.gif",
  ":maxlocked:" => "maxlocked.gif",
  ":hslocked:" => "hslocked.gif",
);
$badwords = array("asshole" => "<img src=pic/censored.png>",
"Assshole" => "<img src=pic/censored.png>",
"ASSHOLE" => "<img src=pic/censored.png>",
"Fuck" => "<img src=pic/censored.png>",
"FUCK" => "<img src=pic/censored.png>",
"Cunt" => "<img src=pic/censored.png>",
"CUNT" => "<img src=pic/censored.png>",
"Bastard" => "<img src=pic/censored.png>",
"BASTARD" => "<img src=pic/censored.png>",
"fcuk" => "<img src=pic/censored.png>",
"fook" => "<img src=pic/censored.png>",
"tosser" => "<img src=pic/censored.png>",
"Tosser" => "<img src=pic/censored.png>",
"fcck" => "<img src=pic/censored.png>",
"cnut" => "<img src=pic/censored.png>",
"Bollocks" => "<img src=pic/censored.png>",
"bollocks" => "<img src=pic/censored.png>",
"fucker" => "<img src=pic/censored.png>",
"Fucker" => "<img src=pic/censored.png>",
"Cunty" => "<img src=pic/censored.png>",
"cunty" => "<img src=pic/censored.png>",
"arseholes" => "<img src=pic/censored.png>",
"Arseholes" => "<img src=pic/censored.png>",
"Fuckwit" => "<img src=pic/censored.png>",
"fuckwit" => "<img src=pic/censored.png>",
"Shithead" => "<img src=pic/censored.png>",
"shithead" => "<img src=pic/censored.png>",
"Fuckface" => "<img src=pic/censored.png>",
"Motherfucker" => "<img src=pic/censored.png>",
"motherfucker" => "<img src=pic/censored.png>",
"Cock" => "<img src=pic/censored.png>",
"cock" => "<img src=pic/censored.png>",
"cocksucker" => "<img src=pic/censored.png>",
"shag" => "<img src=pic/censored.png>",
"WHORE" => "<img src=pic/censored.png>",
"dickhead" => "<img src=pic/censored.png>",
"Dickhead" => "<img src=pic/censored.png>",
"prick" => "<img src=pic/censored.png>",
"Prick" => "<img src=pic/censored.png>",
"faggot" => "<img src=pic/censored.png>",
"Faggot" => "<img src=pic/censored.png>",
"Crack" => "<img src=pic/censored.png>",
"Serial" => "<img src=pic/censored.png>",
"Keygen" => "<img src=pic/censored.png>",
"TiT" => "<img src=pic/censored.png>",
"Tit" => "<img src=pic/censored.png>",
"cvnt" => "<img src=pic/censored.png>",
"bar steward" => "<img src=pic/censored.png>",
"piss" => "<img src=pic/censored.png>",
"PISS" => "<img src=pic/censored.png>",
"FANNY" => "<img src=pic/censored.png>",
"Fanny" => "<img src=pic/censored.png>",
"fanny" => "<img src=pic/censored.png>",
"Bitch" => "<img src=pic/censored.png>",
"bitch" => "<img src=pic/censored.png>",
"Arse" => "<img src=pic/censored.png>",
"arse" => "<img src=pic/censored.png>",
"Fuckin" => "<img src=pic/censored.png>",
"fuckin" => "<img src=pic/censored.png>",
"fucking" => "<img src=pic/censored.png>",
"Fucking" => "<img src=pic/censored.png>",
"fuckface" => "<img src=pic/censored.png>",
"knob head" => "<img src=pic/censored.png>",
"fuckhead" => "<img src=pic/censored.png>",
"knob end" => "<img src=pic/censored.png>",
"fuck" => "<img src=pic/censored.png>",
"cunt" => "<img src=pic/censored.png>",
"Twat" => "<img src=pic/censored.png>",
"twat" => "<img src=pic/censored.png>",
"wanker" => "<img src=pic/censored.png>",
"bastard" => "<img src=pic/censored.png>",
"shit" => "<img src=pic/censored.png>",
"fvck" => "<img src=pic/censored.png>",
"Hoe" => "<img src=pic/censored.png>",
"FOOKIN" => "<img src=pic/censored.png>",
"FOOKING" => "<img src=pic/censored.png>",
"FOOK" => "<img src=pic/censored.png>",
"Ass" => "<img src=pic/censored.png>",
"ass wipe" => "<img src=pic/censored.png>",
"ass wipes" =>"<img src=pic/censored.png>",
);
// Set this to the line break character sequence of your system
$linebreak = "\r\n";

function get_row_count($table, $suffix = "")
{
  if ($suffix)
    $suffix = " $suffix";
  ($r = mysql_query("SELECT COUNT(*) FROM $table$suffix")) or die(mysql_error());
  ($a = mysql_fetch_row($r)) or die(mysql_error());
  return $a[0];
}

function stdmsg($heading = '', $text = '', $div = 'success', $htmlstrip = false) {
    if ($htmlstrip) {
        $heading = htmlspecialchars_uni(trim($heading));
        $text = htmlspecialchars_uni(trim($text));
    }
    print("<center><table class=main width=95% border=0 cellpadding=0 cellspacing=0><tr><td class=embedded></center>\n");
    print("<center><table width=95% border=1 cellspacing=0 cellpadding=10><tr><td class=text></center>".($heading ? "<b><h2>$heading</h2></b><br />" : "")."$text</td></tr></table></td></tr></table>\n");
}
function stderr($heading, $text, $htmlstrip = FALSE)
{
  stdhead();
  stdmsg($heading, $text, $htmlstrip);
  stdfoot();
  die;
}

function sqlerr($file = '', $line = '')
{
    global $CURUSER;
    $fp=fopen('sqlerror.log', 'a+');
    $date=date('l dS \of F Y h:i:s A');
    $error= "$date  - ".mysql_error()." in file ".$file.", line ".$line.". User: ".$CURUSER['username']." ID: ".$CURUSER['id'].". IP: ".getip()." [ get ip ] :: ".$_SERVER['REMOTE_ADDR']." [ reported remote address ] \r\n";
    fwrite($fp,$error);
    if (get_user_class() == UC_SYSOP)
       echo'<table border=0 bgcolor=blue align=left cellspacing=0 cellpadding=10 style=\'background: blue\'><tr><td class=embedded><font color=white><h1>SQL Error</h1><b>'.mysql_error() . ($file != '' && $line != '' ? '<p>in '.$file.', line '.$line.'</p>' : '') .'</b></font></td></tr></table>';
    die;
}


// Returns the current time in GMT in MySQL compatible format.
function get_date_time($timestamp = 0)
{
  if ($timestamp)
    return date("Y-m-d H:i:s", $timestamp);
  else
    return gmdate("Y-m-d H:i:s");
}

function encodehtml($s, $linebreaks = true)
{
  $s = str_replace("<", "&lt;", str_replace("&", "&amp;", $s));
  if ($linebreaks)
    $s = nl2br($s);
  return $s;
}

function get_dt_num()
{
  return gmdate("YmdHis");
}

function format_urls($s)
{  return preg_replace(

         "/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^()<>\s]+)/i",
        "\\1<a target=_blank href=\"\\2\">\\2</a>", $s);
}
 function _strlastpos ($haystack, $needle, $offset = 0)
{
	$addLen = strlen ($needle);
	$endPos = $offset - $addLen;
	while (true)
	{
		if (($newPos = strpos ($haystack, $needle, $endPos + $addLen)) === false) break;
		$endPos = $newPos;
	}
	return ($endPos >= 0) ? $endPos : false;
}

function format_quotes($s)
{
  while ($old_s != $s)
  {
  	$old_s = $s;

	  //find first occurrence of [/quote]
	  $close = strpos($s, "[/quote]");
	  if ($close === false)
	  	return $s;

	  //find last [quote] before first [/quote]
	  //note that there is no check for correct syntax
	  $open = _strlastpos(substr($s,0,$close), "[quote");
	  if ($open === false)
	    return $s;

	  $quote = substr($s,$open,$close - $open + 8);

	  //[quote]Text[/quote]
	  $quote = preg_replace(
	    "/\[quote\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i",
	    "<p class=sub><b>Quote:</b></p><table class=\"main\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\"><tr><td style=\"border: 1px black dotted\">\\1</td></tr></table><br />", $quote);

	  //[quote=Author]Text[/quote]
	  $quote = preg_replace(
	    "/\[quote=(.+?)\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i",
	    "<p class=sub><b>\\1 wrote:</b></p><table class=\"main\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\"><tr><td style=\"border: 1px black dotted\">\\2</td></tr></table><br />", $quote);

	  $s = substr($s,0,$open) . $quote . substr($s,$close + 8);
  }

	return $s;
}

// Format quote
function encode_quote($text) {
	$start_html = "<div align=\"center\"><div style=\"width: 85%; overflow: auto\">"
	."<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\" class=\"bgcolor4\">"
	."<tr bgcolor=\"FFE5E0\"><td><font class=\"block-title\">Quote</font></td></tr><tr class=\"bgcolor1\"><td>";
	$end_html = "</td></tr></table></div></div>";
	$text = preg_replace("#\[quote\](.*?)\[/quote\]#si", "".$start_html."\\1".$end_html."", $text);
	return $text;
}

// Format quote from
function encode_quote_from($text) {
	$start_html = "<div align=\"center\"><div style=\"width: 85%; overflow: auto\">"
	."<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\" class=\"bgcolor4\">"
	."<tr bgcolor=\"FFE5E0\"><td><font class=\"block-title\">\\1 Quote</font></td></tr><tr class=\"bgcolor1\"><td>";
	$end_html = "</td></tr></table></div></div>";
	$text = preg_replace("#\[quote=(.+?)\](.*?)\[/quote\]#si", "".$start_html."\\2".$end_html."", $text);
	return $text;
}

// Format code
function encode_code($text) {
	$start_html = "<div align=\"center\"><div style=\"width: 85%; overflow: auto\">"
	."<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\" class=\"bgcolor4\">"
	."<tr bgcolor=\"E5EFFF\"><td colspan=\"2\"><font class=\"block-title\">Code</font></td></tr>"
	."<tr class=\"bgcolor1\"><td align=\"right\" class=\"code\" style=\"width: 5px; border-right: none\">{ZEILEN}</td><td class=\"code\">";
	$end_html = "</td></tr></table></div></div>";
	$match_count = preg_match_all("#\[code\](.*?)\[/code\]#si", $text, $matches);
    for ($mout = 0; $mout < $match_count; ++$mout) {
      $before_replace = $matches[1][$mout];
      $after_replace = $matches[1][$mout];
      $after_replace = trim ($after_replace);
      $zeilen_array = explode ("<br />", $after_replace);
      $j = 1;
      $zeilen = "";
      foreach ($zeilen_array as $str) {
        $zeilen .= "".$j."<br />";
        ++$j;
      }
      $after_replace = str_replace ("", "", $after_replace);
      $after_replace = str_replace ("&amp;", "&", $after_replace);
      $after_replace = str_replace ("", "&nbsp; ", $after_replace);
      $after_replace = str_replace ("", " &nbsp;", $after_replace);
      $after_replace = str_replace ("", "&nbsp; &nbsp;", $after_replace);
      $after_replace = preg_replace ("/^ {1}/m", "&nbsp;", $after_replace);
      $str_to_match = "[code]".$before_replace."[/code]";
      $replace = str_replace ("{ZEILEN}", $zeilen, $start_html);
      $replace .= $after_replace;
      $replace .= $end_html;
      $text = str_replace ($str_to_match, $replace, $text);
    }

    $text = str_replace ("[code]", $start_html, $text);
    $text = str_replace ("[/code]", $end_html, $text);
    return $text;
}

function encode_php($text) {
	$start_html = "<div align=\"center\"><div style=\"width: 85%; overflow: auto\">"
	."<table width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\" class=\"bgcolor4\">"
	."<tr bgcolor=\"F3E8FF\"><td colspan=\"2\"><font class=\"block-title\">PHP - Code</font></td></tr>"
	."<tr class=\"bgcolor1\"><td align=\"right\" class=\"code\" style=\"width: 5px; border-right: none\">{ZEILEN}</td><td>";
	$end_html = "</td></tr></table></div></div>";
	$match_count = preg_match_all("#\[php\](.*?)\[/php\]#si", $text, $matches);
    for ($mout = 0; $mout < $match_count; ++$mout) {
        $before_replace = $matches[1][$mout];
        $after_replace = $matches[1][$mout];
        $after_replace = trim ($after_replace);
		$after_replace = str_replace("&lt;", "<", $after_replace);
		$after_replace = str_replace("&gt;", ">", $after_replace);
		$after_replace = str_replace("&quot;", '"', $after_replace);
		$after_replace = preg_replace("/<br.*/i", "", $after_replace);
		$after_replace = (substr($after_replace, 0, 5 ) != "<?php") ? "<?php\n".$after_replace."" : "".$after_replace."";
		$after_replace = (substr($after_replace, -2 ) != "?>") ? "".$after_replace."\n?>" : "".$after_replace."";
        ob_start ();
        highlight_string ($after_replace);
        $after_replace = ob_get_contents ();
        ob_end_clean ();
		$zeilen_array = explode("<br />", $after_replace);
        $j = 1;
        $zeilen = "";
      foreach ($zeilen_array as $str) {
        $zeilen .= "".$j."<br />";
        ++$j;
      }
		$after_replace = str_replace("\n", "", $after_replace);
		$after_replace = str_replace("&amp;", "&", $after_replace);
		$after_replace = str_replace("  ", "&nbsp; ", $after_replace);
		$after_replace = str_replace("  ", " &nbsp;", $after_replace);
		$after_replace = str_replace("\t", "&nbsp; &nbsp;", $after_replace);
		$after_replace = preg_replace("/^ {1}/m", "&nbsp;", $after_replace);
		$str_to_match = "[php]".$before_replace."[/php]";
		$replace = str_replace("{ZEILEN}", $zeilen, $start_html);
      $replace .= $after_replace;
      $replace .= $end_html;
      $text = str_replace ($str_to_match, $replace, $text);
    }
	$text = str_replace("[php]", $start_html, $text);
	$text = str_replace("[/php]", $end_html, $text);
    return $text;
}

function format_comment($text, $strip_html = true) {
	global $smilies, $privatesmilies;
	$smiliese = $smilies;
	$s = $text;

  // This fixes the extraneous ;) smilies problem. When there was an html escaped
  // char before a closing bracket - like >), "), ... - this would be encoded
  // to &xxx;), hence all the extra smilies. I created a new :wink: label, removed
  // the ;) one, and replace all genuine ;) by :wink: before escaping the body.
  // (What took us so long? :blush:)- wyz

	$s = str_replace(";)", ":wink:", $s);

	if ($strip_html)
		$s = htmlspecialchars_uni($s);

	$bb[] = "#\[img\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#i";
	$html[] = "<img class=\"linked-image\" src=\"\\1\" border=\"0\" alt=\"\\1\" title=\"\\1\" />";
	$bb[] = "#\[img=([a-zA-Z]+)\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img class=\"linked-image\" src=\"\\2\" align=\"\\1\" border=\"0\" alt=\"\\2\" title=\"\\2\" />";
	$bb[] = "#\[img\ alt=([a-zA-Zа-яА-Я0-9\_\-\. ]+)\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img class=\"linked-image\" src=\"\\2\" align=\"\\1\" border=\"0\" alt=\"\\1\" title=\"\\1\" />";
	$bb[] = "#\[img=([a-zA-Z]+) alt=([a-zA-Zа-яА-Я0-9\_\-\. ]+)\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img class=\"linked-image\" src=\"\\3\" align=\"\\1\" border=\"0\" alt=\"\\2\" title=\"\\2\" />";
	$bb[] = "#\[url\]([\w]+?://([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
	$html[] = "<a href=\"\\1\" title=\"\\1\">\\1</a>";
	$bb[] = "#\[url\]((www|ftp)\.([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
	$html[] = "<a href=\"http://\\1\" title=\"\\1\">\\1</a>";
	$bb[] = "#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
	$html[] = "<a href=\"\\1\" title=\"\\1\">\\2</a>";
	$bb[] = "#\[url=((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
	$html[] = "<a href=\"http://\\1\" title=\"\\1\">\\3</a>";
	$bb[] = "/\[url=([^()<>\s]+?)\]((\s|.)+?)\[\/url\]/i";
	$html[] = "<a href=\"\\1\">\\2</a>";
	$bb[] = "/\[url\]([^()<>\s]+?)\[\/url\]/i";
	$html[] = "<a href=\"\\1\">\\1</a>";
	$bb[] = "#\[mail\](\S+?)\[/mail\]#i";
	$html[] = "<a href=\"mailto:\\1\">\\1</a>";
	$bb[] = "#\[mail\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/mail\]#i";
	$html[] = "<a href=\"mailto:\\1\">\\2</a>";
	$bb[] = "#\[color=(\#[0-9A-F]{6}|[a-z]+)\](.*?)\[/color\]#si";
	$html[] = "<span style=\"color: \\1\">\\2</span>";
	$bb[] = "#\[(font|family)=([A-Za-z ]+)\](.*?)\[/\\1\]#si";
	$html[] = "<span style=\"font-family: \\2\">\\3</span>";
	$bb[] = "#\[size=([0-9]+)\](.*?)\[/size\]#si";
	$html[] = "<span style=\"font-size: \\1\">\\2</span>";
	$bb[] = "#\[(left|right|center|justify)\](.*?)\[/\\1\]#is";
	$html[] = "<div align=\"\\1\">\\2</div>";
	$bb[] = "#\[b\](.*?)\[/b\]#si";
	$html[] = "<b>\\1</b>";
	$bb[] = "#\[i\](.*?)\[/i\]#si";
	$html[] = "<i>\\1</i>";
	$bb[] = "#\[u\](.*?)\[/u\]#si";
	$html[] = "<u>\\1</u>";
	$bb[] = "#\[s\](.*?)\[/s\]#si";
	$html[] = "<s>\\1</s>";
	$bb[] = "#\[li\]#si";
	$html[] = "<li>";
	$bb[] = "#\[hr\]#si";
	$html[] = "<hr>";

	$s = preg_replace($bb, $html, $s);

	// Linebreaks
	$s = nl2br($s);

	if (preg_match("#\[quote\](.*?)\[/quote\]#si", $s)) $s = encode_quote($s);
	if (preg_match("#\[quote=(.+?)\](.*?)\[/quote\]#si", $s)) {
		$s = encode_quote_from($s);
	}
	if (preg_match("#\[code\](.*?)\[/code\]#si", $s)) $s = encode_code($s);
	if (preg_match("#\[php\](.*?)\[/php\]#si", $s)) $s = encode_php($s);
    while (preg_match("#\[spoiler=((\s|.)+?)\]((\s|.)+?)\[/spoiler\]#is", $s))
{
        $q = time().mt_rand(1, 1024);
        $s = preg_replace("/\[spoiler=((\s|.)+?)\]((\s|.)+?)\[\/spoiler\]/i", "<div class=\"spoiler_head\" onclick=\"javascript:showspoiler('".$q."')\"><img border=\"0\" src=\"pic/plus.gif\" id=\"pic".$q."\" title=\"To show\">&nbsp;&nbsp;\\1</div><div class=\"spoiler_body\" style=\"display:none;\" id=".$q." name=".$q.">\\3</div>", $s, 1);
}
	// URLs
	$s = format_urls($s);
	//$s = format_local_urls($s);

	// Maintain spacing
	//$s = str_replace("  ", " &nbsp;", $s);

	foreach ($smiliese as $code => $url)
		$s = str_replace($code, "<img border=\"0\" src=\"pic/smilies/$url\" alt=\"" . htmlspecialchars_uni($code) . "\">", $s);

	foreach ($privatesmilies as $code => $url)
		$s = str_replace($code, "<img border=\"0\" src=\"pic/smilies/$url\">", $s);

	return $s;
}

define (UC_PEASANT, 0);
define (UC_USER, 1);
define (UC_POWER_USER, 2);
define (UC_VIP, 3);
define (UC_UPLOADER, 4);
define (UC_MODERATOR, 5);
define (UC_ADMINISTRATOR, 6);
define (UC_SYSOP, 7);

function get_user_class()
{
  global $CURUSER;
  return $CURUSER["class"];
}

function get_user_class_name($class)
{
  switch ($class)
  {
    case UC_PEASANT: return "Peasant";

    case UC_USER: return "User";

    case UC_POWER_USER: return "Power User";





    case UC_VIP: return "VIP";

    case UC_UPLOADER: return "Uploader";

    case UC_MODERATOR: return "Moderator";

    case UC_ADMINISTRATOR: return "Administrator";


    case UC_SYSOP: return "Sysop";
  }
  return "";
}

function is_valid_user_class($class)
{
  return is_numeric($class) && floor($class) == $class && $class >= UC_PEASANT && $class <= UC_SYSOP;
}

function is_valid_id($id)
{
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}

function textbbcode($form, $name, $content="") {
?>
<script type="text/javascript" language="JavaScript">
function RowsTextarea(n, w) {
	var inrows = document.getElementById(n);
	if (w < 1) {
		var rows = -5;
	} else {
		var rows = +5;
	}
	var outrows = inrows.rows + rows;
	if (outrows >= 5 && outrows < 50) {
		inrows.rows = outrows;
	}
	return false;
}

var SelField = document.<?=$form;?>.<?=$name;?>;
var TxtFeld  = document.<?=$form;?>.<?=$name;?>;

var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));

var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

function StoreCaret(text) {
	if (text.createTextRange) {
		text.caretPos = document.selection.createRange().duplicate();
	}
}
function FieldName(text, which) {
	if (text.createTextRange) {
		text.caretPos = document.selection.createRange().duplicate();
	}
	if (which != "") {
		var Field = eval("document.<?=$form;?>."+which);
		SelField = Field;
		TxtFeld  = Field;
	}
}
function AddSmile(SmileCode) {
	var SmileCode;
	var newPost;
	var oldPost = SelField.value;
	newPost = oldPost+SmileCode;
	SelField.value=newPost;
	SelField.focus();
	return;
}
function AddSelectedText(Open, Close) {
	if (SelField.createTextRange && SelField.caretPos && Close == '\n') {
		var caretPos = SelField.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? Open + Close + ' ' : Open + Close;
		SelField.focus();
	} else if (SelField.caretPos) {
		SelField.caretPos.text = Open + SelField.caretPos.text + Close;
	} else {
		SelField.value += Open + Close;
		SelField.focus();
	}
}
function InsertCode(code, info, type, error) {
	if (code == 'name') {
		AddSelectedText('[b]' + info + '[/b]', '\n');
	} else if (code == 'url' || code == 'mail') {
		if (code == 'url') var url = prompt(info, 'http://');
		if (code == 'mail') var url = prompt(info, '');
		if (!url) return alert(error);
		if ((clientVer >= 4) && is_ie && is_win) {
			selection = document.selection.createRange().text;
			if (!selection) {
				var title = prompt(type, type);
				AddSelectedText('[' + code + '=' + url + ']' + title + '[/' + code + ']', '\n');
			} else {
				AddSelectedText('[' + code + '=' + url + ']', '[/' + code + ']');
			}
		} else {
			mozWrap(TxtFeld, '[' + code + '=' + url + ']', '[/' + code + ']');
		}
	} else if (code == 'color' || code == 'family' || code == 'size') {
		if ((clientVer >= 4) && is_ie && is_win) {
			AddSelectedText('[' + code + '=' + info + ']', '[/' + code + ']');
		} else if (TxtFeld.selectionEnd && (TxtFeld.selectionEnd - TxtFeld.selectionStart > 0)) {
			mozWrap(TxtFeld, '[' + code + '=' + info + ']', '[/' + code + ']');
		}
	} else if (code == 'li' || code == 'hr') {
		if ((clientVer >= 4) && is_ie && is_win) {
			AddSelectedText('[' + code + ']', '');
		} else {
			mozWrap(TxtFeld, '[' + code + ']', '');
		}
		} else if (code == 'spoiler') {
        var text = prompt(info, '');
        var header = prompt(type, '');
        if (!header)
            header = 'The latent information';
        AddSelectedText('[' + code + '=' + header + ']' + text,'[/' + code + ']');
	} else {
		if ((clientVer >= 4) && is_ie && is_win) {
			var selection = false;
			selection = document.selection.createRange().text;
			if (selection && code == 'quote') {
				AddSelectedText('[' + code + ']' + selection + '[/' + code + ']', '\n');
			} else {
				AddSelectedText('[' + code + ']', '[/' + code + ']');
			}
		} else {
			mozWrap(TxtFeld, '[' + code + ']', '[/' + code + ']');
		}
	}
}

function mozWrap(txtarea, open, close)
{
        var selLength = txtarea.textLength;
        var selStart = txtarea.selectionStart;
        var selEnd = txtarea.selectionEnd;
        if (selEnd == 1 || selEnd == 2)
                selEnd = selLength;

        var s1 = (txtarea.value).substring(0,selStart);
        var s2 = (txtarea.value).substring(selStart, selEnd)
        var s3 = (txtarea.value).substring(selEnd, selLength);
        txtarea.value = s1 + open + s2 + close + s3;
        txtarea.focus();
        return;
}

language=1;
richtung=1;
var DOM = document.getElementById ? 1 : 0,
opera = window.opera && DOM ? 1 : 0,
IE = !opera && document.all ? 1 : 0,
NN6 = DOM && !IE && !opera ? 1 : 0;
var ablauf = new Date();
var jahr = ablauf.getTime() + (365 * 24 * 60 * 60 * 1000);
ablauf.setTime(jahr);
var richtung=1;
var isChat=false;
NoHtml=true;
NoScript=true;
NoStyle=true;
NoBBCode=true;
NoBefehl=false;

function setZustand() {
	transHtmlPause=false;
	transScriptPause=false;
	transStylePause=false;
	transBefehlPause=false;
	transBBPause=false;
}
setZustand();
function keks(Name,Wert){
	document.cookie = Name+"="+Wert+"; expires=" + ablauf.toGMTString();
}
function changeNoTranslit(Nr){
	if(document.trans.No_translit_HTML.checked)NoHtml=true;else{NoHtml=false}
	if(document.trans.No_translit_BBCode.checked)NoBBCode=true;else{NoBBCode=false}
	keks("NoHtml",NoHtml);keks("NoScript",NoScript);keks("NoStyle",NoStyle);keks("NoBBCode",NoBBCode);
}
function changeRichtung(r){
	richtung=r;keks("TransRichtung",richtung);setFocus()
}
function changelanguage(){
	if (language==1) {language=0;}
	else {language=1;}
	keks("autoTrans",language);
	setFocus();
	setZustand();
}
function setFocus(){
	TxtFeld.focus();
}
function repl(t,a,b){
	var w=t,i=0,n=0;
	while((i=w.indexOf(a,n))>=0){
		t=t.substring(0,i)+b+t.substring(i+a.length,t.length);
		w=w.substring(0,i)+b+w.substring(i+a.length,w.length);
		n=i+b.length;
		if(n>=w.length){
			break;
		}
	}
	return t;
}
var rus_lr2 = ('Е-е-О-о-Ё-Ё-Ё-Ё-Ж-Ж-Ч-Ч-Ш-Ш-Щ-Щ-Ъ-Ь-Э-Э-Ю-Ю-Я-Я-Я-Я-ё-ё-ж-ч-ш-щ-э-ю-я-я').split('-');
var lat_lr2 = ('/E-/e-/O-/o-ЫO-Ыo-ЙO-Йo-ЗH-Зh-ЦH-Цh-СH-Сh-ШH-Шh-ъ'+String.fromCharCode(35)+'-ь'+String.fromCharCode(39)+'-ЙE-Йe-ЙU-Йu-ЙA-Йa-ЫA-Ыa-ыo-йo-зh-цh-сh-шh-йe-йu-йa-ыa').split('-');
var rus_lr1 = ('А-Б-В-Г-Д-Е-З-И-Й-К-Л-М-Н-О-П-Р-С-Т-У-Ф-Х-Х-Ц-Щ-Ы-Я-а-б-в-г-д-е-з-и-й-к-л-м-н-о-п-р-с-т-у-ф-х-х-ц-щ-ъ-ы-ь-я').split('-');
var lat_lr1 = ('A-B-V-G-D-E-Z-I-J-K-L-M-N-O-P-R-S-T-U-F-H-X-C-W-Y-Q-a-b-v-g-d-e-z-i-j-k-l-m-n-o-p-r-s-t-u-f-h-x-c-w-'+String.fromCharCode(35)+'-y-'+String.fromCharCode(39)+'-q').split('-');
var rus_rl = ('А-Б-В-Г-Д-Е-Ё-Ж-З-И-Й-К-Л-М-Н-О-П-Р-С-Т-У-Ф-Х-Ц-Ч-Ш-Щ-Ъ-Ы-Ь-Э-Ю-Я-а-б-в-г-д-е-ё-ж-з-и-й-к-л-м-н-о-п-р-с-т-у-ф-х-ц-ч-ш-щ-ъ-ы-ь-э-ю-я').split('-');
var lat_rl = ('A-B-V-G-D-E-JO-ZH-Z-I-J-K-L-M-N-O-P-R-S-T-U-F-H-C-CH-SH-SHH-'+String.fromCharCode(35)+String.fromCharCode(35)+'-Y-'+String.fromCharCode(39)+String.fromCharCode(39)+'-JE-JU-JA-a-b-v-g-d-e-jo-zh-z-i-j-k-l-m-n-o-p-r-s-t-u-f-h-c-ch-sh-shh-'+String.fromCharCode(35)+'-y-'+String.fromCharCode(39)+'-je-ju-ja').split('-');
var transAN=true;
function transliteText(txt){
	vorTxt=txt.length>1?txt.substr(txt.length-2,1):"";
	buchstabe=txt.substr(txt.length-1,1);
	txt=txt.substr(0,txt.length-2);
	return txt+translitBuchstabeCyr(vorTxt,buchstabe);
}
function translitBuchstabeCyr(vorTxt,txt){
	var zweiBuchstaben = vorTxt+txt;
	var code = txt.charCodeAt(0);

	if (txt=="<")transHtmlPause=true;else if(txt==">")transHtmlPause=false;
	if (txt=="<script")transScriptPause=true;else if(txt=="<"+"/script>")transScriptPause=false;
	if (txt=="<style")transStylePause=true;else if(txt=="<"+"/style>")transStylePause=false;
	if (txt=="[")transBBPause=true;else if(txt=="]")transBBPause=false;
	if (txt=="/")transBefehlPause=true;else if(txt==" ")transBefehlPause=false;

	if (
		(transHtmlPause==true &&   NoHtml==true)||
		(transScriptPause==true &&   NoScript==true)||
		(transStylePause==true &&   NoStyle==true)||
		(transBBPause==true &&   NoBBCode==true)||
		(transBefehlPause==true &&   NoBefehl==true)||

		!(((code>=65) && (code<=123))||(code==35)||(code==39))) return zweiBuchstaben;

	for (x=0; x<lat_lr2.length; x++){
		if (lat_lr2[x]==zweiBuchstaben) return rus_lr2[x];
	}
	for (x=0; x<lat_lr1.length; x++){
		if (lat_lr1[x]==txt) return vorTxt+rus_lr1[x];
	}
	return zweiBuchstaben;
}
function translitBuchstabeLat(buchstabe){
	for (x=0; x<rus_rl.length; x++){
		if (rus_rl[x]==buchstabe)
		return lat_rl[x];
	}
	return buchstabe;
}
function translateAlltoLatin(){
	if (!IE){
		var txt=TxtFeld.value;
		var txtnew = "";
		var symb = "";
		for (y=0;y<txt.length;y++){
			symb = translitBuchstabeLat(txt.substr(y,1));
			txtnew += symb;
		}
		TxtFeld.value = txtnew;
		setFocus()
	} else {
		var is_selection_flag = 1;
		var userselection = document.selection.createRange();
		var txt = userselection.text;

		if (userselection==null || userselection.text==null || userselection.parentElement==null || userselection.parentElement().type!="textarea"){
			is_selection_flag = 0;
			txt = TxtFeld.value;
		}
		txtnew="";
		var symb = "";
		for (y=0;y<txt.length;y++){
			symb = translitBuchstabeLat(txt.substr(y,1));
			txtnew +=  symb;
		}
		if (is_selection_flag){
			userselection.text = txtnew; userselection.collapse(); userselection.select();
		}else{
			TxtFeld.value = txtnew;
			setFocus()
		}
	}
	return;
}
function TransliteFeld(object, evnt){
	if (language==1 || opera) return;
	if (NN6){
		var code=void 0;
		var code =  evnt.charCode;
		var textareafontsize = 14;
		var textreafontwidth = 7;
		if(code == 13){
			return;
		}
		if ( code && (!(evnt.ctrlKey || evnt.altKey))){
			pXpix = object.scrollTop;
			pYpix = object.scrollLeft;
        	evnt.preventDefault();
			txt=String.fromCharCode(code);
			pretxt = object.value.substring(0, object.selectionStart);
			result = transliteText(pretxt+txt);
			object.value = result+object.value.substring(object.selectionEnd);
			object.setSelectionRange(result.length,result.length);
			object.scrollTop=100000;
			object.scrollLeft=0;

			cXpix = (result.split("\n").length)*(textareafontsize+3);
			cYpix = (result.length-result.lastIndexOf("\n")-1)*(textreafontwidth+1);
			taXpix = (object.rows+1)*(textareafontsize+3);
			taYpix = object.clientWidth;

			if ((cXpix>pXpix)&&(cXpix<(pXpix+taXpix))) object.scrollTop=pXpix;
			if (cXpix<=pXpix) object.scrollTop=cXpix-(textareafontsize+3);
			if (cXpix>=(pXpix+taXpix)) object.scrollTop=cXpix-taXpix;

			if ((cYpix>=pYpix)&&(cYpix<(pYpix+taYpix))) object.scrollLeft=pYpix;
			if (cYpix<pYpix) object.scrollLeft=cYpix-(textreafontwidth+1);
			if (cYpix>=(pYpix+taYpix)) object.scrollLeft=cYpix-taYpix+1;
		}
		return true;
	} else if (IE){
		if (isChat){
			var code = frames['input'].event.keyCode;
			if(code == 13){
				return;
			}
			txt=String.fromCharCode(code);
			cursor_pos_selection = frames['input'].document.selection.createRange();
			cursor_pos_selection.text="";
			cursor_pos_selection.moveStart("character",-1);
			vorTxt = cursor_pos_selection.text;
			if (vorTxt.length>1){
				vorTxt="";
			}
			frames['input'].event.keyCode = 0;
			if (richtung==2){
				result = vorTxt+translitBuchstabeLat(txt)
			}else{
				result = translitBuchstabeCyr(vorTxt,txt)
			}
			if (vorTxt!=""){
				cursor_pos_selection.select(); cursor_pos_selection.collapse();
			}
			with(frames['input'].document.selection.createRange()){
				text = result; collapse(); select()
			}
		} else {
			var code = event.keyCode;
			if(code == 13){
				return;
			}
			txt=String.fromCharCode(code);
			cursor_pos_selection = document.selection.createRange();
			cursor_pos_selection.text="";
			cursor_pos_selection.moveStart("character",-1);
			vorTxt = cursor_pos_selection.text;
			if (vorTxt.length>1){
				vorTxt="";
			}
			event.keyCode = 0;
			if (richtung==2){
				result = vorTxt+translitBuchstabeLat(txt)
			}else{
				result = translitBuchstabeCyr(vorTxt,txt)
			}
			if (vorTxt!=""){
				cursor_pos_selection.select(); cursor_pos_selection.collapse();
			}
			with(document.selection.createRange()){
				text = result; collapse(); select()
			}
		}
		return;
   }
}
function translateAlltoCyrillic(){
	if (!IE){
		txt = TxtFeld.value;
		var txtnew = translitBuchstabeCyr("",txt.substr(0,1));
		var symb = "";
		for (kk=1;kk<txt.length;kk++){
			symb = translitBuchstabeCyr(txtnew.substr(txtnew.length-1,1),txt.substr(kk,1));
			txtnew = txtnew.substr(0,txtnew.length-1) + symb;
		}
		TxtFeld.value = txtnew;
		setFocus()
	}else{
		var is_selection_flag = 1;
		var userselection = document.selection.createRange();
		var txt = userselection.text;
		if (userselection==null || userselection.text==null || userselection.parentElement==null || userselection.parentElement().type!="textarea"){
			is_selection_flag = 0;
			txt = TxtFeld.value;
		}
		var txtnew = translitBuchstabeCyr("",txt.substr(0,1));
		var symb = "";
		for (kk=1;kk<txt.length;kk++){
			symb = translitBuchstabeCyr(txtnew.substr(txtnew.length-1,1),txt.substr(kk,1));
			txtnew = txtnew.substr(0,txtnew.length-1) + symb;
		}
		if (is_selection_flag){
			userselection.text = txtnew; userselection.collapse(); userselection.select();
		}else{
			TxtFeld.value = txtnew;
			setFocus()
		}
	}
	return;
}
</script>
<textarea class="editorinput" id="area" name="<?=$name;?>" cols="65" rows="10" style="width:600px" OnKeyPress="TransliteFeld(this, event)" OnSelect="FieldName(this, this.name)" OnClick="FieldName(this, this.name)" OnKeyUp="FieldName(this, this.name)"><?=$content;?></textarea>
<div class="editor" style="background-image: url(editor/bg.gif); background-repeat: repeat-x;">
	<div class="editorbutton" OnClick="RowsTextarea('area',1)"><img title="Zoom-in" src="editor/plus.gif"></div>
	<div class="editorbutton" OnClick="RowsTextarea('area',0)"><img title="Zoom-out" src="editor/minus.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('b')"><img title="Bold" src="editor/bold.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('i')"><img title="Italic" src="editor/italic.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('u')"><img title="Underline" src="editor/underline.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('s')"><img title="Striket" src="editor/striket.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('li')"><img title="Marked list" src="editor/li.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('hr')"><img title="Separation line" src="editor/hr.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('left')"><img title="Alignment to left" src="editor/left.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('center')"><img title="Alignment on center" src="editor/center.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('right')"><img title="Alignment to right" src="editor/right.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('justify')"><img title="Full-width" src="editor/justify.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('code')"><img title="Code" src="editor/code.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('php')"><img title="PHP-code" src="editor/php.gif"></div>
     <div class="editorbutton" OnClick="InsertCode('spoiler','Enter the maintenance','Enter heading','You have not specified the maintenance!')"><img title="The latent contents" src="editor/hide.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('url','Enter full adress','Enter description','You have not specified address!')"><img title="Insert Link" src="editor/url.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('mail','Enter full adress','Enter description','You have not specified the address!')"><img title="Insert E-Mail" src="editor/mail.gif"></div>
	<div class="editorbutton" OnClick="InsertCode('img')"><img title="Вставить картинку" src="editor/img.gif"></div>
</div>
<div class="editor" style="background-image: url(editor/bg.gif); background-repeat: repeat-x;">
	<div class="editorbutton" OnClick="InsertCode('quote')"><img title="Quote" src="editor/quote.gif"></div>
	<div class="editorbutton" OnClick="translateAlltoCyrillic()"><img title="Text translation from Latin in cyrillics" src="editor/rus.gif"></div>
	<div class="editorbutton" OnClick="translateAlltoLatin()"><img title="Text translation from cyrillics in Latin" src="editor/eng.gif"></div>
	<div class="editorbutton" OnClick="changelanguage()"><img title="Machine translation of the text" src="editor/auto.gif"></div>
	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;" name="family" onChange="InsertCode('family',this.options[this.selectedIndex].value)"><option style="font-family:Verdana;" value="Verdana">Verdana</option><option style="font-family:Arial;" value="Arial">Arial</option><option style="font-family:'Courier New';" value="Courier New">Courier New</option><option style="font-family:Tahoma;" value="Tahoma">Tahoma</option><option style="font-family:Helvetica;" value="Helvetica">Helvetica</option></select></div>
	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;" name="color" onChange="InsertCode('color',this.options[this.selectedIndex].value)"><option style="color:black;" value="black">Font Color</option><option style="color:silver;" value="silver">Font Color</option><option style="color:gray;" value="gray">Font Color</option><option style="color:white;" value="white">Font Color</option><option style="color:maroon;" value="maroon">Font Color</option><option style="color:red;" value="red">Font Color</option><option style="color:purple;" value="purple">Font Color</option><option style="color:fuchsia;" value="fuchsia">Font Color</option><option style="color:green;" value="green">Font Color</option><option style="color:lime;" value="lime">Font Color</option><option style="color:olive;" value="olive">Font Color</option><option style="color:yellow;" value="yellow">Font Color</option><option style="color:navy;" value="navy">Font Color</option><option style="color:blue;" value="blue">Font Color</option><option style="color:teal;" value="teal">Font Color</option><option style="color:aqua;" value="aqua">Font Color</option></select></div>
	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;" name="size" onChange="InsertCode('size',this.options[this.selectedIndex].value)"><option value="8">Size 8</option><option value="10">Size 10</option><option value="12">Size 12</option><option value="14">Size 14</option><option value="18">Size 18</option><option value="24">Size 24</option></select></div>
</div>
<?
}
  //-------- Begins a main frame

  function begin_main_frame()
  {
    print("<center><table width=90% class=main border=0 cellspacing=0 cellpadding=0>" .
      "<tr><td class=embedded>\n");
  }

  //-------- Ends a main frame

  function end_main_frame()
  {
    print("</td></tr></table>\n");
  }

  function begin_frame($caption = "", $center = false, $padding = 10)
  {
    if ($caption)
      print("<h2>$caption</h2>\n");

    if ($center)
      $tdextra .= " align=center";

    print("<table width=100% border=1 cellspacing=0 cellpadding=$padding><tr><td$tdextra>\n");

  }

  function attach_frame($padding = 10)
  {
    print("</td></tr><tr><td style='border-top: 0px'>\n");
  }

  function end_frame()
  {
    print("</td></tr></table>\n");
  }

  function begin_table($fullwidth = false, $padding = 5)
  {
    if ($fullwidth)
      $width = " width=100%";
    print("<table class=main$width border=1 cellspacing=0 cellpadding=$padding>\n");
  }

  function end_table()
  {
    print("</td></tr></table>\n");
  }

  //-------- Inserts a smilies frame
  //         (move to globals)


  function insert_smilies_frame()
  {
    global $smilies, $BASEURL;

    begin_frame("Smilies", true);

    begin_table(false, 5);

    print("<tr><td class=colhead>Type...</td><td class=colhead>To make a...</td></tr>\n");

    while (list($code, $url) = each($smilies))
      print("<tr><td>$code</td><td><img src=$BASEURL/pic/smilies/$url></td>\n");

    end_table();

    end_frame();
  }


function sql_timestamp_to_unix_timestamp($s)
{
  return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));
}

  function get_ratio_color($ratio)
  {
    if ($ratio < 0.1) return "#ff0000";
    if ($ratio < 0.2) return "#ee0000";
    if ($ratio < 0.3) return "#dd0000";
    if ($ratio < 0.4) return "#cc0000";
    if ($ratio < 0.5) return "#bb0000";
    if ($ratio < 0.6) return "#aa0000";
    if ($ratio < 0.7) return "#990000";
    if ($ratio < 0.8) return "#880000";
    if ($ratio < 0.9) return "#770000";
    if ($ratio < 1) return "#660000";
    return "#000000";
  }

  function get_slr_color($ratio)
  {
    if ($ratio < 0.025) return "#ff0000";
    if ($ratio < 0.05) return "#ee0000";
    if ($ratio < 0.075) return "#dd0000";
    if ($ratio < 0.1) return "#cc0000";
    if ($ratio < 0.125) return "#bb0000";
    if ($ratio < 0.15) return "#aa0000";
    if ($ratio < 0.175) return "#990000";
    if ($ratio < 0.2) return "#880000";
    if ($ratio < 0.225) return "#770000";
    if ($ratio < 0.25) return "#660000";
    if ($ratio < 0.275) return "#550000";
    if ($ratio < 0.3) return "#440000";
    if ($ratio < 0.325) return "#330000";
    if ($ratio < 0.35) return "#220000";
    if ($ratio < 0.375) return "#110000";
    return "#000000";
  }

function write_log($text)
{
  $text = sqlesc($text);
  $added = sqlesc(get_date_time());
  mysql_query("INSERT INTO sitelog (added, txt) VALUES($added, $text)") or sqlerr(__FILE__, __LINE__);
}

function get_elapsed_time($ts)
{
  $mins = floor((gmtime() - $ts) / 60);
  $hours = floor($mins / 60);
  $mins -= $hours * 60;
  $days = floor($hours / 24);
  $hours -= $days * 24;
  $weeks = floor($days / 7);
  $days -= $weeks * 7;
  $t = "";
  if ($weeks > 0)
    return "$weeks week" . ($weeks > 1 ? "s" : "");
  if ($days > 0)
    return "$days day" . ($days > 1 ? "s" : "");
  if ($hours > 0)
    return "$hours hour" . ($hours > 1 ? "s" : "");
  if ($mins > 0)
    return "$mins min" . ($mins > 1 ? "s" : "");
  return "< 1 min";
}
function user_key_codes($key)
{
    return "/\[$key\]/i";
}

function dynamic_user_vars($text)
{
    global $CURUSER;
    // $zone = 0;        // GMT
    $zone = 3600*-5;    // EST
    $tim = time() + $zone;

    $cu=$CURUSER;
    // unset any variables ya dun want to display, or can't display
    unset($cu['old_password'],$cu['secret'],$cu['editsecret'],$cu['modcomment']);
    $bbkeys=array_keys($cu);
    $bbkeys[]='curdate';
    $bbkeys[]='curtime';
    $bbvals=array_values($cu);
    $bbvals[]=gmdate('F jS, Y',$tim);
    $bbvals[]=gmdate('g:i A',$tim);
    $bbkeys=array_map('user_key_codes',$bbkeys);
    return preg_replace($bbkeys,$bbvals,$text);
}
function begin_frame2($caption = "", $center = false, $width = "100%")
{
    if ($center)
        $tdextra .= " style=\"text-align: center\"";

    ?><table cellpadding="4" cellspacing="1" border="0" style="width:<?=$width?>" class="tableinborder">
 <tr>
  <td class="tabletitle" colspan="10" width="100%" style="text-align: center"><b><?=$caption?></b></td>
 </tr><tr><td width="100%" class="tablea"<?=$tdextra?>>
<?php
}
function begin_table2($fullwidth = false, $padding = 4)
{
    if ($fullwidth)
        $width = " width=\"100%\"";
    print("<table class=\"tableinborder\" $width border=\"0\" cellspacing=\"1\" cellpadding=\"$padding\">\n");
}
?>