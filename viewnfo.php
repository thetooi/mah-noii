<?

// code: Takes a string and does a IBM-437-to-HTML-Unicode-Entities-conversion.
// swedishmagic specifies special behavior for Swedish characters.
// Some Swedish Latin-1 letters collide with popular DOS glyphs. If these
// characters are between ASCII-characters (a-zA-Z and more) they are
// treated like the Swedish letters, otherwise like the DOS glyphs.
function code($ibm_437, $swedishmagic = false) {
$table437 = array("\200", "\201", "\202", "\203", "\204", "\205", "\206", "\207",
"\210", "\211", "\212", "\213", "\214", "\215", "\216", "\217", "\220",
"\221", "\222", "\223", "\224", "\225", "\226", "\227", "\230", "\231",
"\232", "\233", "\234", "\235", "\236", "\237", "\240", "\241", "\242",
"\243", "\244", "\245", "\246", "\247", "\250", "\251", "\252", "\253",
"\254", "\255", "\256", "\257", "\260", "\261", "\262", "\263", "\264",
"\265", "\266", "\267", "\270", "\271", "\272", "\273", "\274", "\275",
"\276", "\277", "\300", "\301", "\302", "\303", "\304", "\305", "\306",
"\307", "\310", "\311", "\312", "\313", "\314", "\315", "\316", "\317",
"\320", "\321", "\322", "\323", "\324", "\325", "\326", "\327", "\330",
"\331", "\332", "\333", "\334", "\335", "\336", "\337", "\340", "\341",
"\342", "\343", "\344", "\345", "\346", "\347", "\350", "\351", "\352",
"\353", "\354", "\355", "\356", "\357", "\360", "\361", "\362", "\363",
"\364", "\365", "\366", "\367", "\370", "\371", "\372", "\373", "\374",
"\375", "\376", "\377");

$tablehtml = array("&#x00c7;", "&#x00fc;", "&#x00e9;", "&#x00e2;", "&#x00e4;",
"&#x00e0;", "&#x00e5;", "&#x00e7;", "&#x00ea;", "&#x00eb;", "&#x00e8;",
"&#x00ef;", "&#x00ee;", "&#x00ec;", "&#x00c4;", "&#x00c5;", "&#x00c9;",
"&#x00e6;", "&#x00c6;", "&#x00f4;", "&#x00f6;", "&#x00f2;", "&#x00fb;",
"&#x00f9;", "&#x00ff;", "&#x00d6;", "&#x00dc;", "&#x00a2;", "&#x00a3;",
"&#x00a5;", "&#x20a7;", "&#x0192;", "&#x00e1;", "&#x00ed;", "&#x00f3;",
"&#x00fa;", "&#x00f1;", "&#x00d1;", "&#x00aa;", "&#x00ba;", "&#x00bf;",
"&#x2310;", "&#x00ac;", "&#x00bd;", "&#x00bc;", "&#x00a1;", "&#x00ab;",
"&#x00bb;", "&#x2591;", "&#x2592;", "&#x2593;", "&#x2502;", "&#x2524;",
"&#x2561;", "&#x2562;", "&#x2556;", "&#x2555;", "&#x2563;", "&#x2551;",
"&#x2557;", "&#x255d;", "&#x255c;", "&#x255b;", "&#x2510;", "&#x2514;",
"&#x2534;", "&#x252c;", "&#x251c;", "&#x2500;", "&#x253c;", "&#x255e;",
"&#x255f;", "&#x255a;", "&#x2554;", "&#x2569;", "&#x2566;", "&#x2560;",
"&#x2550;", "&#x256c;", "&#x2567;", "&#x2568;", "&#x2564;", "&#x2565;",
"&#x2559;", "&#x2558;", "&#x2552;", "&#x2553;", "&#x256b;", "&#x256a;",
"&#x2518;", "&#x250c;", "&#x2588;", "&#x2584;", "&#x258c;", "&#x2590;",
"&#x2580;", "&#x03b1;", "&#x00df;", "&#x0393;", "&#x03c0;", "&#x03a3;",
"&#x03c3;", "&#x03bc;", "&#x03c4;", "&#x03a6;", "&#x0398;", "&#x03a9;",
"&#x03b4;", "&#x221e;", "&#x03c6;", "&#x03b5;", "&#x2229;", "&#x2261;",
"&#x00b1;", "&#x2265;", "&#x2264;", "&#x2320;", "&#x2321;", "&#x00f7;",
"&#x2248;", "&#x00b0;", "&#x2219;", "&#x00b7;", "&#x221a;", "&#x207f;",
"&#x00b2;", "&#x25a0;", "&#x00a0;");
$s = htmlspecialchars($ibm_437);


// 0-9, 11-12, 14-31, 127 (decimalt)
$control =
array("\000", "\001", "\002", "\003", "\004", "\005", "\006", "\007",
"\010", "\011", /*"\012",*/ "\013", "\014", /*"\015",*/ "\016", "\017",
"\020", "\021", "\022", "\023", "\024", "\025", "\026", "\027",
"\030", "\031", "\032", "\033", "\034", "\035", "\036", "\037",
"\177");

/* Code control characters to control pictures.
http://www.unicode.org/charts/PDF/U2400.pdf
(This is somewhat the Right Thing, but looks crappy with Courier New.)
$controlpict = array("&#x2423;","&#x2404;");
$s = str_replace($control,$controlpict,$s); */

// replace control chars with space - feel free to fix the regexp :)
/*echo "[a\\x00-\\x1F]";
//$s = ereg_replace("[ \\x00-\\x1F]", " ", $s);
$s = ereg_replace("[ \000-\037]", " ", $s); */
$s = str_replace($control," ",$s);




if ($swedishmagic){
$s = str_replace("\345","\206",$s); // Code windows "&aring;" to dos.
$s = str_replace("\344","\204",$s); // Code windows "&auml;" to dos.
$s = str_replace("\366","\224",$s); // Code windows "&ouml;" to dos.
// $s = str_replace("\304","\216",$s); // Code windows "&Auml;" to dos.
//$s = "[ -~]\\xC4[a-za-z]";

// couldn't get ^ and $ to work, even through I read the man-pages,
// i'm probably too tired and too unfamiliar with posix regexps right now.
$s = ereg_replace("([ -~])\305([ -~])", "\\1\217\\2", $s); // &Aring;
$s = ereg_replace("([ -~])\304([ -~])", "\\1\216\\2", $s); // &Auml;
$s = ereg_replace("([ -~])\326([ -~])", "\\1\231\\2", $s); // &Ouml;

$s = str_replace("\311", "\220", $s); // &Eacute;
$s = str_replace("\351", "\202", $s); // &eacute;
}

$s = str_replace($table437, $tablehtml, $s);
return $s;
}
require_once("include/functions.php");
dbconn(false);
 if(!logged_in())
{
header("HTTP/1.0 404 Not Found");
// moddifed logginorreturn by retro//Remember to change the following line to match your server
print("<html><h1>Not Found</h1><p>The requested URL /{$_SERVER['PHP_SELF']} was not found on this server.</p><hr /><address>Apache/1.1.11 (xxxxx) Server at ".$_SERVER['SERVER_NAME']." Port 80</address></body></html>\n");
die();
}
parked();
$id = (int)$_GET["id"];
if (!is_valid_id($id))
die;

$r = mysql_query("SELECT name,nfo FROM torrents WHERE id=$id") or sqlerr();
$a = mysql_fetch_assoc($r) or die("Puke");

//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// view might be one of: "magic", "latin-1", "strict" or "fonthack"
$view = "";
if (isset($_GET["view"])) {
$view = unesc($_GET["view"]);
}
else {
$view = "magic"; // default behavior
}

$nfo = "";
if ($view == "latin-1" || $view == "fonthack") {
// Do not convert from ibm-437, read bytes as is.
// NOTICE: TBSource specifies Latin-1 encoding in include/bittorrent.php:
// stdhead()
$nfo = htmlentities(($a["nfo"]));
}
else {
// Convert from ibm-437 to html unicode entities.
// take special care of Swedish letters if in magic view.
$nfo = code($a["nfo"], $view == "magic");
}

stdhead();
print("<h1>NFO for <a href=details.php?id=$id>".htmlentities($a["name"])."</a></h1><p></p>\n");

?>
<table border="1" cellspacing="0" cellpadding="10" align="center">
<tr>
<?/*<td align="center" width="25%">
<a href="viewnfo.php?id=<?=$id?>&view=fonthack"
title="Teckensnittshack: Anv&auml;nder n&aring;gon av teckensnitten MS LineDraw eller Terminal"><b>Teckensnittshack</b></a></td>*/?>
<?/*<td align="center" width="25%">
<a href="viewnfo.php?id=<?=$id?>&view=strict"
title="Strikt: Visar nfo-filen som den ser ut i teckentabellen IBM-437">
<b>Strikt DOS-vy</b></a></td>*/?>
</tr>
<tr>
<td colspan="3">
<table border=1 cellspacing=0 cellpadding=5><tr><td class=text>
<?php
// -- About to output NFO data
if ($view == "fonthack") {
// Please notice: MS LineDraw's glyphs are included in the Courier New font
// as of Courier New version 2.0, but uses the correct mappings instead.
// http://support.microsoft.com/kb/q179422/
print("<pre style=\"font-size:10pt; font-family: 'MS LineDraw', 'Terminal', monospace;\">");
}
else {
// IE6.0 need to know which font to use, Mozilla can figure it out in its own
// (windows firefox at least)
// Anything else than 'Courier New' looks pretty broken.
// 'Lucida Console', 'FixedSys'
print("<pre style=\"font-size:9pt; font-family: 'Courier New', monospace;\">");
}
// Writes the (eventually modified) nfo data to output, first formating urls.
print(format_urls($nfo));
print("</pre>\n");
?>
</td></tr></table>
</td>
</tr>
</table>
<?
//error_reporting(0);
stdfoot();
?>