<?
ob_start("ob_gzhandler");
require "include/functions.php";
dbconn();
//referer();
stdhead("News");
begin_main_frame();
?>
<?
$file5 = "$CACHE/index/onews.txt";
$expire = 2*60; // 2 minutes
if (file_exists($file5) && filemtime($file5) > (time() - $expire)) {
    $onews2 = unserialize(file_get_contents($file5));
} else {
$res = mysql_query("select * from onews order by id");
while ($onews1 = mysql_fetch_array($res) ) {
        $onews2[] = $onews1;
    }
    $OUTPUT = serialize($onews2);
    $fp = fopen($file5,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
}
 // end else;
if ($onews2)
{

       foreach ($onews2 as $arr)
	{

if ($arr["public"]=="yes"){
echo("<br><table width=100% border=1 cellspacing=0 cellpadding=10>");
echo("<tr><td class=colhead>:: $arr[title]</td></tr><tr><td><ul>\n");
echo(stripslashes(BBCodeToHTML($arr["text"])));
echo("</td></tr>");
end_frame(); }
elseif($arr["public"]=="no" && $arr["class"]<=$CURUSER["class"]){
echo("<br><table width=100% border=1 cellspacing=0 cellpadding=10>");
echo("<tr><td class=colhead>:: $arr[title]</td></tr><tr><td><ul>\n");
echo(stripslashes(BBCodeToHTML($arr["text"])));
echo("</td></tr>");
end_frame();
}
}
  }
end_main_frame();
stdfoot(); ?>